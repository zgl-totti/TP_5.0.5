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
        //连接
        $this->db->connect($this->config, function ($db, $r) {
            if ($r === false) {
                var_dump($db->connect_errno, $db->connect_error);
                die;
            }

            //mysql逻辑
            $sql = 'show tables';
            $db->query($sql, function (swoole_mysql $db, $r) {
                if ($r === false) {
                    var_dump($db->error, $db->errno);
                } elseif ($r === true) {
                    var_dump($db->affected_rows, $db->insert_id);
                }

                var_dump($r);

                //关闭数据库
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
        $process = new swoole_process(function (swoole_process $pro) {
            //子进程
            //php redis.php
            $pro->exec('/usr/local/php/bin/php', [__DIR__ . '/WebSocket.php']);
        }, false);

        $pid = $process->start();
        echo $pid;

        swoole_process::wait();
    }

    /*
     * 多进程场景
     */
    public function worker()
    {
        $workers = [];
        $urls = [
            'http://www.baidu.com',
            'https://www.issjy.com',
            'https://z.threelion.cn',
            'https://garbage.threelion.cn'
        ];

        for ($i = 0; $i < count($urls) + 1; $i++) {
            //子进程
            $process = new swoole_process(function (swoole_process $worker) use ($urls, $i) {
                //输出到管道
                $content = HttpClient::curl($urls[$i]);
                $worker->write($content);//输出到管道
            }, true);//第二个参数为true,表示不输出到屏幕

            $pid = $process->start();
            $workers[$pid] = $process;
        }

        //多进程，总共只占用此前传统的同步顺序执行的一个请求的时间
        foreach ($workers as $k => $process) {
            //添加进程事件
            swoole_event_add($process->pipe, function ($pipe) use ($process) {
                echo $process->read();//读取数据

                //删除句柄
                swoole_event_del($process->pipe);
                //或者
                fclose($process->pipe);
            });

            echo $process->read();//读取数据
        }
    }

    /*
     * 进程间队列通信
     */
    public function queue()
    {
        $workers = [];
        $worker_num = 2;
        for ($i = 0; $i < $worker_num; $i++) {
            //子进程
            $process = new swoole_process(function (swoole_process $worker) {
                //从主进程队列里取数据
                $worker->pop();//默认为8192个数据
                $worker->exit(0);//退出
            }, true);//第二个参数为true,表示不输出到屏幕

            //开启队列，类似于全局函数
            $process->useQueue();

            $pid = $process->start();
            $workers[$pid] = $process;
        }

        //多进程，总共只占用此前传统的同步顺序执行的一个请求的时间
        foreach ($workers as $k => $process) {
            //主进程往子进程添加数据
            $process->push('hello,子进程' . $k);
        }

        //等待，子进程结束，回收资源
        for ($i = 0; $i < $worker_num; $i++) {
            $res = swoole_precess::wait();//等待执行完成
            $pid = $res['pid'];

            unset($workers[$pid]);
            echo '子进程退出' . $pid . '\n';
        }
    }

    /*
     * 信号触发
     */
    public function signal()
    {
        //触发函数，异步执行
        swoole_process::signal(SIGALRM,function (){
            echo "1\n";

            //达到10停止
            static $i=0;
            echo "$i \n";
            if($i>10){
                swoole_process::alarm(-1);//清除定时器
            }
        });

        //定时信号
        swoole_process::alarm(100*1000);
    }

    /*
     * 锁机制
     */
    public function lock()
    {
        //创建锁对象
        $lock=swoole_lock(SWOOLE_MUTEX);//互斥锁
        $lock->lock();//锁定主进程

        if(pcntl_fork()>0) {
            //主进程
            sleep(1);
            $lock->unlock();//解锁
        }else{
            //子进程
            echo "子进程等待锁 \n";
            $lock->lock();//上锁
            echo "子进程获取锁 \n";
            $lock->unlock();//释放锁

            exit('子进程退出');
        }

        echo '主进程释放锁';
        unset($lock);
        sleep(1);
        echo '子进程退出';
    }

    /*
     * DNS查询
     */
    public function dns()
    {
        swoole_async_dns_lookup('www.baidu.com',function($host,$ip){
            echo $host.' 的IP地址是 '.$ip;
        });
    }

    /*
     * 异步读写文件
     */
    public function file()
    {
        //异步读取文件
        swoole_async_readfile(__DIR__.'/1.txt',function ($filename,$content){
            echo $filename.':'.$content;
        });

        //异步写入文件，放到内存，最大4M
        $content='哈哈哈哈哈hahahaha';
        swoole_async_writefile(__DIR__.'/2.txt',$content,function ($filename){
            echo $filename;
        },'FILE_APPEND');//追加的方式写入
    }
}