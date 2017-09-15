<?php
namespace app\admin\controller;

use think\Loader;
use think\Validate;

class Intro extends Base{
    public function index(){
        $keywords=input('get.keywords');
        if($keywords){
            $where['title']=['like',"%$keywords%"];
        }else{
            $where='';
        }
        $param['query']['keywords']=$keywords;
        $list=\app\admin\model\Intro::where($where)->paginate(10,false,$param);
        $this->assign('keywords',$keywords?$keywords:'');
        $this->assign('list',$list);
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        $this->assign('page',$list->render());
        return $this->fetch();
    }

    public function add(){
        if(request()->isPost()){
            $data['title'] = trim(input('post.title'));
            $data['content'] = htmlspecialchars(trim(input('post.editorValue')));
            $validate=Loader::validate('Intro');
            if($validate->check($data)){
                $where['title']=$data['title'];
                $arr=\app\admin\model\Intro::get($where);
                if($arr){
                    $res['status']=5;
                    $res['info']='已存在！';
                    return $res;
                }
                $data['addtime']=time();
                //把数据添加到数据库;
                $intro= new \app\admin\model\Intro();
                $row=$intro->save($data);
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
                $res['status']=2;
                $res['info']=$validate->getError();
                return $res;
            }
        }else{
            return $this->fetch();
        }
    }

    public function operate(){
        if(request()->isAjax()){
            $id=input('post.id');
            $info=\app\admin\model\Intro::get($id);
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
                $res['info']='门诊概况不存在！';
                return $res;
            }
        }
    }

    public function del(){
        if(request()->isAjax()){
            $id=input('post.id');
            $info=\app\admin\model\Intro::get($id);
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
                $res['info']='简介不存在！';
                return $res;
            }
        }
    }

    public function edit(){
        if(request()->isAjax()){
            $id=input('post.id');
            $data['title'] = trim(input('post.title'));
            $data['content'] = htmlspecialchars(trim(input('post.editorValue')));
            $validate=Loader::validate('Intro');
            if($validate->check($data)){
                $where['title']=$data['title'];
                $where['id']=['neq',$id];
                $arr=\app\admin\model\Intro::get($where);
                if($arr){
                    $res['status']=5;
                    $res['info']='已存在！';
                    return $res;
                }
                $data['addtime']=time();
                //把数据添加到数据库;
                $Intro=\app\admin\model\Intro::get($id);
                $row=$Intro->save($data);
                if($row){
                    $res['status']=1;
                    $res['info']='编辑成功！';
                    return $res;
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
            $info=\app\admin\model\Intro::get($id);
            $this->assign('info',$info);
            return $this->fetch();
        }
    }
}
