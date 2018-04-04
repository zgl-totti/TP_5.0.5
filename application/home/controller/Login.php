<?php
namespace app\home\controller;

use app\admin\model\Admin;
use think\Controller;
use think\Loader;
use think\Session;

class Login extends Controller{
    public function index(){
        if(request()->isAjax()){
            $data['username']=trim(input('post.username'));
            $data['password']=trim(input('post.password'));
            $validate=Loader::validate('Admin');
            if($validate->scene('login')->check($data)){
                $where['username']=$data['username'];
                $info=Admin::get($where);
                if($info){
                    $admin['username']=$data['username'];
                    $admin['password']=md5(md5($data['password']).$info['token']);
                    $result=Admin::get($admin);
                    if($result){
                        if($result['status']==1){
                            $aid=Session::get('aid');
                            if($aid != $result['id']){
                                Session::set('aid',$result['id']);
                                $result->lastlogin=time();
                                $result->lastip=input('server.REMOTE_ADDR');
                                $result->save();
                                $res['status']=1;
                                $res['info']='登录成功！';
                                return $res;
                            }else {
                                $res['status']=5;
                                $res['info']='用户已登录！';
                                return $res;
                            }
                        }else{
                            $res['status']=5;
                            $res['info']='用户已停权！';
                            return $res;
                        }
                    }else{
                        $res['status']=5;
                        $res['info']='账号或密码错误！';
                        return $res;
                    }
                }else{
                    $res['status']=5;
                    $res['info']='用户不存在！';
                    return $res;
                }
            }else{
                $res['status']=5;
                $res['info']=$validate->getError();
                return $res;
            }
        }else{
            return $this->fetch();
        }
    }

    public function logout(){
        if(request()->isAjax()) {
            Session::delete('aid');
            $res['status'] = 1;
            $res['info'] = '退出成功';
            return $res;
        }
    }
}