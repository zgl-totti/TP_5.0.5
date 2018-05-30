<?php
/**
 * Created by PhpStorm.
 * User: zgl
 * Date: 2018/5/22
 * Time: 23:42
 */

namespace app\api\controller\v1;


use app\common\lib\Aes;
use app\common\lib\Alidayu;
use app\common\lib\Auth;
use app\common\model\User;

class Login
{
    public function save(){
        if(!request()->isPost()){
            return api(0,'你没有权限',[],403);
        }

        $post=input('post.');
        if(empty($post['phone'])){
            return api(0,'手机不合法',[],403);
        }

        if(empty($post['code'])){
            return api(0,'手机短信验证码不合法',[],403);
        }

        if($post['code']){
            $code=Alidayu::getInstance()->checkSmsIdentify($post['phone']);
            if($code != Aes::decrypt($post['code'])){
                return api(0,'验证码错误',[],403);
            }
        }


        $token=Auth::setAppLoginToken($post['phone']);

        $user=User::get(['phone'=>$post['phone']]);
        if(empty($user) || $user->status != 1){
            $data=[
                'token'=>$token,
                'phone'=>$post['phone'],
                'time_out'=>strtotime('+'.config('app.login_time_out_day'.'days'))
            ];
            $row=(new User())->save($data);
            if($row){
                $res=[
                    'token'=>(new Aes())->encrypt($token.'&&'.time()),
                ];
                return api(1,'登录成功',$res,201);
            }
            return api(1,'登录失败',[],400);
        }

        if($post['password']){
            if(md5($post['password']) != $user->password){
                return api(0,'密码不正确',[],403);
            }
        }

        $data=[
            'token'=>$token,
            'phone'=>$post['phone'],
            'time_out'=>strtotime('+'.config('app.login_time_out_day'.'days'))
        ];

        $row2=$user->save($data);
        if($row2){
            return api(1,'登录成功',[],201);
        }
    }
}