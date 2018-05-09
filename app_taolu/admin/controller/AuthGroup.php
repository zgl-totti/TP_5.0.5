<?php
namespace app\admin\controller;

use think\Db;

class Authgroup extends Base{

    //管理组列表;
    public function index(){
        $groupList=model('AuthGroup')->getGroupList();
        $this->assign('groupList',$groupList);
        return $this->fetch();
    }

    //添加管理组;
    public function add(){
        if(request()->isAjax()){
            $data['title']=input('post.title');
            if($data){
                $info=model('AuthGroup')->selectGroup($data);
                if(!$info){
                    $row=model('AuthGroup')->addGroup($data);
                    if($row){
                        $res['status']=1;
                        $res['info']='添加管理组成功！';
                        return $res;
                    }else{
                        $res['status']=2;
                        $res['info']='添加管理组失败！';
                        return $res;
                    }
                }else{
                    $res['status']=3;
                    $res['info']='管理组已存在！';
                    return $res;
                }
            }else{
                $res['status']=4;
                $res['info']='管理组名称不能为空！';
                return $res;
            }
        }else{
            return $this->fetch();
        }
    }

    //编辑管理组;
    public function edit(){
        if(request()->isAjax()){
            $id=input('post.id');
            $data['title']=input('post.title');
            $info=model('AuthGroup')->selectGroup($data);
            if(!$info){
                $where['id']=$id;
                $row=model('AuthGroup')->editGroup($where,$data);
                if($row){
                    $res['status']=1;
                    $res['info']='编辑成功！';
                    return $res;
                }else{
                    $res['status']=2;
                    $res['info']='编辑失败！';
                    return $res;
                }
            }else{
                $res['status']=3;
                $res['info']='管理组已存在！';
                return $res;
            }
        }else{
            $where['id']=input('param.id');
            $group=model('AuthGroup')->selectGroup($where);
            $this->assign('group',$group);
            return $this->fetch();
        }
    }

    //删除管理组;
    public function del(){
        if(request()->isAjax()){
            $id=input('post.id');
            $where['id']=$id;
            $group['group_id']=$id;
            $groupList=model('AuthGroup')->selectGroup($where);
            $groupAccess=model('AuthGroupAccess')->selectGroupAccess($group);
            if($groupList){
                if($groupAccess){
                    Db::startTrans();
                    try{
                        $row1=Db::name('AuthGroup')->where($where)->delete();
                        $row2=Db::name('AuthGroupAccess')->where($group)->delete();
                        if(!$row1 || !$row2){
                            throw new \Exception('删除失败！');
                        }
                        Db::commit();
                        $res['status']=1;
                        $res['info']='删除成功！';
                        return $res;
                    }catch (\Exception $e){
                        Db::rollback();
                        $res['status']=1;
                        $res['info']=$e->getMessage();
                        return $res;
                    }

                    /*$result=Db::transaction(function(){
                        Db::name('AuthGroup')->where($where)->delete();
                        Db::name('AuthGroupAccess')->where($group)->delete();
                    });
                    if($result){
                        $res['status']=1;
                        $res['info']='删除成功！';
                        return $res;
                    }else{
                        $res['status']=2;
                        $res['info']='删除失败！';
                        return $res;
                    }*/
                }else{
                    $row=model('AuthGroup')->delGroup($where);
                    if($row){
                        $res['status']=1;
                        $res['info']='删除成功！';
                        return $res;
                    }else{
                        $res['status']=2;
                        $res['info']='删除失败！';
                        return $res;
                    }
                }
            }else{
                $res['status']=3;
                $res['info']='没有查到数据！';
                return $res;
            }
        }
    }

    //向管理组中添加成员;
    public function addMember(){
        if(request()->isAjax()){
            //判断是填写还是勾选
            if(input('post.username')){
                $where['username']=trim(input('post.username'));
                $info=model('Admin')->getOne($where);
                //管理员是否存在
                if($info){
                    $data['uid']=$info['id'];
                    $data['group_id']=input('post.gid');
                    $accessInfo=model('AuthGroup')->selectAccess($data);
                    //判断管理员是否已经在管理组中;
                    if(!$accessInfo){
                        $row=model('AuthGroup')->addAccess($data);
                        if($row){
                            $res['status']=1;
                            $res['info']='添加成功！';
                            return $res;
                        }else{
                            $res['status']=2;
                            $res['info']='添加失败！';
                            return $res;
                        }
                    }else{
                        $res['status']=3;
                        $res['info']='添加的管理员已在组中！';
                        return $res;
                    }
                }else{
                    $res['status']=4;
                    $res['info']='添加的管理员不存在！';
                    return $res;
                }
            }elseif(input('post.uid')){
                foreach(input('post.uid') as $v1){
                    $data['uid']=$v1;
                    $data['group_id']=input('post.gid');
                    //判断管理员是否已经在管理组中;
                    model('AuthGroup')->delAccess($data);
                    $row=model('AuthGroup')->addAccess($data);
                }
                if($row){
                    $res['status']=1;
                    $res['info']='添加成功！';
                    return $res;
                }else{
                    $res['status']=2;
                    $res['info']='添加失败！';
                    return $res;
                }
            }
        }else{
            $where['group_id']=input('param.gid');
            $admins=model('Admin')->admins('');
            $accessInfo=model('AuthGroup')->selectGroupAccess($where,'uid');
            foreach ($accessInfo as $v) {
                $arr[] = $v['uid'];
            }
            $accessInfo['uid'] = $arr;
            $this->assign('gid',$where['group_id']);
            $this->assign('admins',$admins);
            $this->assign('accessInfo',$accessInfo);
            return $this->fetch('addMember');
        }
    }

    //给管理组分配权限;
    public function allocateRule(){
        if(request()->isAjax()){
            $where['id']=input('post.id');
            $data['rules']=implode(',',input('post.rules'));
            $row=model('AuthGroup')->editGroup($where,$data);
            if($row){
                $res['status']=1;
                $res['info']='分配成功！';
                return $res;
            }else{
                $res['status']=2;
                $res['info']='分配失败！';
                return $res;
            }
        }else{
            //获取所有权限规则
            $ruleList=model('AuthRule')->getRuleTree();
            //获取组信息
            $where['id']=input('param.gid');
            $groupInfo=model('AuthGroup')->selectGroup($where);
            $groupInfo['rules']=explode(',',$groupInfo['rules']);
            $this->assign('ruleList',$ruleList);
            $this->assign('groupInfo',$groupInfo);
            return $this->fetch();
        }
    }
}