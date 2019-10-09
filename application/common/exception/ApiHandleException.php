<?php

namespace app\common\exception;

use think\exception\Handle;

class ApiHandleException extends Handle
{
    public $httpCode = 500;

    public function render(\Exception $e)
    {
        if (config('app_debug') == true) {
            return parent::render($e);
        }

        if ($e instanceof ApiException) {
            $this->httpCode = $e->httpCode;
        }

        $data = [
            'code' => $e->getCode(),
            'msg' => $e->getMessage()
        ];

        return json($data, $this->httpCode);
        //return api(0,$e->getMessage(),[],$this->httpCode);
    }
}