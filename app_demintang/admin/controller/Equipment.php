<?php
namespace app\admin\controller;

use think\Db;
use think\Exception;
use think\Loader;

class Equipment extends Base{
    //分类列表
    public function index(){
        $keywords=trim(input('get.keywords'));
        if($keywords){
            $where['username']=['like',"%$keywords%"];
        }else{
            $where='';
        }
        $param['query']['keywords']=$keywords;
        $list=\app\common\model\Equipment::where($where)->with('getSection')->paginate(10,false,$param);
        $this->assign('list',$list);
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        $this->assign('keywords',$keywords);
        return $this->fetch();
    }

    //添加分类
    public function add(){
        if(request()->isPost()){
            $arr['sid']=trim(input('post.sid'));
            $arr['username']=trim(input('post.username'));
            $arr['cycle']=trim(input('post.cycle'));
            $arr['content']=trim(input('post.content'));
            $validate=Loader::validate('Equipment');
            if($validate->check($arr)){
                $data['sid']=$arr['sid'];
                $data['username']=$arr['username'];
                $info=\app\common\model\Equipment::get($data);
                if($info){
                    $res['status']=2;
                    $res['info']='该患者反馈已存在！';
                    return $res;
                }
                $arr['addtime']=time();
                $section= new \app\common\model\Equipment();
                $row=$section->save($arr);
                if($row){
                    if (!file_exists(ROOT_PATH.DS.'public'.DS.'uploads'.DS.'equipment')) {
                        mkdir(ROOT_PATH.DS.'public'.DS.'uploads'.DS.'equipment',0777);
                    }
                    $file=request()->file('pic');
                    $image=$file->validate(['size'=>3145728,'ext'=>'jpg,gif,png,jpeg'])
                        ->move(ROOT_PATH.'public'.DS.'uploads'.DS.'equipment');
                    if($image){
                        $pic=$image->getSaveName();
                        $section->pic=$pic;
                        if($section->save()){
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
                }else{
                    $res['status']=3;
                    $res['info']='添加失败！';
                    return $res;
                }
            }else{
                $res['status']=5;
                $res['info']=$validate->getError();
                return $res;
            }
        }else {
            $list=\app\common\model\Section::all(['pid'=>0,'show'=>1]);
            $this->assign('list',$list);
            return $this->fetch('add');
        }
    }

    //分类上架下架
    public function updateshow(){
        if(request()->isAjax()){
            $id=trim(input('post.id'));
            $info=\app\common\model\Equipment::get($id);
            if($info){
                $info->show=($info['show']==0)?1:0;
                $row=$info->save();
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
                $res['info']='非法操作！';
                return $res;
            }
        }
    }

    //分类编辑
    public function edit(){
        if(request()->isAjax()){
            $id=input('post.id');
            $arr['sid']=trim(input('post.sid'));
            $arr['username']=trim(input('post.username'));
            $arr['cycle']=trim(input('post.cycle'));
            $arr['content']=trim(input('post.content'));
            $validate=Loader::validate('Equipment');
            if($validate->check($arr)){
                $data['sid']=$arr['sid'];
                $data['username']=$arr['username'];
                $info=\app\common\model\Equipment::where('id','<>',$id)->where($data)->find();
                if($info){
                    $res['status']=2;
                    $res['info']='该患者反馈已存在！';
                    return $res;
                }
                $arr['addtime']=time();
                $section=\app\common\model\Equipment::get($id);
                $row=$section->save($arr);
                if($row){
                    if(!$_FILES){
                        $res['status']=1;
                        $res['info']='添加成功！';
                        return $res;
                    }
                    $file=request()->file('pic');
                    $image=$file->validate(['size'=>3145728,'ext'=>'jpg,gif,png,jpeg'])
                        ->move(ROOT_PATH.'public'.DS.'uploads'.DS.'equipment');
                    if($image){
                        //unlink(ROOT_PATH.'public'.DS.'uploads'.DS.'expert'.DS.$expert['pic']);
                        $pic=$image->getSaveName();
                        $section->pic=$pic;
                        if($section->save()){
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
                        $res['info']='上传失败！';
                        return $res;
                    }
                }else{
                    $res['status']=3;
                    $res['info']='编辑失败！';
                    return $res;
                }
            }else{
                $res['status']=5;
                $res['info']=$validate->getError();
                return $res;
            }
        }else{
            $id=trim(input('param.id'));
            $info=\app\common\model\Equipment::get($id);
            $list=\app\common\model\Section::all(['pid'=>0,'show'=>1]);
            $this->assign('list',$list);
            $this->assign('info',$info);
            return $this->fetch();
        }
    }

    public function del(){
        if(request()->isAjax()){
            $id=trim(input('post.id'));
            $row=\app\common\model\Equipment::get($id)->delete();
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