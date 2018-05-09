<?php
namespace app\admin\controller;

use Think\Db;
use think\Request;
use think\Session;

class Admin extends Base{
    public function index(){
        $keywords=trim(Request::instance()->get('keywords'));
        if($keywords){
            $where['username']=['like',"%{$keywords}%"];
        }else{
            $where='';
        }
        //$adminList=model('Admin')->getList($where);

        $param['query']['keywords']=$keywords;
        $adminList=\app\common\model\Admin::get()->where($where)->paginate(10,false,$param);

        //$adminList=\app\common\model\Admin::get()->where($where)->paginate(5,false,['query'=>Request::instance()->param()]);

        foreach($adminList as $k=>$v){
            $info=Db::table('beauty_auth_group_access')->alias('ga')
                ->join('beauty_auth_group g','ga.group_id=g.id')
                ->field('g.title')
                ->where('ga.uid',$v['id'])
                ->select();
            $str='';
            foreach($info as $a){
                $str.=$a['title'].',';
            }
            $adminList[$k]['group']=substr($str,0,-1);
        }
        $this->assign('adminList', $adminList);
        $this->assign('keywords',$keywords);
        $this->assign('firstRow',($adminList->currentPage()-1)*$adminList->listRows());
        $this->assign('pages',$adminList->render());
        return $this->fetch('list');
    }

    public function add(){
        if (request()->isAjax()) {
            if(input('post.permissions')>0) {
                $where['id'] = session('aid');
                $where['permissions'] = 1;
                //判断管理权限;
                $pmsInfo=model('Admin')->getOne($where);
                if ($pmsInfo) {
                    $data['username'] = trim(input('post.username'));
                    $info=model('Amdin')->getOne($data);
                    if(!$info){
                        $data['password'] = md5(trim(input('post.password')));
                        $data['mobile'] = md5(trim(input('post.mobile')));
                        $data['addtime'] = time();
                        $data['edittime'] = time();
                        $data['permissions'] = input('post.permissions');
                        //添加数据到数据库;
                        $row=model('Admin')->addAdmin($data);
                        if ($row) {
                            $res['status']=1;
                            $res['info']='添加成功！';
                            return $res;
                        } else {
                            $res['status']=2;
                            $res['info']='添加失败！';
                            return $res;
                        }
                    }else{
                        $res['status']=3;
                        $res['info']='用户已存在！';
                        return $res;
                    }
                } else {
                    $res['status']=4;
                    $res['info']='你没有权限！';
                    return $res;
                }
            }else{
                $res['status']=5;
                $res['info']='请选择添加的管理员类型！';
                return $res;
            }
        } else {
            return $this->fetch();
        }
    }

