<?php

namespace app\common\swoole;

use app\common\service\Alidayu;
use think\Cache;

/*
 * swoole里面所有的 task异步任务
 */
class Task
{
    /*
     * 异步发送验证码
     */
    public function sendSms($server,$data)
    {
        $phone = $data['phone'];
        $code = $data['code'];

        try {
            $result = Alidayu::getInstance()->setSmsIdentify($phone, $code);
        } catch (\Exception $e) {
            return false;
        }

        if ($result) {
            //设置验证码失效时间
            Cache::set($phone, $code, config('ali.identify_time'));

            return true;
        }

        return false;
    }

    /*
     * 通过task机制发送实时数据给客户端
     */
    public function livePush($server,$data)
    {
        //获取连接的用户
        $clients=Redis::sMembers('live_redis_key');

        //1.赛况的基本信息入库;2.数据组织好push到直播页面
        foreach ($clients as $fd) {
            $server->push($fd,json_encode($data));
        }
    }
}