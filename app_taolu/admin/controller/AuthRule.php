<?php
namespace app\admin\controller;

use think\Request;

class Authrule extends Base{

    //权限菜单列表;
    public function index(){
        $ruleList=model('AuthRule')->getRuleList();
        $this->assign('ruleList',$ruleList);
        return $this->fetch();
    }

    //添加权限;
    public function add(){
        if(request()->isAjax()){
            $data['pid']=input('post.pid');
            $data['title']=input('post.title');
            $data['name']=input('post.name');
            if($data['pid'] && $data['title'] && $data['name']){
                $where['title']=$data['title'];
                $info=model('Auth_rule')->getRules($where);
                if(!$info){
                    $nid=model('Auth_rule')->addRule($data);
                    if($nid){
                        $res['status']=1;
                        $res['info']='权限添加成功！';
                        return $res;
                    }else{
                        $res['status']=2;
                        $res['info']='权限添加失败！';
                        return $res;
                    }
                }else{
                    $res['status']=3;
                    $res['info']='权限名称已存在！';
                    return $res;
                }
            }else{
                $res['status']=4;
                $res['info']='权限名称或规则不能为空！';
                return $res;
            }
        }else{
            $pid=input('param.pid');
            if($pid){
                $pname=input('param.pname');
                $this->assign('pid',$pid);
                $this->assign('pname',$pname);
            }
            return $this->fetch();
        }
    }

    //删除菜单;
    public function del(){
        if(Request::instance()->isAjax()){
            $id=input('post.id');
            $info=model('AuthRule')->getRuleById($id);
            if($info){
                $where['path']=['like',"{$id}%"];
                $pathInfo=model('AuthRule')->getRules($where);
                if($pathInfo){
                    $row=model('AuthRule')->delRule($where);
                    if($row){
                        $res['status']=1;
                        $res['info']='删除成功!';
                        return $res;
                    }else{
                        $res['status']=2;
                        $res['info']='删除失败!';
                        return $res;
                    }
                }else{
                    $data['id']=$id;
                    $row=model('AuthRule')->delRule($data);
                    if($row){
                        $res['status']=1;
                        $res['info']='删除成功!';
                        return $res;
                    }else{
                        $res['status']=2;
                        $res['info']='删除失败!';
                        return $res;
                    }
                }
            }else{
                $res['status']=4;
                $res['info']='没有找到数据!';
                return $res;
            }
        }
    }

    //修改编辑权限菜单;
    public function edit(){
        if(request()->isAjax()){
            $id=input('post.id');
            if(input('post.thirdRule')) {
                $pid=input('post.thirdRule');
            }elseif(input('post.secondRule')) {
                $pid=input('post.secondRule');
            }else{
                $pid=input('post.firstRule');
            }
            if($pid==0){
                $newpath=$id;
            }else{
                $pathInfo=model('Auth_rule')->getRuleById($pid);
                $newpath=$pathInfo['path'].','.$id;
            }
            $data['name']=trim(input('post.name'));
            $data['title']=trim(input('post.title'));
            $data['pid']=$pid;
            $data['path']=$newpath;
            $row=model('AuthRule')->editRule($id,$data);
            if($row){
                $res['status']=1;
                $res['info']='编辑成功';
                return $res;
            }else{
                $res['status']=2;
                $res['info']='编辑失败';
                return $res;
            }
        }else{
            $id=input('param.id');
            $rule=model('Auth_rule')->getRuleById($id);
            $this->assign('rule',$rule);
            return $this->fetch('Authrule/edit');
        }
    }

    //显示三级联动分类;
    public function getRuleByPid(){
        $where['pid']=input('post.pid',0);
        $ruleList=model('AuthRule')->getRules($where);
        if($ruleList){
            $res['status']=1;
            $res['info']=$ruleList;
            return $res;
        }else{
            return '查询失败';
        }
    }
}