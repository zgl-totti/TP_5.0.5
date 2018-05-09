<?php
namespace app\admin\controller;

use think\Db;
use think\Exception;

class Category extends Base{
    //分类列表
    public function index(){
        $keywords=trim(input('get.keywords'));
        $time1=trim(input('get.time1'));
        $time2=trim(input('get.time2'));
        if($keywords && $time1 && $time2){
            $where1['cname']=['like',"%$keywords%"];
            $where1['addtime']=['between',[$time1,$time2]];
        }elseif($keywords && $time1){
            $where1['cname']=['like',"%$keywords%"];
            $where1['addtime']=['gt',$time1];
        }elseif($keywords && $time2){
            $where1['cname']=['like',"%$keywords%"];
            $where1['addtime']=['lt',$time2];
        }elseif($time1 && $time2){
            $where1['addtime']=['between',[$time1,$time2]];
        }elseif($time1){
            $where1['addtime']=['gt',$time1];
        }elseif($time2){
            $where1['addtime']=['lt',$time1];
        }else{
            $where1='';
        }
        $list=model('Category')->cateList($where1);
        foreach($list as $v){
            $where['id']=['in',$v['path']];
            $list2[]=model('Category')->cateList($where);
        }
        foreach($list2 as $k2=>$v2){
            foreach($v2 as $v3){
                $list[$k2]['path'].=$v3['cname'].'->';
            }
        }
        $this->assign('list',$list);
        $this->assign('keywords',$keywords?$keywords:'');
        $this->assign('time1',$time1?$time1:'');
        $this->assign('time2',$time2?$time2:'');
        return $this->fetch('list');
    }

    //添加分类
    public function add(){
        if(request()->isAjax()){
            if(trim(input('post.thirdCate'))) {
                $pid=trim(input('post.thirdCate'));
            }elseif(trim(input('post.secondCate'))) {
                $pid=trim(input('post.secondCate'));
            }else {
                $pid=trim(input('post.firstCate'));
            }
            $cname=trim(input('post.cname'));
            if($cname){
                $where['cname']=$cname;
                $info=model('Category')->cate($where);
                if(!$info){
                    $data['cname']=$cname;
                    $data['pid']=$pid;
                    $data['addtime']=time();
                    $insertId=model('Category')->addCategory($data);
                    if($insertId){
                        if($pid==0){
                            $path['path']=$insertId;
                        }else{
                            $where1['id']=$pid;
                            $pathInfo=model('Category')->cate($where1);
                            $path['path']=$pathInfo['path'].','.$insertId;
                        }
                        $where2['id']=$insertId;
                        $row=model('Category')->editCategory($where2,$path);
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
                        $res['info']='添加失败！';
                        return $res;
                    }
                }else{
                    $res['status']=4;
                    $res['info']='分类名已存在！';
                    return $res;
                }
            }else{
                $res['status']=5;
                $res['info']='分类名不能为空！';
                return $res;
            }
        }else {
            return $this->fetch('add');
        }
    }

    //显示三级联动分类
    public function getCateByPid(){
        //如果pid不存在则默认为0
        $pid=trim(input('post.pid',0));
        $where['pid']=$pid;
        $cateList=model('Category')->cate($where);
        if($cateList){
            $res['status']=1;
            $res['info']=$cateList;
            return $res;
        }else{
            return false;
        }
    }

    //分类上架下架
    public function updateshow(){
        if(request()->isAjax()){
            $id=trim(input('post.id'));
            $where['id']=$id;
            $info=model('Category')->one($where);
            if($info){
                $data['show']=($info['show']==0)?1:0;
                $path=$info['path'].',';
                $condition['path']=['like',"{$path}%"];
                $childInfo=model('Category')->cate($condition);
                $str=$id.',';
                foreach($childInfo as $k=>$v){
                    $str.=$v['id'].',';
                }
                $str=substr($str,0,-1);
                $map1['id']=['in',$str];
                $map2['cid']=['in',$str];
                Db::startTrans();
                try{
                    $row1=model('Category')->editCategory($map1,$data);
                    $row2=model('Goods')->editGoods($map2,$data);
                    if(!$row1 || !$row2){
                        throw new \Exception('更改状态失败！');
                    }
                    Db::commit();
                    $res['status']=1;
                    $res['info']='更改状态成功！';
                    return $res;
                }catch (Exception $e){
                    Db::rollback();
                    $res['status']=2;
                    $res['info']=$e->getMessage();
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
    public function editorCate(){
        if(request()->isAjax()){
            if (trim(input('post.thirdCate'))) {
                $pid=trim(input('post.thirdCate'));
            }elseif(trim(input('post.secondCate'))) {
                $pid=trim(input('post.secondCate'));
            }else {
                $pid=trim(input('post.firstCate'));
            }
            $id=trim(input('post.id'));
            $cname=trim(input('post.cname'));
            if($pid==0){
                //如果pid=0则新path=id
                $newpath=$id;
            }else{
                $where['id']=$pid;
                $info=model('Category')->one($where);
                $newpath=$info['path'].','.$id;
            }
            $condition['id']=$id;
            $cateInfo=model('Category')->one($condition);
            $oldpath=$cateInfo['path'];
            //更新分类的cname,pid,path
            $data['path']=$newpath;
            $data['pid']=$pid;
            $data['cname']=$cname;
            Db::startTrans();
            try{
                $row1=model('Category')->editCategory($condition,$data);
                //更新子分类的path
                $row2=Db::name('Catetory')->execute("update beauty_category set path=replace(path,'{$oldpath}','{$newpath}')  where path like '{$oldpath}%'");
                if(!$row1 || !$row2){
                    throw new \Exception('更新失败！');
                }
                Db::commit();
                $res['status']=1;
                $res['info']='更新成功！';
                return $res;
            }catch (Exception $e){
                Db::rollback();
                $res['status']=2;
                $res['info']=$e->getMessage();
                return $res;
            }
        }else{
            $where['id']=trim(input('param.id'));
            $info=model('Category')->one($where);
            $this->assign('info',$info);
            return $this->fetch('editor');
        }
    }

    public function export(){
        $file_name="分类列表".date("Y-m-d H:i:s",time());
        $file_suffix = "xls";
        $where='';
        if(request()->isGet()){
            if(trim(input('get.time1'))&& !trim(input('get.time2'))){
                $time1=strtotime(trim(input('get.time1')));
                $where1['addtime']=['gt',$time1];
            }elseif(trim(input('get.time2')) && !trim(input('get.time1'))){
                $time2=strtotime(trim(input('get.time2')));
                $where1['addtime']=['lt',$time2];
            }else if(trim(input('get.time2')) && trim(input('get.time1'))){
                $time1=strtotime(trim(input('get.time1')));
                $time2=strtotime(trim(input('get.time2')));
                $where1['addtime']=['between',[$time1,$time2]];
            }
            $keywords=trim(input('get.keywords'));
            $where1['cname']=['like',"%$keywords%"];
        }
        $list=model('Category')->cateList($where1);
        foreach($list as $v){
            $where['id']=['in',$v['path']];
            $list2[]=model('Category')->cateList($where);
        }
        foreach($list2 as $k2=>$v2){
            foreach($v2 as $v3){
                $list[$k2]['path'].=$v3['cname'].'->';
            }
        }
        if(IS_AJAX){
            if($list && $list2){
                $res['status']=1;
                return $res;
            }else{
                $res['status']=2;
                $res['info']='无当前商品列表信息';
                return $res;
            }
        }
        header("Content-Type:application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$file_name.$file_suffix");
        $this->assign('list',$list);
        return $this->fetch('export');
    }
}