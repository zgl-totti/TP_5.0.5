<?php
namespace app\admin\controller;

use think\Controller;
use think\Loader;
use think\Session;

class Login extends Controller{
    public function index(){
        if(request()->isAjax()){
            $data['username']=trim(input('post.username'));
            $data['password']=trim(input('post.password'));
            $validate=Loader::validate('Admin');
            if($validate->check($data)){
                $where['username']=$data['username'];
                $info=model('Admin')->getOne($where);
                if($info){
                    $admin['username']=$data['username'];
                    $admin['password']=md5(md5($data['password']).$info['token']);
                    $result=model('Admin')->getOne($admin);
                    if($result){
                        $aid=Session::get('aid');
                        if(!$aid==$result['id']){
                            Session::set('aid',$result['id']);
                            $condition['id']=$result['id'];
                            $update['lastlogin']=time();
                            $update['lastip']=input('server.REMOTE_ADDR');
                            model('Admin')->save($condition,$update);
                            $res['status']=1;
                            $res['info']='登录成功！';
                            return $res;
                        }else {
                            $res['status']=2;
                            $res['info']='用户已登录！';
                            return $res;
                        }
                    }else{
                        $res['status']=3;
                        $res['info']='账号或密码错误！';
                        return $res;
                    }
                }else{
                    $res['status']=4;
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

    public function register(){
        if(request()->isAjax()){
            $data['username']=trim(input('post.username'));
            $data['password']=trim(input('post.password'));
            $validate=Loader::validate('Admin');
            if($validate->check($data)){
                $where['username']=$data['username'];
                $info=model('Admin')->getOne($where);
                if(!$info){
                    $admin['username']=$data['username'];
                    $admin['token']=uniqid();
                    $admin['password']=md5(md5($data['password']).$admin['token']);
                    $admin['addtime']=time();
                    $result=model('Admin')->add($admin);
                    if($result){
                        $res['status']=1;
                        $res['info']='注册成功！';
                        return $res;
                    }else{
                        $res['status']=2;
                        $res['info']='注册失败！';
                        return $res;
                    }
                }else{
                    $res['status']=3;
                    $res['info']='用户已存在！';
                    return $res;
                }
            }else{
                $res['status']=4;
                $res['info']=$validate->getError();
                return $res;
            }
        }else{
            return $this->fetch();
        }
    }

    public function loginout(){
        Session::delete('aid');
        $this->redirect('index');
    }
}