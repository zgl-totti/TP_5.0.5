<?php
namespace app\admin\controller;

use think\Loader;
use think\Session;

class Admin extends Base{
    public function index(){
        if(request()->isGet()){
            $keywords=trim(input('get.keywords'));
        }
        if($keywords){
            $where=['username|phone'=>"%$keywords%"];
        }else{
            $where='';
        }
        $list=model('Admin')->getList($where,10);
        $this->assign('keywords',$keywords);
        $this->assign('list',$list);
        $this->assign('page',$list->render());
        return $this->fetch();
    }

    public function add(){
        if(request()->isAjax()){
            $aid=Session::get('aid');
            $where['id']=$aid;
            $userinfo=model('Admin')->getOne($where);
            $data['username']=trim(input('post.username'));
            $data['password']=trim(input('post.password'));
            $data['pwd']=trim(input('post.pwd'));
            $data['phone']=trim(input('post.phone'));
            $data['permission']=trim(input('post.permission'));
            $data['avatar']=trim(input('post.avatar'));
            $validate=Loader::validate('Admin');
            if($validate->check($data)){
                if($data['password']==$data['pwd']){
                    if($userinfo['permission']==1) {
                        $admin['username'] = $data['username'];
                        $admin['phone'] = $data['phone'];
                        $admin['permission'] = $data['permission'];
                        $admin['avatar'] = $data['avatar'];
                        $admin['token'] = uniqid();
                        $admin['password'] = md5(md5($data['password']) . $data['token']);
                        $admin['addtime'] = time();
                        if($aid==1 || $admin['permission']!=1) {
                            $row = model('Admin')->addAdmin($admin);
                            if ($row) {
                                $res['status'] = 1;
                                $res['info'] = '添加成功！';
                                return $res;
                            } else {
                                $res['status'] = 2;
                                $res['info'] = '添加失败！';
                                return $res;
                            }
                        }else{
                            $res['status'] = 3;
                            $res['info'] = '你没有权限！';
                            return $res;
                        }
                    }else{
                        $res['status'] = 4;
                        $res['info'] = '你没有权限！';
                        return $res;
                    }
                }else{
                    $res['status']=5;
                    $res['info']='两次密码输入不一致！';
                    return $res;
                }
            }else{
                $res['status']=6;
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
            $think['id']=$aid;
            $userinfo=model('Admin')->getOne($think);
            if($userinfo['permission']==1) {
                $id = input('post.id');
                $where['id'] = $id;
                $data['username'] = trim(input('post.username'));
                $data['password'] = trim(input('post.password'));
                $data['phone'] = trim(input('post.phone'));
                $data['permission'] = trim(input('post.permission'));
                $data['avatar'] = trim(input('post.avatar'));
                $validate = Loader::validate('Admin');
                if ($validate->check($data)) {
                    $condition['username'] = $data['username'];
                    $info = model('Admin')->getOne($condition);
                    if (!$info) {
                        $editinfo=model('Admin')->getOne($where);
                        if($aid==1 || $editinfo['permission']!=1){
                            $admin['username'] = $data['username'];
                            $admin['phone'] = $data['phone'];
                            $admin['permission'] = $data['permission'];
                            $admin['avatar'] = $data['avatar'];
                            $admin['token'] = uniqid();
                            $admin['password'] = md5(md5($data['password']) . $data['token']);
                            $admin['addtime'] = time();
                            $row = model('Admin')->saveAdmin($where, $admin);
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
                        $res['status'] = 4;
                        $res['info'] = '用户已存在！';
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
            $where['id']=$id;
            $info=model('Admin')->getOne($where);
            $this->assign('info',$info);
            return $this->fetch();
        }
    }

    //改变状态
    public function changestatus(){
        if(request()->isAjax()){
            $aid=Session::get('aid');
            $condition['id']=$aid;
            $admin=model('Admin')->getOne($condition);
            if($admin['permission']==1) {
                $id = input('post.id');
                $where['id'] = $id;
                $info = model('Admin')->getOne($where);
                if ($info) {
                    if(!$info['permission']==1) {
                        $status['status'] = ($info['status'] == 1) ? 2 : 1;
                        $row = model('Admin')->saveAdmin($where, $status);
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
                } else {
                    $res['status'] = 4;
                    $res['info'] = '管理员不存在！';
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
            $condition['id']=$aid;
            $admin=model('Admin')->getOne($condition);
            if($admin['permission']==1) {
                $id = input('post.id');
                $where['id'] = $id;
                $info = model('Admin')->getOne($where);
                if ($info) {

                    if(!$info['permission']==1) {
                        $row = model('Admin')->del($where);
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
                } else {
                    $res['status'] = 4;
                    $res['info'] = '管理员不存在！';
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
    public function changeinfo(){
        if(request()->isAjax()){
            $id=input('post.id');
            $where['id']=$id;
            $password=trim(input('post.password'));
            $data['phone']=trim(input('post.phone'));
            $data['avatar']=trim(input('post.avatar'));
            if($password){
                $data['token']=uniqid();
                $data['password']=md5(md5($password).$data['token']);
                $row=model('Admin')->saveAdmin($where,$data);
                if($row){
                    $res['status'] = 1;
                    $res['info'] = '修改成功！';
                    return $res;
                }else{
                    $res['status'] = 2;
                    $res['info'] = '修改失败！';
                    return $res;
                }
            }else{
                $row=model('Admin')->saveAdmin($where,$data);
                if($row){
                    $res['status'] = 1;
                    $res['info'] = '修改成功！';
                    return $res;
                }else{
                    $res['status'] = 2;
                    $res['info'] = '修改失败！';
                    return $res;
                }
            }
        }else{
            $aid=Session::get('aid');
            $where['id']=$aid;
            $info=model('Admin')->getOne($where);
            $this->assign('info',$info);
            return $this->fetch();
        }
    }
}