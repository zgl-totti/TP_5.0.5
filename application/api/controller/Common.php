<?php
namespace app\api\controller;

use think\Controller;

class Common extends Controller
{
    public function __construct()
    {
        $this->checkSign();
    }

    public function checkSign()
    {
        $headers=input('param.');
        if(empty($headers['sign']))
        {
            return api(0,'非法操作',[],401);
        }


    }
}