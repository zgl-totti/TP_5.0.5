<?php

namespace app\common\swoole;

/*
 * 赛况实时数据后台添加并异步推送到客户端
 */
class Live
{
    public function push()
    {
        $data=input('post.');
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