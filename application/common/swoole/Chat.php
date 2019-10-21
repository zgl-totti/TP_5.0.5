<?php

namespace app\common\swoole;

/*
 * 聊天室实时更新
 */
class Chat
{
    public function index()
    {
        $data=input('post.');

        $arr=$_POST['http_server']->ports[1]->connections;
        foreach ($arr as $fd) {
            $_POST['http_server']->push($fd,json_encode($data));
        }

        return true;
    }
}