<?php

namespace app\common\service;


class WebSocket
{
    const HOST = '0.0.0.0';

    const PORT = '9501';

    public $server;

    public function __construct()
    {
        $this->server = new swoole_websocket_server(self::HOST, self::PORT);

        $this->server->on([
            'worker_num' => 2,
            'task_worker_num' => 2
        ]);

        $this->server->on('open', [$this, 'onOpen']);
        $this->server->on('message', [$this, 'onMessage']);
        $this->server->on('task', [$this, 'onTask']);
        $this->server->on('finish', [$this, 'onFinish']);
        $this->server->on('close', [$this, 'onClose']);

        $this->server->start();
    }

    /*
     * 监听连接事件
     */
    public function onOpen($server, $request)
    {
        var_dump($request->fd);

        if($request->fd==1){
            //每隔2秒执行一次
            swoole_timer_tick(2000,function ($timer){
                echo '2s:timerId_'.$timer;
            });
        }
    }

    /*
     * 监听消息事件
     */
    public function onMessage($server, $frame)
    {
        echo 'ser_push_message:' . $frame->data;

        $data = [
            'task' => 1,
            'fd' => $frame->fd
        ];

        //任务异步执行
        $server->task($data);

        //隔2秒后执行
        swoole_timer_after(2000,function () use ($server,$frame){
            echo '5s_after';

            $server->push($frame->fd, 'server_timer_after:' . date('Y-m-d H:i:s'));
        });

        $server->push($frame->fd, 'server_push:' . date('Y-m-d H:i:s'));
    }

    /*
     * 监听任务事件
     */
    public function onTask($server, $taskId, $workId, $data)
    {
        print_r($data);

        sleep(10);
        return 'on task finish';
    }

    /*
     * 监听任务完成事件
     */
    public function onFinish($server, $taskId, $data)
    {
        echo 'task_id:' . $taskId;
        echo 'finish_data_success:' . $data;
    }

    /*
     * 监听关闭事件
     */
    public function onClose($server, $fd)
    {
        echo 'client_id:' . $fd;
    }
}

new WebSocket();