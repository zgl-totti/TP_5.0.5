<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/10
 * Time: 9:01
 */

namespace app\common\lib\exception;


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