<?php

namespace app\common\service;

use app\common\model\Order;

class Skill
{
    public static $redisObj;

    /*
     * 连接
     */
    public static function connectRedis($config=[])
    {
        if(self::$redisObj) return self::$redisObj;

        $host=$config['host'] ?: '127.0.0.1';
        $port=$config['port'] ?: '6379';

        self::$redisObj = new \Redis();
        self::$redisObj->connect($host,$port);

        return self::$redisObj;
    }

    /*
     * 输出结果
     */
    public static function output($data=[],$error_code=0,$error_msg='ok')
    {
        $res=[
            'error_code'=>$error_code,
            'error_msg'=>$error_msg,
            'data'=>$data
        ];

        return json_encode($res);
    }




    /*
     * 以下内容为秒杀
     */

    //共享信息存在redis中，以hash表的形式存储，%s 变量代表的是商品ID;
    public static $userId;
    public static $productId;

    public static $REDIS_REMOTE_HT_KEY='product_%s';        //共享信息key
    public static $REDIS_REMOTE_TOTAL_COUNT='total_count';  //商品总库存
    public static $REDIS_REMOTE_USE_COUNT='used_count';     //商品已售库存

    public static $APCU_LOCAL_COUNT='apcu_total_count%s';   //本地总库存
    public static $APCU_LOCAL_USE='apcu_stock_use_%s';      //本地已售库存
    public static $APCU_LOCAL_STOCK='apcu_stock_%s';        //总共剩余库存

    public static $REDIS_REMOTE_QUEUE='c_order_queue';      //创建订单队列
    public static $REDIS_QUEUE_RANKING='queue_ranking_%s';   //订单队列排名

    public function __construct($productId,$userId)
    {
        self::$REDIS_REMOTE_HT_KEY=sprintf(self::$REDIS_REMOTE_HT_KEY,$productId);
        self::$APCU_LOCAL_COUNT=sprintf(self::$APCU_LOCAL_COUNT,$productId);
        self::$APCU_LOCAL_USE=sprintf(self::$APCU_LOCAL_USE,$productId);
        self::$APCU_LOCAL_STOCK=sprintf(self::$APCU_LOCAL_STOCK,$productId);
        self::$REDIS_QUEUE_RANKING=sprintf(self::$REDIS_QUEUE_RANKING,$userId);
    }

    /*
     * 查剩余库存
     */
    public static function getStock()
    {
        $stockNum=apcu_fetch(self::$APCU_LOCAL_STOCK);
        if($stockNum===false){
            $stockNum=self::initStock();
        }

        self::output(['stock_num'=>$stockNum]);
    }

    /*
     * 抢购 ---> 减库存
     * 抢购成功后，提示去订单中心查看排队情况及付款
     */
    public static function buy()
    {
        $localStockNum=apcu_fetch(self::$APCU_LOCAL_STOCK);
        if($localStockNum===false){
            $localStockNum=self::init();
        }

        $localUse=apcu_inc(self::$APCU_LOCAL_USE);  //本已卖 +1
        if($localUse>$localStockNum){
            self::output([],-1,'该商品已售完');
        }

        //同步已售库存+1;
        if(!self::incUseCount()){
            self::output([],-1,'该商品已售完');
        }

        //秒杀人数控制
        $count=self::connectRedis()->lLen(self::$REDIS_REMOTE_QUEUE);
        if($count>100){
            self::output([],-1,'秒杀已结束');
        }

        //写入创建订单队列
        $arr=json_encode(['user_id'=>self::$userId,'product_id'=>self::$productId,'time'=>microtime()]);
        self::connectRedis()->lPush(self::$REDIS_REMOTE_QUEUE,$arr);

        //排队进度
        $ranking=self::connectRedis()->lLen(self::$REDIS_REMOTE_QUEUE);
        self::connectRedis()->hSet(self::$REDIS_QUEUE_RANKING,self::$userId,$ranking);

        //返回抢购成功
        self::output([],0,'抢购成功，请从订单中心查看订单');
    }

    /*
     * 总剩余库存同步本地，定时执行
     */
    public static function sync()
    {
        $data=self::connectRedis()->hMGet(self::$REDIS_REMOTE_HT_KEY,[self::$REDIS_REMOTE_TOTAL_COUNT,self::$REDIS_REMOTE_USE_COUNT]);
        apcu_add(self::$APCU_LOCAL_STOCK,$data[1]-$data[2]);

        self::output([],0,'同步库存成功');
    }

    /*
     * 远端同步库存
     */
    private static function incUseCount()
    {
        //同步远端库存时,需要经过Lua脚本,保证不会出现超卖现象
        $script=<<<EOF
            local key = KEYS[1]
            local field1 = KEYS[2]
            local field2 = KEYS[3]
            local field1_val = redis.call('hget',key,field1)
            local field2_val = redis.call('hget',key,field2)
            if(field1_val > field2_val) then 
                return redis.call('HINCRBY',key,field2,1)
            end
            return 0
EOF;
        
        $arr=[self::$REDIS_REMOTE_HT_KEY,self::$REDIS_REMOTE_TOTAL_COUNT,self::$REDIS_REMOTE_USE_COUNT];

        return self::connectRedis()->eval($script,$arr,3);
    }

    /*
     * 初始化本地数据
     */
    private static function init()
    {
        apcu_add(self::$APCU_LOCAL_COUNT,150);
        apcu_add(self::$APCU_LOCAL_USE,0);
        return true;
    }

    private static function initStock()
    {
        $data=self::connectRedis()->hMGet(self::$REDIS_REMOTE_HT_KEY,[self::$REDIS_REMOTE_TOTAL_COUNT,self::$REDIS_REMOTE_USE_COUNT]);

        $num=$data['total_count']-$data['used_count'];
        apcu_add(self::$APCU_LOCAL_STOCK,$num);

        return $num;
    }

    /*
     * 订单处理（采用定时任务方式）
     */
    public function order_1()
    {
        $data=self::connectRedis()->rPop(self::$REDIS_REMOTE_QUEUE);
        $arr=json_decode($data,true);
        if(empty($arr) || !is_array($arr) || !isset($arr['user_id']) || !isset($arr['product_id'])){
            return;
        }

        $order = new Order();
        $order->order_sn='';
        $order->user_id=$arr['user_id'];
        $order->product_id=$arr['product_id'];
        $order->time=$arr['time'];
        $row=$order->save();
        if(!$row){
            self::connectRedis()->lPush(self::$REDIS_REMOTE_QUEUE,$data);
        }
    }

    /*
     * 订单处理（采用死循环方式）
     */
    public function order_2()
    {
        while(1) {
            $data = self::connectRedis()->rPop(self::$REDIS_REMOTE_QUEUE);
            $arr = json_decode($data, true);
            if (empty($arr) || !is_array($arr) || !isset($arr['user_id']) || !isset($arr['product_id'])) {
                sleep(2);
                continue;
            }

            $order = new Order();
            $order->order_sn = '';
            $order->user_id = $arr['user_id'];
            $order->product_id = $arr['product_id'];
            $order->time = $arr['time'];
            $row = $order->save();
            if (!$row) {
                self::connectRedis()->lPush(self::$REDIS_REMOTE_QUEUE, $data);
            }

            //每两秒执行一次
            sleep(2);
        }
    }
}