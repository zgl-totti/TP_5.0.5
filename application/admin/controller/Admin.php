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
        $data['query']['keywords']=$keywords;
        $list=\app\common\model\Admin::where($where)->paginate(10,false,$data);
        $firstRow=($list->currentPage()-1)*$list->listRows();
        $this->assign('keywords',$keywords);
        $this->assign('list',$list);
        $this->assign('pages',$list->render());
        $this->assign(compact('firstRow'));
        return $this->fetch();
    }

    //测试复杂sql语句
    public function test(){
        $where['username']=input('post.username');
        $keywords=input('post.keywords');

        $field="date_format('create_time', '%y-%m-%d') as 'data',
        sum('binary total') as 'total',
        sum(IF(is_register= 0,1,0)) as 't1',
        sum(IF(is_register= 1,1,0)) as 't2' ";

        $list=\app\common\model\Admin::where($where)
            ->field($field)
            ->where(function ($query) use ($keywords){
                $keywords && $query->where('username','like',$keywords);
            })
            ->group('day')
            ->select();

        return $list;
    }

    public function add(){
        if(request()->isAjax()){
            /*$aid=Session::get('aid');
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
            }*/

            $aid=Session::get('aid');
            $userinfo=\app\common\model\Admin::get($aid);
            $data['username']=trim(input('post.username'));
            $data['password']=trim(input('post.password'));
            $data['pwd']=trim(input('post.pwd'));
            $data['phone']=trim(input('post.phone'));
            $data['permission']=trim(input('post.permission'));
            $data['avatar']=trim(input('post.avatar'));
            $validate=Loader::validate('Admin');
            if($validate->scene('add')->check($data)){
                if($userinfo['permission']==1) {
                    $admin['username'] = $data['username'];
                    $admin['phone'] = $data['phone'];
                    $admin['permission'] = $data['permission'];
                    $admin['avatar'] = $data['avatar'];
                    $admin['token'] = uniqid();
                    $admin['password'] = md5(md5($data['password']) . $data['token']);
                    $admin['addtime'] = time();
                    if($aid==1 || $admin['permission']!=1) {
                        $arr= new \app\common\model\Admin();
                        $row=$arr->save($admin);
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
            $userinfo=\app\common\model\Admin::get($aid);
            if($userinfo['permission']==1) {
                $id = input('post.id');
                $data['username'] = trim(input('post.username'));
                $data['password'] = trim(input('post.password'));
                $data['phone'] = trim(input('post.phone'));
                $data['permission'] = trim(input('post.permission'));
                $data['avatar'] = trim(input('post.avatar'));
                $validate = Loader::validate('Admin');
                if ($validate->scene('edit')->check($data)) {
                    $condition['username'] = $data['username'];
                    $info=\app\common\model\Admin::get($condition);
                    if (!$info) {
                        $editinfo=\app\common\model\Admin::get($id);
                        if($aid==1 || $editinfo['permission']!=1){
                            $admin['username'] = $data['username'];
                            $admin['phone'] = $data['phone'];
                            $admin['permission'] = $data['permission'];
                            $admin['avatar'] = $data['avatar'];
                            $admin['token'] = uniqid();
                            $admin['password'] = md5(md5($data['password']) . $data['token']);
                            $admin['addtime'] = time();
                            $arr= new \app\common\model\Admin();
                            $row=$arr->save($admin);
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
            $info=\app\common\model\Admin::get($id);
            $this->assign('info',$info);
            return $this->fetch();
        }
    }

    //改变状态
    public function changestatus(){
        if(request()->isAjax()){
            $aid=Session::get('aid');
            $admin=\app\common\model\Admin::get($aid);
            if($admin['permission']==1) {
                $id = input('post.id');
                $info=\app\common\model\Admin::get($id);
                if($info['permission']!=1) {
                    $info->status = ($info['status'] == 1) ? 2 : 1;
                    $row=$info->save();
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
                $info=\app\common\model\Admin::get($id);
                if($info['permission']!=1) {
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
    public function changeinfo(){
        if(request()->isAjax()){
            $id=input('post.id');
            $password=trim(input('post.password'));
            $data['phone']=trim(input('post.phone'));
            $data['avatar']=trim(input('post.avatar'));
            $admin=\app\common\model\Admin::get($id);
            if($password){
                $admin->token=uniqid();
                $admin->password=md5(md5($password).$data['token']);
            }
            $admin->phone=$data['phone'];
            $admin->avatar=$data['avatar'];
            $row=$admin->save();
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
            $aid=Session::get('aid');
            $info=\app\common\model\Admin::get($aid);
            $this->assign('info',$info);
            return $this->fetch();
        }
    }
}