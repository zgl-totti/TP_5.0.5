<?php
namespace app\admin\controller;

use think\Cache;

class Goods extends Base{
    //商品列表
    public function index(){
        if(input('get.time1')&& !input('get.time2')){
            $time1=strtotime(input('get.time1'));
            $where['g.addtime']=['gt',$time1];
            $this->assign('time1',date('Y-m-d',$time1));
        }elseif(input('get.time2') && !input('get.time1')){
            $time2=strtotime(input('get.time2'));
            $where['g.addtime']=['lt',$time2];
            $this->assign('time2',date('Y-m-d',$time2));
        }else if(input('get.time2') && input('get.time1')){
            $time1=strtotime(input('get.time1'));
            $time2=strtotime(input('get.time2'));
            $where['g.addtime']=['between',[$time1,$time2]];
        }
        if(input('get.bname')){
            $where['b.bname']=input('get.bname');
            $this->assign('bname',input('get.bname'));
        }
        if(input('get.cname')){
            $where['c.cname']=input('get.cname');
            $this->assign('cname',input('get.cname'));
        }
        if(input('get.saleprice1')&& !input('get.saleprice2')){
            $saleprice1=input('get.saleptice1');
            $where['g.saleprice']=['gt',$saleprice1];
            $this->assign('saleprice1',$saleprice1);
        }elseif(input('get.saleprice2') && !input('get.saleprice1')){
            $saleprice2=input('get.saleprice2');
            $where['g.saleprice']=['lt',$saleprice2];
            $this->assign('saleprice2',$saleprice2);
        }else if(input('get.saleprice1') && input('get.saleprice2')){
            $saleprice1=input('get.saleprice1');
            $saleprice2=input('get.saleprice2');
            $where['g.saleprice']=['between',[$saleprice1,$saleprice2]];
        }
        $goodsname=input('get.goodsname');
        if($goodsname) {
            $where['g.goodsname'] = ['like', "%$goodsname%"];
            $this->assign('goodsname', $goodsname);
        }
        if(!isset($where)){
            $where='';
        }
        $list=model('Goods')->goodsAll($where);
        $this->assign('goodslist',$list);
        $this->assign('page',$list->render());
        return $this->fetch('list');
    }

    //添加活动中后台清除品牌缓存
    public function clearCache(){
        if(request()->isAjax()){
            if(Cache::pull('goodslist')){
                $res['status']=1;
                $res['info']='清除缓存成功！';
                return $res;
            }else{
                $res['status']=2;
                $res['info']='清除缓存失败！';
                return $res;
            }
        }
    }

