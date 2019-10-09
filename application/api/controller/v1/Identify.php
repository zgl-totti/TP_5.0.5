<?php

namespace app\api\controller\v1;

use app\api\controller\Common;
use app\common\service\Alidayu;
use think\Cache;

class Identify extends Common
{
    //设置短信验证码
    public function save(){
        if(!request()->isPost()){
            return api(0,'你提交的数据不合法',[],403);
        }
        //检验数据
        $validate=validate('Idenfity');
        if(!$validate->check(input('post.'))){
            return api(0,$validate->getError(),[],403);
        }

        $id=input('param.id');
        if(Alidayu::getInstance()->setSmsIdentify($id)){
            //清除缓存
            Cache::rm($id);
            return api(1,'ok',[],201);
        }else{
            return api(0,'error',[],403);
        }
    }
}