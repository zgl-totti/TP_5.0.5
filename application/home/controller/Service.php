<?php
namespace app\admin\controller;

use think\Loader;
use think\Session;

class Service extends Base{
    public function index(){
        $keywords=trim(input('get.keywords'));
        if($keywords){
            $where['name|qq']=['like',"%$keywords%"];
        }else{
            $where='';
        }
        $param['query']['keywords']=$keywords;
        $service= new \app\admin\model\Service();
        $list=$service->where($where)->paginate(10,false,$param);
        $this->assign('keywords',$keywords);
        $this->assign('list',$list);
        $this->assign('page',$list->render());
        return $this->fetch();
    }

    public function add(){
        if(request()->isAjax()){
            $data['name']=trim(input('post.name'));
            $data['qq']=trim(input('post.qq'));
            $validate=Loader::validate('Service');
            if($validate->check($data)){
                $where['name']=$data['name'];
                $condition['qq']=$data['qq'];
                $info= \app\admin\model\Service::get()->where($where)->whereOr($condition)->select();
                if($info){
                    $res['status'] = 5;
                    $res['info'] = '客服已存在';
                    return $res;
                }
                $data['addtime']=time();
                $Service= new \app\admin\model\Service();
                if($Service->save($data)) {
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
            $data['qq']=trim(input('post.qq'));
            $validate=Loader::validate('Service');
            if($validate->check($data)){
                $where['name']=$data['name'];
                $where['id']=['!=',$id];
                $condition['qq']=$data['qq'];
                $condition['id']=['!=',$id];
                $info= \app\admin\model\Service::get()->where($where)->where($condition)->select();
                if($info){
                    $res['status'] = 5;
                    $res['info'] = '客服已存在';
                    return $res;
                }
                $data['addtime']=time();
                $Service= \app\admin\model\Service::get($id);
                if($Service->save($data)) {
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
            $info=\app\admin\model\Service::get($id);
            $this->assign('info',$info);
            return $this->fetch();
        }
    }

    //改变状态
    public function operate(){
        if(request()->isAjax()) {
            $id = input('post.id');
            $info = \app\admin\model\Service::get($id);
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
            $info = \app\admin\model\Service::get($id);
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