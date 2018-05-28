<?php
/**
 * Created by PhpStorm.
 * User: zgl
 * Date: 2018/5/28
 * Time: 21:46
 */

namespace app\api\controller\v1;


use app\common\lib\Aes;

class User extends AuthBase
{
    //用户基本信息，隐私信息必须加密
    public function read()
    {
        $user=(new Aes)->encrypt($this->user);
        return api(1,'ok',$user,200);
    }

}