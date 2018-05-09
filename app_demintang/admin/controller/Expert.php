<?php
namespace app\admin\controller;

use app\common\model\Department;
use think\File;
use think\Loader;
use think\Session;

class Expert extends Base{
    public function index(){
        $keywords=trim(input('get.keywords'));
        if($keywords){
            $where['username']=['like',"%$keywords%"];
        }else{
            $where='';
        }
        $param['query']['keywords']=$keywords;
        $list=\app\common\model\Expert::where($where)->with('departments')->paginate(10,false,$param);
        $this->assign('keywords',$keywords);
        $this->assign('list',$list);
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        $this->assign('page',$list->render());
        return $this->fetch();
    }

    public function add(){
        if(request()->isAjax()){
            $data['username']=trim(input('post.username'));
            $data['age']=trim(input('post.age'));
            $data['role']=trim(input('post.role'));
            $data['gender']=trim(input('post.gender'));
            $data['department']=trim(input('post.department'));
            $data['introduce']=trim(input('post.introduce'));
            $validate=Loader::validate('Expert');
            if($validate->check($data)){
                $where['username']=$data['username'];
                $info= \app\common\model\Expert::get($where);
                if($info){
                    $res['status'] = 5;
                    $res['info'] = '专家已存在';
                    return $res;
                }
                $data['addtime']=time();
                $expert= new \app\common\model\Expert();
                if($expert->save($data)) {
                    if (!file_exists(ROOT_PATH.DS.'public'.DS.'uploads'.DS.'expert')) {
                        mkdir(ROOT_PATH.DS.'public'.DS.'uploads'.DS.'expert',0777);
                    }
                    $file=request()->file('pic');
                    $image=$file->validate(['size'=>3145728,'ext'=>'jpg,gif,png,jpeg'])
                        ->move(ROOT_PATH.'public'.DS.'uploads'.DS.'expert');
                    if($image){
                        $pic=$image->getSaveName();
                        $expert->pic=$pic;
                        $row=$expert->save();
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
                        $res['info']='上传失败！';
                        return $res;
                    }
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
            $list=Department::all();
            $this->assign('list',$list);
            return $this->fetch();
        }
    }

    //编辑
    public function edit(){
        if(request()->isAjax()){
            $id=input('post.id');
            $data['username']=trim(input('post.username'));
            $data['age']=trim(input('post.age'));
            $data['role']=trim(input('post.role'));
            $data['gender']=trim(input('post.gender'));
            $data['department']=trim(input('post.department'));
            $data['introduce']=trim(input('post.introduce'));
            $validate=Loader::validate('Expert');
            if($validate->check($data)){
                $where['username']=$data['username'];
                $where['id']=['neq',$id];
                $info= \app\common\model\Expert::get($where);
                if($info){
                    $res['status'] = 5;
                    $res['info'] = '专家已存在';
                    return $res;
                }
                $data['addtime']=time();
                $expert= \app\common\model\Expert::get($id);
                if($expert->save($data)) {
                    if(!$_FILES){
                        $res['status']=1;
                        $res['info']='添加成功！';
                        return $res;
                    }
                    $file=request()->file('pic');
                    $image=$file->validate(['size'=>3145728,'ext'=>'jpg,gif,png,jpeg'])
                        ->move(ROOT_PATH.'public'.DS.'uploads'.DS.'expert');
                    if($image){
                        //unlink(ROOT_PATH.'public'.DS.'uploads'.DS.'expert'.DS.$expert['pic']);
                        $pic=$image->getSaveName();
                        $expert->pic=$pic;
                        $row=$expert->save();
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
                        $res['info']='上传失败！';
                        return $res;
                    }
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
            $id=input('param.id');
            $info=\app\common\model\Expert::get($id);
            $list=Department::all();
            $this->assign('list',$list);
            $this->assign('info',$info);
            return $this->fetch();
        }
    }

    //改变状态
    public function operate(){
        if(request()->isAjax()) {
            $id = input('post.id');
            $info = \app\common\model\Expert::get($id);
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
            $info = \app\common\model\Expert::get($id);
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