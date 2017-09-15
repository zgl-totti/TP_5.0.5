<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/7
 * Time: 9:29
 */

namespace app\index\model;


class Mystica extends WeChat{
    public function index($factor){
        $method='wx_'.$factor;
        $wx=WeChat::$method();
        $weChat=$this->weChat($wx);
        return $weChat;
    }

    protected function weChat($wx){
        $num=count($wx);
        $key=mt_rand(0,$num-1);
        $weChat=$wx[$key];
        return $weChat;
    }
}