    public function chkUsername(){
        $username = trim(input('post.username'));
        $where['username']=$username;
        $info=model('Admin')->getOne($where);
        if ($info) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function loginout(){
        $aid=Session::get('aid');
        $where['id']=$aid;
        $data['online']=0;
        $row=model('Admin')->saveAdmin($where,$data);
        if($row){
            Session::delete('aid');
            $res['status']=1;
            $res['info']='退出成功！';
            return $res;
        }else{
            $res['status']=2;
            $res['info']='退出失败！';
            return $res;
        }
    }

    //用AJAX方式更改管理员状态;
    public function operate(){
        if (request()->isAjax()) {
            $where['permissions'] = 1;
            $where['id'] = Session::get('aid');
            //判断管理权限;
            $pmsInfo=model('Admin')->getOne($where);
            if ($pmsInfo) {
                //判断你要操作的管理员的权限;
                $data['id'] = input('post.id');
                $psInfo=model('Admin')->getOne($data);
                //只能操作非超级管理员的权限;
                if($psInfo['permissions']!=1){
                    //更改要操作的管理员状态;
                    $status['status']=($psInfo['status']==0)?1:0;
                    $condition['id']=$psInfo['id'];
                    $row=model('Admin')->saveAdmin($condition,$status);
                    if($row){
                        $res['status']=1;
                        $res['info']='更改状态成功！';
                        return $res;
                    }else{
                        $res['status']=2;
                        $res['info']='更改状态失败！';
                        return $res;
                    }
                }else{
                    $res['status']=3;
                    $res['info']='你没有权限！';
                    return $res;
                }
            }else{
                $res['status']=4;
                $res['info']='你没有权限！';
                return $res;
            }
        }
    }

    //踢号操作;
    public function kick(){
        if (request()->isAjax()) {
            $where['permissions'] = 1;
            $where['id'] = Session::get('aid');
            //判断管理权限;
            $pmsInfo=model('Admin')->getOne($where);
            if ($pmsInfo) {
                //判断你要操作的管理员的权限;
                $data['id'] = input('post.id');
                $psInfo=model('Admin')->getOne($data);
                //只能操作非超级管理员的权限;
                if($psInfo['permissions']!=1){
                    //更改要操作的管理员状态;
                    $status['online']=0;
                    $condition['id']=$psInfo['id'];
                    $row=model('Admin')->saveAdmin($condition,$status);
                    if($row){
                        $res['status']=1;
                        $res['info']='更改状态成功！';
                        return $res;
                    }else{
                        $res['status']=2;
                        $res['info']='更改状态失败！';
                        return $res;
                    }
                }else{
                    $res['status']=3;
                    $res['info']='你没有权限！';
                    return $res;
                }
            }else{
                $res['status']=4;
                $res['info']='你没有权限！';
                return $res;
            }
        }
    }

    //修改个人信息操作;
    public function changeInfo(){
        return $this->fetch('Admin/changeInfo');
    }

    //验证手机号;
    public function chkMobile(){
        $where['id']=Session::get('aid');
        $where['mobile']=md5(trim(input('post.mobile')));
        $info=model('Admin')->getOne($where);
        if($info){
            echo 'true';
        }else{
            echo 'false';
        }
    }

    //验证密码;
    public function chkPwd(){
        $where['id']=Session::get('aid');
        $where['password']=md5(trim(I('post.pwd')));
        $info=model('Admin')->getOne($where);
        if($info){
            echo 'true';
        }else{
            echo 'false';
        }
    }

    //修改密码操作;
    public function changePwd(){
        if(request()->isAjax()){
            $data['id']=Session::get('aid');
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
                $res['info']='密保手机错误！';
                return $res;
            }
        }else{
            return $this->fetch('Admin/changeInfo');
        }
    }

    //修改手机号操作;
    public function changeMobile(){
        if(request()->isAjax()){
            $where['id']=Session::get('aid');
            $where['mobile']=md5(trim(input('post.mobile')));
            $info=model('Admin')->getOne($where);
            if($info){
                $data['mobile'] = md5(trim(input('post.newmobile')));
                $condition['id']=$info['id'];
                $row=model('Admin')->saveAdmin($condition,$data);
                if($row){
                    $res['status']=1;
                    $res['info']='手机号修改成功!';
                    return $res;
                }else{
                    $res['status']=2;
                    $res['info']='手机号修改失败!';
                    return $res;
                }
            }else{
                $res['status']=3;
                $res['info']='密保手机错误！';
                return $res;
            }
        }else{
            return $this->fetch('Admin/changeInfo');
        }
    }

    //编辑操作;
    public function edit(){
        if (request()->isAjax()){
            $username=trim(input('post.username'));
            $password=trim(input('post.password'));
            $id=input('post.id');
            if($username){
                if($password){
                    $data['username']=$username;
                    $data['password']=md5($password);
                }else{
                    $data['username']=$username;
                }
                $data['edittime'] = time();
                $where['id']=$id;
                $row=model('Admin')->saveAdmin($where,$data);
                if($row){
                    if(input('post.group_id')){
                        $condition['uid']=$id;
                        model('AuthGroup')->delAccess($condition);
                        foreach(input('post.group_id') as $v){
                            $info['uid'] = $id;
                            $info['group_id'] = $v;
                            model('AuthGroup')->addAccess($info);
                        }
                    }
                    $res['status']=1;
                    $res['info']='编辑成功!';
                    return $res;
                }else{
                    $res['status']=2;
                    $res['info']='编辑失败!';
                    return $res;
                }
            }else{
                $res['status']=3;
                $res['info']='用户名不能为空!';
                return $res;
            }
        } else {
            $id=input('param.id');
            $where['id']=$id;
            $adminInfo=model('Admin')->getOne($where);
            $condition['uid']=$id;
            $gid=model('AuthGroup')->selectGroupAccess($condition,$field='group_id');
            foreach ($gid as $v) {
                $arr[] = $v['group_id'];
            }
            $adminInfo['gid'] = $arr;
            $groupList = model('AuthGroup')->getGroup();
            $this->assign('groupList', $groupList);
            $this->assign('adminInfo', $adminInfo);
            return $this->fetch();
        }
    }
}
