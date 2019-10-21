<?php

namespace app\common\swoole;

/*
 * swoole异步发送验证码
 */
class Send
{
    /*
     * 测试：swoole发送
     */
    public static function swoole($phone)
    {
        $code = rand(1000, 9999);

        $taskData = [
            'method' => 'sendSms',
            'data' => [
                'phone' => $phone,
                'code' => $code
            ]
        ];

        $_POST['http_server']->task($taskData);

        return true;
    }
}