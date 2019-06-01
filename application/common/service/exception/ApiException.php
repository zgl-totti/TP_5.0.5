<?php

namespace app\common\service\exception;


use think\Exception;

class ApiException extends Exception
{
    public $message='';
    public $httpCode=500;
    public $code=0;


    public function __construct($message='',$httpCode=500,$code=0)
    {
        $this->message=$message;
        $this->httpCode=$httpCode;
        $this->code=$code;
    }
}