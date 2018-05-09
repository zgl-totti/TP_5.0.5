<?php
namespace app\admin\controller;

class Adminnav extends Base{
    //菜单列表
    public function index(){
        $navList=model('AdminNav')->getNavList();
        $this->assign('navList',$navList);
        return $this->fetch('list');
    }

    //添加菜单
    public function add(){
        if(request()->isAjax()){
            $data['pid']=input('post.pid');
            $data['navname']=trim(input('post.navname'));
            $data['navurl']=trim(input('post.navurl'));
            $data['priority']=trim(input('post.priority'));
            if($data){
                $id=model('AdminNav')->addNav($data);
                if($id){
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
                $res['info']='添加菜单不能为空！';
                return $res;
            }
        }else{
            $pid=input('param.pid');
            if($pid){
                $pname=trim(input('param.pname'));
                $this->assign('pid',$pid);
                $this->assign('pname',$pname);
            }
            return $this->fetch();
        }
    }

    //删除菜单
    public function del(){
        if(request()->isAjax()){
            $id=input('post.id');
            $where['path']=['like',"{$id}%"];
            $condition['id']=$id;
            $pathInfo=model('AdminNav')->getAll($where);
            if($pathInfo){
                $row=model('AdminNav')->del($where);
                if($row){
                    $res['status']=1;
                    $res['info']='删除成功！';
                    return $res;
                }else{
                    $res['status']=2;
                    $res['info']='删除失败！';
                    return $res;
                }
            }else{
                $row=model('AdminNav')->del($condition);
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
        }
    }

    //编辑菜单
    public function edit(){
        if(request()->isAjax()){
            $where['id']=input('post.id');
            $info=model('AdminNav')->getOne($where);
            if($info){
                $data['navname']=trim(input('post.navname'));
                $data['navurl']=trim(input('post.navurl'));
                $row=model('AdminNav')->updateNav($where,$data);
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
                $res['info']='没有查到数据！';
                return $res;
            }
        }else{
            $where['id']=input('param.id');
            $navInfo=model('AdminNav')->getOne($where);
            $this->assign('id',$navInfo['id']);
            $this->assign('navname',$navInfo['navname']);
            $this->assign('navurl',$navInfo['navurl']);
            return $this->fetch('edit');
        }
    }

    //设置菜单优先级
    public function setPriority(){
        if(request()->isAjax()){
            $where['id']=input('post.id');
            $data['priority']=trim(input('post.priority'));
            $row=model('AdminNav')->setPriority($where,$data);
            if($row){
                $res['status']=1;
                $res['info']='优先级更新成功';
                return $res;
            }else{
                $res['status']=2;
                $res['info']='优先级更新失败';
                return $res;
            }
        }
    }
}