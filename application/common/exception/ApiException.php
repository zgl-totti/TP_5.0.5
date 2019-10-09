<?php

namespace app\common\exception;

use think\Exception;

class ApiException extends Exception
{
    public $code;

    public $message;

    public $httpCode;

    public function __construct($message, $httpCode, $code = 0)
    {
        $this->code = $code;
        $this->message = $message;
        $this->httpCode = $httpCode;
    }
}