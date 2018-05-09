<?php
namespace app\admin\controller;

use think\Db;
use think\Exception;
use think\Loader;

class Section extends Base{
    //分类列表
    public function index(){
        $keywords=trim(input('get.keywords'));
        if($keywords){
            $where['cname']=['like',"%$keywords%"];
        }else{
            $where='';
        }
        $param['query']['keywords']=$keywords;
        $list=\app\common\model\Section::where($where)->order('path')->paginate(10,false,$param);
        $this->assign('list',$list);
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        $this->assign('keywords',$keywords);
        return $this->fetch();
    }

    //添加分类
    public function add(){
        if(request()->isAjax()){
            $arr['pid']=intval(trim(input('post.pid')));
            $arr['cname']=trim(input('post.cname'));
            $arr['intro']=trim(input('post.intro'));
            $validate=Loader::validate('Section');
            if($validate->check($arr)){
                $where['cname']=$arr['cname'];
                $info=\app\common\model\Section::get($where);
                if($info){
                    $res['status']=4;
                    $res['info']='分类名已存在！';
                    return $res;
                }
                $arr['addtime']=time();
                $section= new \app\common\model\Section();
                $row=$section->save($arr);
                if($row){
                    $id=$section->id;
                    if($arr['pid']==0){
                        $path['path']=$id;
                    }else{
                        $condition['id']=$arr['pid'];
                        $pathInfo=\app\common\model\Section::get($condition);
                        $path['path']=$pathInfo['path'].','.$id;
                    }
                    $section->path=$path['path'];
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
            $info=\app\common\model\Section::get($id);
            if($info){
                $data['show']=($info['show']==0)?1:0;
                $where['path']=['like',"{$info['path']}%"];
                $row=\app\common\model\Section::where($where)->update($data);
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
                $res['info']='分类不存在！';
                return $res;
            }
        }
    }

    //分类编辑
    public function edit(){
        if(request()->isAjax()){
            $cname=trim(input('post.cname'));
            $pid=trim(input('post.pid'));
            $intro=trim(input('post.intro'));
            $id=trim(input('post.id'));
            $info=\app\common\model\Section::get($id);
            if($cname != $info['cname']){
                $where['cname']=$cname;
                $arr=\app\common\model\Section::get($where);
                if($arr){
                    $res['status']=3;
                    $res['info']='分类名称已存在！';
                    return $res;
                }
                $info->cname=$cname;
            }
            if($pid==0){
                $info->path=$id;
            }else {
                $info->path = $pid . ',' . $id;
            }
            $info->pid=$pid;
            $info->intro=$intro;
            $row=$info->save();
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
            $id=trim(input('param.id'));
            $info=\app\common\model\Section::get($id);
            $list=\app\common\model\Section::all(['pid'=>0,'show'=>1]);
            $this->assign('list',$list);
            $this->assign('info',$info);
            return $this->fetch('editor');
        }
    }

    public function del(){
        if(request()->isAjax()){
            $id=trim(input('post.id'));
            $info=\app\common\model\Section::get($id);
            $row=\app\common\model\Section::where('path','like',"{$info['path']}%")->delete();
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