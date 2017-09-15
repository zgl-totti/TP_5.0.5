<?php
namespace app\admin\controller;

use think\Loader;
use think\Request;
use think\Session;

class Nav extends Base{
    public function index(){
        $keywords=trim(input('get.keywords'));
        if($keywords){
            $where['navname']=['like',"%$keywords%"];
        }else{
            $where='';
        }
        $param['query']['keywords']=$keywords;
        $list=\app\admin\model\Nav::where($where)->order('priority asc')->paginate(10,false,$param);
        $this->assign('keywords',$keywords);
        $this->assign('list',$list);
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        $this->assign('page',$list->render());
        return $this->fetch();
    }

    public function add(){
        if(request()->isAjax()){
            $data['navname']=trim(input('post.navname'));
            $data['navurl']=trim(input('post.navurl'));
            $data['priority']=trim(input('post.priority'));
            $validate=Loader::validate('Nav');
            if($validate->check($data)){
                $where['navname']=$data['navname'];
                $info= \app\admin\model\Nav::get($where);
                if($info){
                    $res['status'] = 5;
                    $res['info'] = '导航名称已存在';
                    return $res;
                }
                $data['addtime']=time();
                $nav= new \app\admin\model\Nav();
                if($nav->save($data)) {
                    $res['status'] = 1;
                    $res['info'] = '添加成功';
                    return $res;
                }else {
                    $res['status'] = 5;
                    $res['info'] = '添加失败';
                    return $res;
                }
            }else {
                $res['status'] = 5;
                $res['info'] = $validate->getError();
                return $res;
            }
        }else{
            return $this->fetch();
        }
    }

    //编辑
    public function edit(){
        if(request()->isAjax()){
            $id=input('post.id');
            $data['navname']=trim(input('post.navname'));
            $data['navurl']=trim(input('post.navurl'));
            $data['priority']=trim(input('post.priority'));
            $validate=Loader::validate('Nav');
            if($validate->check($data)){
                $where['navname']=$data['navname'];
                $where['id']=['neq',$id];
                $info= \app\admin\model\Nav::get($where);
                if($info){
                    $res['status'] = 5;
                    $res['info'] = '导航名称已存在';
                    return $res;
                }
                $data['addtime']=time();
                $nav= \app\admin\model\Nav::get($id);
                if($nav->save($data)) {
                    $res['status'] = 1;
                    $res['info'] = '编辑成功';
                    return $res;
                }else {
                    $res['status'] = 5;
                    $res['info'] = '编辑失败';
                    return $res;
                }
            }else {
                $res['status'] = 5;
                $res['info'] = $validate->getError();
                return $res;
            }
        }else{
            $id=input('param.id');
            $info=\app\admin\model\Nav::get($id);
            $this->assign('info',$info);
            return $this->fetch();
        }
    }

    //改变状态
    public function operate(){
        if(request()->isAjax()) {
            $id = input('post.id');
            $info = \app\admin\model\Nav::get($id);
            $status = ($info['status'] == 1) ? 2 : 1;
            $info->status = $status;
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
        }
    }

    //删除
    public function del(){
        if(request()->isAjax()) {
            $id = input('post.id');
            $info = \app\admin\model\Nav::get($id);
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
        }
    }
}