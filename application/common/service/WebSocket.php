<?php

namespace app\common\service;


class WebSocket
{
    const HOST = '0.0.0.0';

    const PORT = '9501';

    public $server;

    public function __construct()
    {
        $this->server = new swoole_websocket_serer(self::HOST, self::PORT);

        $this->server->on('open', [$this, 'onOpen']);
        $this->server->on('message', [$this, 'onMessage']);
        $this->server->on('close', [$this, 'onClose']);

        $this->server->start();
    }

    /*
     * 监听连接事件
     */
    public function onOpen($server, $request)
    {
        var_dump($request->fd);
    }

    /*
     * 监听消息事件
     */
    public function onMessage($server, $frame)
    {
        echo 'ser_push_message:' . $frame->data;
        $server->push($frame->fd, 'server_push:' . date('Y-m-d H:i:s'));
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