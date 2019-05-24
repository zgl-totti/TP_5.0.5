<?php

namespace app\common\service\exception;

use think\Exception;
use think\Log;

class ErrorLog
{
    public static function recordErrorLog(Exception $e)
    {
        Log::init([
            'type'=>'File',
            'path'=>LOG_PATH,
            'level'=>['error']
        ]);

        Log::record($e->getMessage(),'error');
    }
}