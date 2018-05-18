<?php
namespace app\api\controller;

use app\common\lib\Auth;
use app\common\lib\exception\ApiException;
use think\Cache;
use think\Controller;

class Common extends Controller
{
    public $headers;
    /**
     * 初始化方法
     */
    public function _initialize()
    {
        $this->checkRequestAuth();
    }

    /**
     * 检查请求是否合法
     * @return \think\response\Json
     */
    public function checkRequestAuth()
    {
        $headers=request()->header();

        //基础参数校验
        if(empty($headers['sign'])) {
            throw new ApiException('sign不合法',400);
        }

        if(empty($headers['type']) || !in_array($headers['type'],config('app.app_types'))){
            throw new ApiException('app类型不合法',400);
        }

        //校验sign合法性
        if(!Auth::checkSign($headers)){
            throw new ApiException('校验失败',401);
        }

        Cache::set($headers['sign'],1,config('app.app_sign_cache_time'));

        $this->headers=$headers;
    }
}