    //更新商品的上下架
    public function updateshow(){
        if(request()->isAjax()){
            $where['id']=input('post.gid');
            $info=model('goods')->one($where);
            if($info){
                $data['show']=($info['show']==0)?1:0;
                $row=model('goods')->editGoods($where,$data);
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

    //显示三级联动分类
    public function getCateByPid(){
        //如果pid不存在则默认为0
        $pid=input('post.pid',0);
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

    //后台活动发布中的添加活动
    public function brandlist(){
        $brandsList=D('brands')->getBrandsList();
        $this->success($brandsList);
    }

    //添加商品
    public function addAct(){
        if(request()->isAjax()){
            if(input('post.thirdCate')){
                $cid=input('post.thirdCate');
            }elseif(input('post.secondCate')){
                $cid=input('post.secondCate');
            }elseif(input('post.firstCate')){
                $cid=input('post.firstCate');
            }else{
                $cid=1;
            }
            $data['goodsname']=input('post.goodsname');
            $data['bid']=input('post.bid');
            $data['cid']=$cid;
            $onegoods=model('Goods')->one($data);
            if($onegoods){
                $res['status']=5;
                $res['info']='该商品已经存在,请重新添加！';
                return $res;
            }else{
                $data['ml']=input('post.ml');
                $data['score']=input('post.score');
                $data['marketprice']=input('post.marketprice');
                $data['saleprice']=input('post.saleprice');
                $data['discount']=input('post.discount');
                $data['ismember']=input('post.ismember');
                $data['num']=input('post.num');
                $data['description']=input('post.description');
                $data['addtime']=time();
                $insertId=model('goods')->addGoods($data);
                if($insertId){
                    //创建上传文件夹;
                    if (!file_exists(ROOT_PATH.'public'.DS.'uploads'.DS.'goods')) {
                        mkdir(ROOT_PATH.'public'.DS.'uploads'.DS.'goods');
                    }
                    //处理图片上传;
                    $file=request()->file('image');
                    $info=$file->validate(['size'=>3145728,'ext'=>'jpg,gif,png,jpeg'])
                        ->move(ROOT_PATH.'public'.DS.'uploads'.DS.'goods');
                    if($info){
                        $pic['picname']=$file->getFilename();
                        $pic['picurl']=$file->getSaveName();
                        $where['id']=$insertId;
                        $row=model('goods')->editGoods($where,$pic);
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
                }else{
                    $res['status']=4;
                    $res['info']='添加失败！';
                    return $res;
                }
            }
        }else{
            return $this->fetch();
        }
    }

    //添加商品
    public function addAct1(){
            if(request()->isAjax()){
                $goods=D('Goods');
                $data=$goods->create();
                if($data){
                    if(input('post.thirdCate')){
                        $cid=input('post.thirdCate');
                    }elseif(input('post.secondCate')){
                        $cid=input('post.secondCate');
                    }else{
                        if(input('post.firstCate')){
                            $cid=input('post.firstCate');
                        }else{
                            $cid=1;
                        }
                    }
                    $bid=input('post.bname');
                    $goodsname=input('post.goodsname');
                    $goodswhere['bid']=$bid;
                    $goodswhere['cid']=$cid;
                    $goodswhere['goodsname']=$goodsname;
                    if(M('Goods')->where($goodswhere)->find()){
                        $this->error('该商品已经存在,请重新添加');
                    }
                    $data['cid']=$cid;
                    $salepricestr=input('post.saleprice');
                    $salepricearr=explode(',',$salepricestr);
                    $data['saleprice']=$salepricearr[0];
                    $common=A('Common');
                    $info=$common->uploadPic();
                    if(is_array($info)){
                        $image=new Image();
                        //获取图片文件路径
                        $filename='./Uploads/'.$info[0]['savepath'].$info[0]['savename'];
                        //缩略
                        $thumb500='./Uploads/'.$info[0]['savepath'].'500_'.$info[0]['savename'];
                        $thumb300='./Uploads/'.$info[0]['savepath'].'300_'.$info[0]['savename'];
                        $thumb100='./Uploads/'.$info[0]['savepath'].'100_'.$info[0]['savename'];
                        $image->open($filename)->thumb('300','300')->save($thumb300);
                        $image->open($filename)->thumb('100','100')->save($thumb100);
                        $image->open($filename)->thumb('500','500')->save($thumb500);

                    }else{
                        $this->error();
                    }
                    $data['addtime']=time();
                    $data['imageurl']=$info[0]['savepath'];
                    $data['imagename']=$info[0]['savename'];
                    $gid=$goods->addGoods($data);
                    if($gid){
                        session('lastGid',$gid);
                        $mlstr=input('post.ml');
                        $mlarr=explode(',',$mlstr);
                        foreach($mlarr as $k=>$ml){
                            $type[$k]['ml']=$ml;
                            $type[$k]['saleprice']=$salepricearr[$k];
                            $type[$k]['gid']=$gid;
                        }
                        foreach($type as $val){
                            M('Type')->add($val);
                        }
                        $this->success('商品添加成功');
                    }else{
                        $this->error('商品添加失败');
                    };
                }else{
                    $this->error($goods->getError());
                }
            }else{
                $this->display();
            }
    }

    //上传图片
    public function uploadGoodsPic(){
        $common=A('Common');
        $info=$common->uploadPic();
        if(is_array($info)){
            $image=new Image();
            //获取图片文件路径
            $filename='./Uploads/'.$info['file']['savepath'].$info['file']['savename'];
            //缩略
            $thumb500='./Uploads/'.$info['file']['savepath'].'500_'.$info['file']['savename'];
            $thumb300='./Uploads/'.$info['file']['savepath'].'300_'.$info['file']['savename'];
            $thumb100='./Uploads/'.$info['file']['savepath'].'100_'.$info['file']['savename'];
            $image->open($filename)->thumb('300','300')->save($thumb300);
            $image->open($filename)->thumb('100','100')->save($thumb100);
            $image->open($filename)->thumb('500','500')->save($thumb500);

            $data['gid']=session('lastGid');
            $data['picname']=$info['file']['savename'];
            $data['picurl']=$info['file']['savepath'];
            M('Pic')->add($data);
        }else{
            $this->error($info);
        }
    }

    //编辑商品
    public function editor(){
        if (request()->isAjax()) {
            //得到需要更新商品的商品id
            $gid=input('post.gid');
            $goods = M('goods');
            $data['addtime'] = time();
            $salepriceinfo=input('post.saleprice');
            $mlinfo=input('post.ml');
            if(is_array($salepriceinfo)){
                $data['saleprice']=$salepriceinfo[0];
            }else{
                $data['saleprice']=$salepriceinfo;
            }
            $data['ismember']=input('post.ismember');
            $data['goodsname']=input('post.goodsname');
            if(input('post.bname')){
                $data['bid']=input('post.bname');
            }else{
                $this->error('请选择商品品牌');
            }
            $data['score']=input('post.score');
            $data['marketprice']=input('post.marketprice');
            $data['discount']=input('post.discount');
            $data['num']=input('post.num');
            if(input('post.thirdCate')){
                $data['cid']=input('post.thirdCate');
            }elseif(input('post.secondCate')){
                $data['cid']=input('post.secondCate');
            }else{
                if(input('post.firstCate')){
                    $data['cid']=input('post.firstCate');
                }else{
                    $data['cid']=1;
                }
            }
            if(input('post.detail')){
                $data['description']=input('post.detail');
            }else{
                $this->error('请填写对商品的描述信息');
            }
            if ($data){
                //显示需要更新的商品信息
                if ($goods->where(['id'=>$gid])->save($data)){
                    //更新商品的属性表，以及更新的条件
                    $where2['gid']=$gid;
                    foreach($mlinfo as $k=>$ml){
                        $typeml[$k]['ml']=$ml;
                        $typeml[$k]['saleprice']=$salepriceinfo[$k];
                        $typeml[$k]['gid']=$gid;
                    }
                    if(M('Type')->where($where2)->find()){
                        M('Type')->where($where2)->delete();
                        foreach($typeml as $val){
                            M('Type')->add($val);
                        }
                    }
                    //更新图片信息
                    if ($_FILES) {
                        $goodsInfo = $goods->field('imageurl,imagename')->find(input('post.gid'));
                        $upload = new Upload();
                        $upload->maxSize = 3145728;// 设置附件上传大小
                        $upload->exts = ['jpg', 'gif', 'png', 'jpeg'];// 设置附件上传类型D
                        $upload->rootPath = './Uploads/'; // 设置附件上传根目录
                        $upload->savePath = "{$goodsInfo['imageurl']}";
                        $upload->autoSub = false;
                        $info = $upload->upload();

                        foreach ($info as $key => $val) {
                            $image = new Image();
                            //获取图片文件路径
                            $filename = './Uploads/' . $val['savepath'] . $val['savename'];
                            //缩略
                            $thumb500 = './Uploads/' . $val['savepath'] . '500_' . $val['savename'];
                            $thumb300 = './Uploads/' . $val['savepath'] . '300_' . $val['savename'];
                            $thumb100 = './Uploads/' . $val['savepath'] . '100_' . $val['savename'];
                            $image->open($filename)->thumb('300', '300')->save($thumb300);
                            $image->open($filename)->thumb('100', '100')->save($thumb100);
                            $image->open($filename)->thumb('500', '500')->save($thumb500);

                            //修改主图
                            if ($key == 0) {
                                $data['id'] = input('post.gid');
                                $data['imagename'] = $val['savename'];
                                if ($goods->save($data)) {
                                    //删除原图
                                    unlink('./Uploads/' . $goodsInfo['imageurl'] . $goodsInfo['imagename']);
                                    unlink('./Uploads/' . $goodsInfo['imageurl'] . '500_' . $goodsInfo['imagename']);
                                    unlink('./Uploads/' . $goodsInfo['imageurl'] . '300_' . $goodsInfo['imagename']);
                                    unlink('./Uploads/' . $goodsInfo['imageurl'] . '100_' . $goodsInfo['imagename']);
                                } else {
                                    $this->error('主图更新失败');
                                };
                            } else if ($key > 0) { //修改辅图
                                $pid = $key;
                                $data['id'] = $pid;
                                $data['picname'] = $val['savename'];
                                $data['picurl'] = $val['savepath'];
                                if (M('Pic')->save($data)) {
                                    //echo $goods->getLastSql();
                                    $picInfo = M('Pic')->field('picname')->find($pid);
                                    //删除原图
                                    unlink('./Uploads/' . $goodsInfo['imageurl'] . $picInfo['imagename']);
                                    unlink('./Uploads/' . $goodsInfo['imageurl'] . '500_' . $picInfo['imagename']);
                                    unlink('./Uploads/' . $goodsInfo['imageurl'] . '300_' . $picInfo['imagename']);
                                    unlink('./Uploads/' . $goodsInfo['imageurl'] . '100_' . $picInfo['imagename']);
                                }
                            }
                        }
                    }
                    $this->success('商品更新成功');
                } else {
                    $this->error($gid);
                }
            } else {
                $this->error($goods->getError());
            }
        } else {
            $gid = trim(input('get.gid'));
            $goodsOne = M('goods')->alias('g')->join('beauty_category c ON g.cid=c.id')
                ->where(['g.id' => $gid])->field('g.*,cname,path')->find();
            $goodsOne['description'] = html_entity_decode($goodsOne['description']);
            $where['id'] = ['in', $goodsOne['path']];
            $cate = M('category')->where($where)->field('id,cname')->select();
            $goodspic = M('Pic')->where(['gid' => $gid])->select();
            $type['gid']=$gid;
            //显示商品的属性信息
            $type=M('Goods')->table('beauty_type')->field('ml,saleprice')->where($type)->select();
            $this->assign('goodsOne', $goodsOne);
            $this->assign('cate', $cate);
            $this->assign('goodspic',$goodspic);
            $this->assign('type',$type);
            $this->display('editor');
        }
    }

    public function export(){
        $file_name="商品列表".date("Y-m-d H:i:s",time());
        $file_suffix = "xls";
        if(input('get.goodsname')){
            $keywords=input('get.goodsname');
            $where['g.goodsname']=['like',"%$keywords%"];
        }
        if(input('get.bname')){
            $where['b.bname']=input('get.bname');
        }
        if(input('get.cname')){
            $where['c.bname']=input('get.cname');
        }
        if(input('get.time1')&& !input('get.time2')){
            $time1=strtotime(input('get.time1'));
            $where['g.addtime']=['gt',$time1];
        }elseif(input('get.time2') && !input('get.time1')){
            $time2=strtotime(input('get.time2'));
            $where['g.addtime']=['lt',$time2];
        }else if(input('get.time2') && input('get.time1')){
            $time1=strtotime(input('get.time1'));
            $time2=strtotime(input('get.time2'));
            $where['g.addtime']=['between',[$time1,$time2]];
        }
        if(input('get.saleprice1')&& !input('get.saleprice2')){
            $saleprice1=input('get.saleptice1');
            $where['g.saleprice']=['gt',$saleprice1];
        }elseif(input('get.saleprice2') && !input('get.saleprice1')){
            $saleprice2=input('get.saleprice2');
            $where['g.saleprice']=['lt',$saleprice2];
        }else if(input('get.saleprice1') && input('get.saleprice2')){
            $saleprice1=input('get.saleprice1');
            $saleprice2=input('get.saleprice2');
            $where['g.saleprice']=['between',[$saleprice1,$saleprice2]];
        }
        $model=D('Goods');
        $res=$model->goodsExcel($where);
        if(IS_AJAX){
            if($res){
                $this->success();
            }else{
                $this->error('无当前商品列表信息');
            }
        }
        header("Content-Type:application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$file_name.$file_suffix");
        //根据业务，自己进行模板赋值。
        $this->assign('goodsinfo',$res);
        $this->display();
    }
}