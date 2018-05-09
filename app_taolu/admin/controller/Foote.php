<?php
namespace app\admin\controller;

use think\Db;
use think\image\Exception;
use think\Request;

class Foote extends Base{
    //展示底部列表
    public function index(){
        $fname=input('get.fname');
        $pid=input('param.pid');
        if($fname){
            $where['fname']=['like',"%$fname%"];
        }else{
            $where['pid']=$pid?$pid:0;
        }
        $list=model('Foote')->getList($where,10);
        $this->assign('fname',$fname?$fname:'');
        $this->assign('list',$list);
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        $this->assign('page',$list->render());
        $this->assign('empty','<h1 style="font-weight: bold;font-size: 20px;">没有找到相关数据</h1>');
        return $this->fetch('list');
    }

    //展示添加底部的页面
    public function add(){
        if(Request::instance()->isAjax()) {
            if (input('post.secondCate')) {
                $pid = input('post.secondCate');
            } else {
                $pid = input('post.firstCate');
            }
            $data['fname'] = trim(input('post.fname'));
            $num['pid'] = 0;
            $count = count(model('Foote')->getAll($num));
            if ($count == 5) {
                $res['status'] = 6;
                $res['info'] = '最多只能添加5条顶级分类哦';
                return $res;
            } elseif ($data['fname']) {
                $info = model('Foote')->getOne($data);
                if (!$info) {
                    $date['pid'] = $pid;
                    $date['addtime'] = time();
                    $id = model('Foote')->addFoote($data);
                    if ($id) {
                        if ($pid == 0) {
                            $path['path'] = $id;
                        } else {
                            $where['id'] = $pid;
                            $pathInfo = model('Foote')->getOne($where);
                            $path['path'] = $pathInfo['path'] . ',' . $id;
                        }
                        $condition['id'] = $id;
                        $row = model('Foote')->updateFoote($condition, $path);
                        if ($row) {
                            $res['status'] = 1;
                            $res['info'] = '添加成功';
                            return $res;
                        } else {
                            $res['status'] = 2;
                            $res['info'] = '添加失败';
                            return $res;
                        }
                    } else {
                        $res['status'] = 3;
                        $res['info'] = '添加失败';
                        return $res;
                    }
                } else {
                    $res['status'] = 4;
                    $res['info'] = '底部分类名已存在';
                    return $res;
                }
            } else {
                $res['status'] = 5;
                $res['info'] = '底部分类名不能为空';
                return $res;
            }
        }else{
            return $this->fetch();
        }
    }

    //展示需要编辑的底部分类
    public function editor(){
        if(request()->isAjax()){
            if(input('post.secondCate')){
                $pid=input('post.secondCate');
            }else{
                $pid=input('post.firstCate');
            }
            $id=input('post.id');
            if($pid==0){
                $newpath=$id;
            }else{
                $where['id']=$pid;
                $pathInfo=model('Foote')->getOne($where);
                $newpath=$pathInfo['path'].','.$id;
            }
            //更新path
            $condition['id']=$id;
            $cateInfo=model('Foote')->getOne($condition);
            $oldpath=$cateInfo['path'];
            $data['path']=$newpath;
            $data['pid']=$pid;
            $data['fname']=trim(input('post.fname'));
            //$res1=model('Foote')->updateFoote($condition,$data);
            //更新子分类的path
            $path['path']=['like',"{$oldpath}%"];
            $info['path']=$newpath;
            //$res2=model('Foote')->updateFoote($path,$info);
            Db::startTrans();
            try{
                model('Foote')->updateFoote($condition,$data);
                model('Foote')->updateFoote($path,$info);
                Db::commit();
                $res['status']=1;
                $res['info']='编辑成功！';
                return $res;
            }catch (Exception $e){
                Db::rollback();
                $res['status']=2;
                $res['info']=$e;
                return $res;
            }
        }else{
            $id=input('param.phid');
            $where['id']=$id;
            $catename=model('Foote')->getOne($where);
            $this->assign('cname',$catename['fname']);
            $this->assign('id',$catename['id']);
            return $this->fetch('editor');
        }
    }

    //对底部进行上架下架展示
    public function updateshow(){
        if(request()->isAjax()){
            $ptid=input('post.ptid');
            $where['id']=$ptid;
            $info=model('Foote')->getOne($where);
            if($info){
                $path=$info['path'].',';
                $condition['path']=['like',"{$path}%"];
                $childInfo=model('Foote')->getAll($condition);
                $str=$ptid.',';
                foreach($childInfo as $k=>$v){
                    $str.=$v['id'].',';
                }
                $str=substr($str,0,-1);
                $map['id']=['in',$str];
                $data['show']=($info['show']==0)?1:0;
                $row=model('Foote')->updateFoote($map,$data);
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
                $res['info']='没有查到数据！';
                return $res;
            }
        }
    }

    //显示三级联动分类
    public function getCateByPid(){
        //如果pid不存在则默认为0
        $pid=input('post.pid',0);
        $where['pid']=$pid;
        $cateList=model('Foote')->getAll($where);
        if($cateList){
            $res['status']=1;
            $res['info']=$cateList;
            return $res;
        }else{
            return false;
        }
    }

    public function addnews(){
        if(request()->isAjax()){
            $where['id']=input('param.id');
            $where['newtitle']=trim(input('post.newtitle'));
            $info=model('Foote')->getOne($where);
            if($info){
                $data['newcontent']=trim(input('post.newcontent'));
                $data['addtime']=time();
                $row=model('Foote')->updateFoote($where,$data);
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
                $data['newaddtime']=time();
                $row=model('Foote')->updateFoote($where,$data);
                if($row){
                    $res['status']=1;
                    $res['info']='添加成功！';
                    return $res;
                }else{
                    $res['status']=2;
                    $res['info']='添加失败！';
                    return $res;
                }
            }
        }else{
            $where['id']=input('param.id');
            $fnameinfo=model('Foote')->getOne($where);
            $this->assign('fname',$fnameinfo['fname']);
            $this->assign('id',$fnameinfo['id']);
            return $this->fetch('addnews');
        }
    }
}