<?php
namespace app\admin\controller;

use app\common\model\Admin;
use think\Controller;
use think\Db;
use think\Loader;
use think\Session;

class Login extends Controller{
    public function index(){
        if(request()->isAjax()){
            $data['username']=trim(input('post.username'));
            $data['password']=trim(input('post.password'));
            $data['verify']=trim(input('post.verify'));
            $validate= Loader::validate('Admin');
            if($validate->scene('login')->check($data)){
                $arr['username']=$data['username'];
                $arr['password']=md5($data['password']);
                $info=Admin::get($arr);
                if($info){
                    if($info['status']==1){
                        $update['lastlogin'] = time();
                        $update['lastip'] = input('server.REMOTE_ADDR');
                        $info->save($update);
                        Session::set('aid', $info['id']);
                        $res['status'] = 1;
                        $res['info'] = '登录成功！';
                        return $res;
                    }else{
                        $res['status']=5;
                        $res['info']='账号已停权！';
                        return $res;
                    }
                }else{
                    $res['status']=5;
                    $res['info']='账号或密码错误！';
                    return $res;
                }
            }else{
                $res['status']=5;
                $res['info']=$validate->getError();
                return $res;
            }
        }else{
            return $this->fetch('login');
        }
    }

    public function logout(){
        if(request()->isAjax()){
            Session::delete('aid');
            $res['status']=1;
            $res['info']='退出成功！';
            return $res;
        }
    }

    //验证手机号;
    public function chkMobile(){
        $where['mobile']=md5(trim(input('post.mobile')));
        $info=model('Admin')->getOne($where);
        if($info){
            echo 'true';
        }else{
            echo 'false';
        }
    }

    public function chkAdmin(){
        $username=trim(input('post.username'));
        $where['username']=$username;
        $info=model('Admin')->getOne($where);
        if($info){
            echo 'true';
        }else{
            echo 'false';
        }
    }

    //忘记密码;
    public function forgetPwd(){
        if(request()->isAjax()){
            $data['username']=trim(input('post.username'));
            $data['mobile']=md5(trim(input('post.mobile')));
            $info=model('Admin')->getOne($data);
            if($info){
                $update['password']=md5(trim(input('post.password')));
                $where['id']=$info['id'];
                $row=model('Admin')->saveAdmin($where,$update);
                if($row){
                    $res['status']=1;
                    $res['info']='修改密码成功！';
                    return $res;
                }else{
                    $res['status']=2;
                    $res['info']='修改密码失败！';
                    return $res;
                }
            }else{
                $res['status']=3;
                $res['info']='用户不存在！';
                return $res;
            }
        }else{
            return $this->fetch('forgetPwd');
        }
    }


    /**
     * 返回封装后的API数据到客户端
     * @access protected
     * @param mixed     $data 要返回的数据
     * @param integer   $code 返回的code
     * @param mixed     $msg 提示信息
     * @param string    $type 返回数据格式
     * @param array     $header 发送的Header信息
     * @return void
     */
    //protected function result($data, $code = 0, $msg = '', $type = '', array $header = [])

    public function roma(){
        $res['status']=1;
        $info['id']=100;
        $info['club']='roma';
        $res['info']=$info;
        $this->result($info,100,'haha','json');
    }
}