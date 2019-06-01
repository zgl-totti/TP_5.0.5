<?php

namespace app\common\service\exception;


use think\exception\Handle;

class ApiHandleException extends Handle
{
    public $httpCode=500;

    public function render(\Exception $e)
    {
        if(config('app_debug') == true){
            return parent::render($e);
        }

        if ($e instanceof ApiException) {
            $this->httpCode=$e->httpCode;
        }

        return api(0,$e->getMessage(),[],$this->httpCode);
    }
}