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
    public function sendSms($data)
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
}