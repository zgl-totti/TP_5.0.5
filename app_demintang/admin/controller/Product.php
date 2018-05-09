<?php
namespace app\admin\controller;

use app\common\model\Section;
use think\Cache;
use think\Image;
use think\Loader;

class Product extends Base{
    //商品列表
    public function index(){
        $keywords=trim(input('param.keywords'));
        $cname=trim(input('param.cname'));
        if($keywords){
            $where['goodsname']=['like',"$keywords%"];
        }else{
            $where='';
        }
        if($cname){
            $section=Section::where('cname','like',"$cname%")->field('id')->select();
            foreach($section as $v){
                $b[]=$v['id'];
            }
            $condition['id']=['in',$b];
        }else{
            $condition='';
        }
        $param['query']['keywords']=$keywords;
        $param['query']['cname']=$cname;
        $list=\app\common\model\Product::with('getSection')->where($where)->where($condition)->paginate(10,false,$param);
        $this->assign('list',$list);
        $this->assign('keywords',$keywords);
        $this->assign('cname',$cname);
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        return $this->fetch();
    }

    //更新商品的上下架
    public function updateshow(){
        if(request()->isAjax()){
            $id=intval(input('post.gid'));
            $info=\app\common\model\Product::get($id);
            if($info){
                $info->status=$info['status']==0?1:0;
                $row=$info->save();
                if($row){
                    $res['status']=1;
                    $res['info']='更新状态成功！';
                    return $res;
                }else{
                    $res['status']=2;
                    $res['info']='更新状态失败！';
                    return $res;
                }
            }else{
                $res['status']=3;
                $res['info']='商品不存在！';
                return $res;
            }
        }
    }

    public function del(){
        if(request()->isAjax()){
            $id=intval(input('post.gid'));
            $info=\app\common\model\Product::get($id)->delete();
            if($info){
                $res['status']=1;
                $res['info']='删除成功！';
                return $res;
            }else{
                $res['status']=3;
                $res['info']='删除失败！';
                return $res;
            }
        }
    }

    //显示三级联动分类
    public function getCateByPid(){
        //如果pid不存在则默认为0
        $pid=input('post.pid',0);
        $list=Section::where('pid',$pid)->select();
        if($list){
            $res['status']=1;
            $res['info']=$list;
            return $res;
        }else{
            return false;
        }
    }

    //添加商品
    public function add(){
        if(request()->isPost()){
            $data['goodsname']=trim(input('post.goodsname'));
            $data['sid']=trim(input('post.sid'));
            $data['price']=trim(input('post.price'));
            $data['digest']=trim(input('post.digest'));
            $data['content']=htmlspecialchars(trim(input('post.editorValue')));
            $validate=Loader::validate('Product');
            if($validate->check($data)){
                $where['goodsname']=$data['goodsname'];
                $where['sid']=$data['sid'];
                $info=\app\common\model\Product::get($where);
                if($info){
                    $res['status']=5;
                    $res['info']='该商品已经存在,请重新添加！';
                    return $res;
                }
                $data['addtime']=time();
                $product= new \app\common\model\Product();
                if($product->save($data)){
                    if (!file_exists(ROOT_PATH.DS.'public'.DS.'uploads'.DS.'product')) {
                        mkdir(ROOT_PATH.DS.'public'.DS.'uploads'.DS.'product',0777);
                    }
                    $file=request()->file('pic');
                    $image=$file->validate(['size'=>3145728,'ext'=>'jpg,gif,png,jpeg'])
                        ->move(ROOT_PATH.'public'.DS.'uploads'.DS.'product');
                    if($image){
                        $pic=$image->getSaveName();
                        $product->pic=$pic;
                        /*$thumb=Image::open(ROOT_PATH.'public'.DS.'uploads/product/'.$pic);
                        $thumb->thumb(150,150)->save(ROOT_PATH.'public'.DS.'uploads/product_thumb/'.$pic);*/
                        if($product->save()){
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
                $res['status']=5;
                $res['info']=$validate->getError();
                return $res;
            }
        }else{
            $list=\app\common\model\Section::where('show',1)->where('pid',0)->select();
            $this->assign('list',$list);
            return $this->fetch();
        }
    }

    //添加商品
    public function edit(){
        if(request()->isPost()){
            $id=intval(input('post.id'));
            $info=\app\common\model\Product::get($id);
            $data['goodsname']=trim(input('post.goodsname'));
            $data['sid']=trim(input('post.sid'));
            $data['price']=trim(input('post.price'));
            $data['digest']=trim(input('post.digest'));
            $data['content']=htmlspecialchars(trim(input('post.editorValue')));
            $validate=Loader::validate('Product');
            if($validate->check($data)){
                if($data['goodsname']!=$info['goodsname']){
                    $where['goodsname']=$data['goodsname'];
                    $where['id']=['neq',$id];
                    $arr=\app\common\model\Product::get($where);
                    if($arr){
                        $res['status']=5;
                        $res['info']='该商品已经存在,请重新添加！';
                        return $res;
                    }
                }
                $info->goodsname=$data['goodsname'];
                $info->sid=$data['sid'];
                $info->price=$data['price'];
                $info->digest=$data['digest'];
                $info->content=$data['content'];
                $info->addtime=time();
                if($info->save()){
                    if(!$_FILES){
                        $res['status']=1;
                        $res['info']='编辑成功！';
                        return $res;
                    }
                    $file=request()->file('pic');
                    $image=$file->validate(['size'=>3145728,'ext'=>'jpg,gif,png,jpeg'])
                        ->move(ROOT_PATH.'public'.DS.'uploads'.DS.'product');
                    if($image){
                        $pic=$image->getSaveName();
                        $info->pic=$pic;
                        if($info->save()){
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
            $info=\app\common\model\Product::with('getSection')->where('id',$id)->find();
            $list=\app\common\model\Section::where('show',1)->where('pid',0)->select();
            $this->assign('list',$list);
            $this->assign('info',$info);
            return $this->fetch();
        }
    }
}