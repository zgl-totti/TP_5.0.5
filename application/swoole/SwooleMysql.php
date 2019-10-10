<?php

namespace app\common\service;


class SwooleMysql
{
    public $db;

    public $redis;

    public $config;

    public function __construct()
    {
        $this->db = new swoole_mysql;
        $this->redis = new swoole_redis;

        $this->config = [
            'host' => '192.168.56.102',
            'port' => 3306,
            'user' => 'test',
            'password' => 'test',
            'database' => 'test',
            'charset' => 'utf8', //指定字符集
            'timeout' => 2,  // 可选：连接超时时间（非查询超时时间），默认为SW_MYSQL_CONNECT_TIMEOUT（1.0）
        ];
    }

    /*
     * 执行mysql
     */
    public function execute()
    {
        $this->db->connect($this->config, function ($db, $r) {
            if ($r === false) {
                var_dump($db->connect_errno, $db->connect_error);
                die;
            }

            $sql = 'show tables';
            $db->query($sql, function (swoole_mysql $db, $r) {
                if ($r === false) {
                    var_dump($db->error, $db->errno);
                } elseif ($r === true) {
                    var_dump($db->affected_rows, $db->insert_id);
                }
                var_dump($r);
                $db->close();
            });
        });
    }

    /*
     * 执行redis
     */
    public function redis()
    {
        $server = $this->redis;
        $server->connect('127.0.0.1', '6379', function (swoole_redis $server, $result) {
            var_dump($result);

            $server->set('key', time(), function (swoole_redis $server, $res) {
                var_dump($res);
            });

            $server->get('key', function (swoole_redis $server, $res) {
                var_dump($res);

                $server->close();
            });
        });
    }

    /*
     * swoole子进程
     */
    public function process()
    {
        $process = new swoole_process(function (swoole_process $pro){
            //子进程
            //php redis.php
            $pro->exec('/usr/local/php/bin/php',[__DIR__ . '/WebSocket.php']);
        },false);

        $pid=$process->start();
        echo $pid;

        swoole_process::wait();
    }

    /*
     * 多进程场景
     */
    public function worker()
    {
        $workers=[];
        $urls=[
            'http://www.baidu.com',
            'https://www.issjy.com',
            'https://z.threelion.cn',
            'https://garbage.threelion.cn'
        ];

        for($i=0;$i<count($urls)+1;$i++){
            //子进程
            $process=new swoole_process(function (swoole_process $worker) use($urls,$i){
                $content=HttpClient::curl($urls[$i]);
                //输出到管道
                $worker->write($content);
                //第二个参数为true,表示不输出到屏幕
            },true);

            $pid=$process->start();
            $workers[$pid]=$process;
        }

        //多进程，总共只占用此前传统的同步顺序执行的一个请求的时间
        foreach ($workers as $process){
            echo $process->read();
        }
    }
}