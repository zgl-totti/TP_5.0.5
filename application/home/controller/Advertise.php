<?php
namespace app\admin\controller;

use think\Loader;
use think\Validate;

class Advertise extends Base{
    //广告列表
    public function index(){
        $keywords=input('get.keywords');
        if($keywords){
            $where['title']=['like',"%$keywords%"];
        }else{
            $where='';
        }
        $param['query']['keywords']=$keywords;
        $list=\app\admin\model\Advertise::where($where)->paginate(10,false,$param);
        $this->assign('keywords',$keywords?$keywords:'');
        $this->assign('list',$list);
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        $this->assign('page',$list->render());
        return $this->fetch();
    }

    //添加广告操作;
    public function add(){
        if(request()->isPost()){
            $data['title'] = trim(input('param.title'));
            $validate=Loader::validate('Advertise');
            if($validate->check($data)){
                $arr=\app\admin\model\Advertise::get($data);
                if($arr){
                    $res['status']=5;
                    $res['info']='广告已存在！';
                    return $res;
                }
                $data['addtime']=time();
                //把数据添加到数据库;
                $advertise= new \app\admin\model\Advertise();
                $row=$advertise->save($data);
                if($row){
                    //创建上传文件夹;
                    if (!file_exists(ROOT_PATH.'public'.DS.'uploads'.DS.'advertise')) {
                        mkdir(ROOT_PATH.'public'.DS.'uploads'.DS.'advertise',0777);
                    }
                    //处理图片上传;
                    $file=request()->file('pic');
                    $info=$file->validate(['size'=>3145728,'ext'=>'jpg,gif,png,jpeg'])
                        ->move(ROOT_PATH.'public'.DS.'uploads'.DS.'advertise');
                    if($info){
                        $advertise->pic=$info->getSaveName();
                        if($advertise->save()){
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
                    $res['status']=4;
                    $res['info']='添加失败！';
                    return $res;
                }
            }else{
                $res['status']=2;
                $res['info']=$validate->getError();
                return $res;
            }
        }else{
            return $this->fetch();
        }
    }

    //更改广告状态;
    public function operate(){
        if(request()->isAjax()){
            $id=input('post.id');
            $info=\app\admin\model\Advertise::get($id);
            if($info){
                $status=($info['status']==1)?2:1;
                $info->status=$status;
                $row=$info->save();
                if($row){
                    $res['status']=1;
                    $res['info']='状态更改成功！';
                    return $res;
                }else{
                    $res['status']=2;
                    $res['info']='状态更改失败！';
                    return $res;
                }
            }else{
                $res['status']=3;
                $res['info']='广告不存在！';
                return $res;
            }
        }
    }

    //删除广告操作;
    public function del(){
        if(request()->isAjax()){
            $id=input('post.id');
            $info=\app\admin\model\Advertise::get($id);
            if($info){
                $row=$info->delete();
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
                $res['status']=3;
                $res['info']='广告不存在！';
                return $res;
            }
        }
    }

    //广告编辑操作;
    public function edit(){
        if(request()->isAjax()){
            $id=input('post.id');
            $data['title'] = trim(input('post.title'));
            $validate=Loader::validate('Advertise');
            if($validate->check($data)){
                $where['title']=$data['title'];
                $where['id']=['neq',$id];
                $arr=\app\admin\model\Advertise::get($where);
                if($arr){
                    $res['status']=5;
                    $res['info']='广告已存在！';
                    return $res;
                }
                $data['addtime']=time();
                $advertise=\app\admin\model\Advertise::get($id);
                $row=$advertise->save($data);
                if($row){
                    //处理图片上传;
                    $file=request()->file('pic');
                    $info=$file->validate(['size'=>3145728,'ext'=>'jpg,gif,png,jpeg'])
                        ->move(ROOT_PATH.'public'.DS.'uploads'.DS.'advertise');
                    if($info){
                        $advertise->pic=$file->getSaveName();
                        if($advertise->save()){
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
                    $res['status']=4;
                    $res['info']='编辑失败！';
                    return $res;
                }
            }else{
                $res['status']=5;
                $res['info']=$validate->getError();
                return $res;
            }
        }else{
            $id=input('param.id');
            $info=\app\admin\model\Advertise::get($id);
            $this->assign('info',$info);
            return $this->fetch();
        }
    }
}
