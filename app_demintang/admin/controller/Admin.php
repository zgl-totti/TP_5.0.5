<?php
namespace app\admin\controller;

use think\Loader;
use think\Session;

class Admin extends Base{
    public function index(){
        $keywords=trim(input('get.keywords'));
        if($keywords){
            $where['username|phone']=['like',"$keywords%"];
        }else{
            $where='';
        }
        $param['query']['keywords']=$keywords;
        $admin= new \app\common\model\Admin();
        $list=$admin->where($where)->paginate(10,false,$param);
        $this->assign('keywords',$keywords);
        $this->assign('list',$list);
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        $this->assign('page',$list->render());
        return $this->fetch();
    }

    public function add(){
        if(request()->isAjax()){
            $aid=Session::get('aid');
            $where['id']=$aid;
            $userinfo=\app\common\model\Admin::get($where);
            $data['username']=trim(input('post.username'));
            $data['password']=trim(input('post.password'));
            $data['repassword']=trim(input('post.repassword'));
            $data['phone']=trim(input('post.phone'));
            $data['permission']=trim(input('post.permission'));
            $validate=Loader::validate('Admin');
            if($validate->scene('add')->check($data)){
                if($data['password']==$data['repassword']){
                    $condition['username']=$data['username'];
                    $result=\app\common\model\Admin::get($condition);
                    if($result){
                        $res['status'] = 5;
                        $res['info'] = '用户名已存在！';
                        return $res;
                    }
                    if($userinfo['permission']==1) {
                        $admin['username'] = $data['username'];
                        $admin['phone'] = $data['phone'];
                        $admin['permission'] = $data['permission'];
                        $admin['token'] = uniqid();
                        $admin['password'] = md5(md5($data['password']) . $admin['token']);
                        $admin['addtime'] = time();
                        if($aid==1 || $admin['permission']!=1) {
                            $model= new \app\common\model\Admin();
                            $row=$model->save($admin);
                            if ($row) {
                                $res['status'] = 1;
                                $res['info'] = '添加成功！';
                                return $res;
                            } else {
                                $res['status'] = 5;
                                $res['info'] = '添加失败！';
                                return $res;
                            }
                        }else{
                            $res['status'] = 5;
                            $res['info'] = '你没有权限！';
                            return $res;
                        }
                    }else{
                        $res['status'] = 5;
                        $res['info'] = '你没有权限！';
                        return $res;
                    }
                }else{
                    $res['status']=5;
                    $res['info']='两次密码输入不一致！';
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

    //编辑
    public function edit(){
        if(request()->isAjax()){
            $aid=Session::get('aid');
            $userinfo=\app\common\model\Admin::get($aid);
            if($userinfo['permission']==1) {
                $id = input('post.id');
                $data['username'] = trim(input('post.username'));
                $data['phone'] = trim(input('post.phone'));
                $data['permission'] = trim(input('post.permission'));
                $password = trim(input('post.password'));
                $validate = Loader::validate('Admin');
                if ($validate->scene('edit')->check($data)) {
                    $info=\app\common\model\Admin::get($id);
                    if($aid==1 || $info['permission']!=1){
                        if($info['username'] != $data['username']){
                            $condition['username'] = $data['username'];
                            $arr=\app\common\model\Admin::get($condition);
                            if($arr){
                                $res['status'] = 5;
                                $res['info'] = '用户已存在！';
                                return $res;
                            }else{
                                $admin['username'] = $data['username'];
                            }
                        }
                        if($password) {
                            if (strlen($password) >= 5 && strlen($password) <= 12) {
                                $admin['token'] = uniqid();
                                $admin['password'] = md5(md5($password) . $admin['token']);
                            }else{
                                $res['status'] = 5;
                                $res['info'] = '密码长度必须在5到12位！';
                                return $res;
                            }
                        }
                        $admin['phone'] = $data['phone'];
                        $admin['permission'] = $data['permission'];
                        $admin['addtime'] = time();
                        $row = $info->save($admin);
                        if ($row) {
                            $res['status'] = 1;
                            $res['info'] = '编辑成功！';
                            return $res;
                        } else {
                            $res['status'] = 2;
                            $res['info'] = '编辑失败！';
                            return $res;
                        }
                    }else {
                        $res['status'] = 3;
                        $res['info'] = '你没有权限！';
                        return $res;
                    }
                } else {
                    $res['status'] = 5;
                    $res['info'] = $validate->getError();
                    return $res;
                }
            }else{
                $res['status'] = 6;
                $res['info'] = '你没有权限！';
                return $res;
            }
        }else{
            $id=input('param.id');
            $info=\app\common\model\Admin::get($id);
            $this->assign('info',$info);
            return $this->fetch();
        }
    }

    //改变状态
    public function operate(){
        if(request()->isAjax()){
            $aid=Session::get('aid');
            $admin=\app\common\model\Admin::get($aid);
            if($admin['permission']==1) {
                $id = input('post.id');
                $info = \app\common\model\Admin::get($id);
                if($aid==1 || $info['permission']!=1){
                    $status = ($info['status'] == 1) ? 2 : 1;
                    $info->status=$status;
                    $row = $info->save();
                    if ($row) {
                        $res['status'] = 1;
                        $res['info'] = '状态更改成功！';
                        return $res;
                    } else {
                        $res['status'] = 2;
                        $res['info'] = '状态更改失败！';
                        return $res;
                    }
                }else{
                    $res['status'] = 3;
                    $res['info'] = '无权限更改超级管理员状态！';
                    return $res;
                }
            }else{
                $res['status'] = 5;
                $res['info'] = '你没有权限！';
                return $res;
            }
        }
    }

    //删除
    public function del(){
        if(request()->isAjax()){
            $aid=Session::get('aid');
            $admin=\app\common\model\Admin::get($aid);
            if($admin['permission']==1) {
                $id = input('post.id');
                $info = \app\common\model\Admin::get($id);
                if($aid==1 || $info['permission']!=1){
                    $row = $info->delete();
                    if ($row) {
                        $res['status'] = 1;
                        $res['info'] = '删除成功！';
                        return $res;
                    } else {
                        $res['status'] = 2;
                        $res['info'] = '删除失败！';
                        return $res;
                    }
                }else{
                    $res['status'] = 3;
                    $res['info'] = '无权限删除超级管理员！';
                    return $res;
                }
            }else{
                $res['status'] = 5;
                $res['info'] = '你没有权限！';
                return $res;
            }
        }
    }

    //修改个人信息
    public function changeInfo(){
        if(request()->isAjax()){
            $id=session('aid');
            $info=\app\common\model\Admin::get($id);
            $status=trim(input('post.status'));
            if($status==1){
                $data['password']=trim(input('post.password'));
                $data['repassword']=trim(input('post.repassword'));
                $data['phone']=trim(input('post.phone'));
                $validate=Loader::validate('Admin');
                if($validate->scene('change1')->check($data)){
                    if($info['phone'] != $data['phone']){
                        $res['status'] = 5;
                        $res['info'] = '密保手机错误';
                        return $res;
                    }
                    $admin['token'] = uniqid();
                    $admin['password'] = md5(md5($data['password']) . $admin['token']);
                }else{
                    $res['status'] = 5;
                    $res['info'] = $validate->getError();
                    return $res;
                }
            }elseif($status==2){
                $data['password']=trim(input('post.password'));
                $data['phone']=trim(input('post.phone'));
                $data['newphone']=trim(input('post.newphone'));
                $data['rephone']=trim(input('post.rephone'));
                $validate=Loader::validate('Admin');
                if($validate->scene('change2')->check($data)){
                    $password=md5(md5($data['password']) . $info['token']);
                    if($info['password'] != $password){
                        $res['status'] = 5;
                        $res['info'] = '密码错误';
                        return $res;
                    }
                    $admin['phone'] = $data['newphone'];
                }else{
                    $res['status'] = 5;
                    $res['info'] = $validate->getError();
                    return $res;
                }
            }
            $row=$info->save($admin);
            if ($row) {
                $res['status'] = 1;
                $res['info'] = '修改成功！';
                return $res;
            } else {
                $res['status'] = 2;
                $res['info'] = '修改失败！';
                return $res;
            }
        }else{
            return $this->fetch();
        }
    }
}