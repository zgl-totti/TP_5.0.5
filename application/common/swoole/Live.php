<?php

namespace app\common\swoole;


class Live
{
    public function push($data)
    {
        //高级用法：走task任务
        $taskData = [
            'method' => 'livePush',
            'data' => $data
        ];

        $_POST['http_server']->task($taskData);

        //基本用法
        //获取连接的用户
        $clients=Redis::sMembers('live_redis_key');

        //1.赛况的基本信息入库;2.数据组织好push到直播页面
        foreach ($clients as $fd) {
            $_POST['http_server']->push($fd,json_encode($data));
        }
    }
}