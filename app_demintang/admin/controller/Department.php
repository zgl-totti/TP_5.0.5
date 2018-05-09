<?php
namespace app\admin\controller;

use app\common\model\Expert;
use think\Loader;
use think\Session;
use think\Validate;

class Department extends Base{
    public function index(){
        $keywords=trim(input('get.keywords'));
        if($keywords){
            $where['name']=['like',"%$keywords%"];
        }else{
            $where='';
        }
        $param['query']['keywords']=$keywords;
        $department= new \app\common\model\Department();
        $list=$department->where($where)->paginate(10,false,$param);
        $this->assign('keywords',$keywords);
        $this->assign('list',$list);
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        $this->assign('page',$list->render());
        return $this->fetch();
    }

    public function add(){
        if(request()->isAjax()){
            $data['name']=trim(input('post.name'));
            $data['intro']=trim(input('post.intro'));
            $validate=Loader::validate('Department');
            if($validate->check($data)){
                $where['name']=$data['name'];
                $info= \app\common\model\Department::get($where);
                if($info){
                    $res['status'] = 5;
                    $res['info'] = '科室已存在';
                    return $res;
                }
                $data['addtime']=time();
                $department= new \app\common\model\Department();
                if($department->save($data)) {
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
            $data['name']=trim(input('post.name'));
            $data['intro']=trim(input('post.intro'));
            $validate=Loader::validate('Department');
            if($validate->check($data)){
                $where['name']=$data['name'];
                $where['id']=['neq',$id];
                $info= \app\common\model\Department::get($where);
                if($info){
                    $res['status'] = 5;
                    $res['info'] = '科室已存在';
                    return $res;
                }
                $data['addtime']=time();
                $department= \app\common\model\Department::get($id);
                if($department->save($data)) {
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
            $info=\app\common\model\Department::get($id);
            $this->assign('info',$info);
            return $this->fetch();
        }
    }

    //改变状态
    public function operate(){
        if(request()->isAjax()) {
            $id = input('post.id');
            $info = \app\common\model\Department::get($id);
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
            $info = \app\common\model\Department::get($id);
            $row = $info->delete();
            if ($row) {
                $where['department']=$id;
                Expert::destroy($where);
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