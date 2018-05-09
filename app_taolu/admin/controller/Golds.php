<?php
namespace app\admin\controller;

use think\Session;
use think\File;
class Golds extends Base{

    public function index(){
        /*$goodsname=trim(input('get.goodsname'));
        $time1=trim(input('get.time1'));
        $time2=trim(input('get.time2'));
        $bname=trim(input('get.bname'));
        $cname=trim(input('get.cname'));
        $saleprice1=trim(input('get.saleprice1'));
        $saleprice2=trim(input('get.saleprice2'));
        $time3=strtotime($time1);
        $time4=strtotime($time2);
        if($goodsname && $time1 && $time2 && $bname && $cname && $saleprice1 && $saleprice2){
            $where['g.goodsname']=['like',"%$goodsname%"];
            $where['g.addtime']=['between',[$time3,$time4]];
            $where['b.bname']=$bname;
            $where['c.cname']=$cname;
            $where['g.saleprice']=['between',[$saleprice1,$saleprice2]];
        }*/






        if(trim(input('get.goodsname'))){
            $goodsname=trim(input('get.goodsname'));
            $where['g.goodsname']=['like',"%$goodsname%"];
            $this->assign('goodsname',$goodsname);
        }
        if(input('get.time1')&& !input('get.time2')){
            $time1=strtotime(input('get.time1'));
            $where['g.addtime']=['gt',$time1];
            $this->assign('time1',$time1);
        }elseif(input('get.time2') && !input('get.time1')){
            $time2=strtotime(input('get.time2'));
            $where['g.addtime']=['lt',$time2];
            $this->assign('time2',$time2);
        }else if(input('get.time2') && input('get.time1')){
            $time1=strtotime(input('get.time1'));
            $time2=strtotime(input('get.time2'));
            $where['g.addtime']=['between',[$time1,$time2]];
            $this->assign('time1',$time1);
            $this->assign('time2',$time2);
        }
        if(trim(input('get.bname'))){
            $where['b.bname']=trim(input('get.bname'));
        }
        if(trim(input('get.cname'))){
            $where['c.cname']=trim(input('get.cname'));
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
            $this->assign('saleprice1',$saleprice1);
            $this->assign('saleprice2',$saleprice2);
        }
        if(!isset($where)){
            $where='';
        }
        $order=['g.addtime'=>'desc'];
        $list=model('Golds')->getList($where,$order,10);
        $this->assign('list',$list);
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        $this->assign('page',$list->render());
        return $this->fetch('list');
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

    //显示品牌分类
    public function brandlist(){
        $brandsList=model('Brands')->getBrands();
        if($brandsList){
            $res['status']=1;
            $res['info']=$brandsList;
            return $res;
        }else{
            return false;
        }
    }

    //添加金币商品
    public function addAct(){
        if(request()->isPost()){
            if(input('post.thirdCate')){
                $cid=input('post.thirdCate');
            }elseif(input('post.secondCate')){
                $cid=input('post.secondCate');
            }elseif(input('post.firstCate')){
                $cid=input('post.firstCate');
            }else{
                $cid=1;
            }
            $data['goodsname']=trim(input('post.goodsname'));
            $data['cid']=$cid;
            $data['bid']=input('post.bname');
            $data['saleprice']=trim(input('post.saleprice'));
            $data['score']=trim(input('post.score'));
            $data['num']=trim(input('post.num'));
            $data['addtime']=time();
            $id=model('Golds')->addGolds($data);
            if($id){
                $file=request()->file('image');
                $info=$file->validate(['size'=>3145728,'ext'=>'jpg,gif,png,jpeg'])
                    ->move(ROOT_PATH.'public'.DS.'uploads'.DS.'golds');
                if($info) {
                    $pic['picname'] = $file->getFilename();
                    $pic['picurl'] = $file->getSaveName();
                    $where['id'] = $id;
                    $row = model('Golds')->editGolds($where, $pic);
                    if ($row) {
                        Session::set('lastGid', $id);
                        $res['status'] = 1;
                        $res['info'] = '添加成功！';
                        return $res;
                    } else {
                        $res['status'] = 2;
                        $res['info'] = '添加失败！';
                        return $res;
                    }
                }else{
                    $res['status'] = 3;
                    $res['info'] = $file->getError();
                    return $res;
                }
            }else{
                $res['status']=4;
                $res['info']='添加失败！';
                return $res;
            }
        }else{
            $brandsList=model('Brands')->getBrands();
            $this->assign('brandsList',$brandsList);
            return $this->fetch();
        }
    }

    public function editor(){
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
            $gid=input('post.gid');
            $data['addtime'] = time();
            $data['description']=input('post.detail');
            $data['saleprice']=input('post.saleprice');
            $data['ismember']=input('post.ismember');
            $data['goodsname']=input('post.goodsname');
            $data['bid']=input('post.bname');
            $data['markrtprice']=input('post.marketprice');
            $data['num']=input('post.num');
            $data['ml']=input('post.ml');
            $data['cid']=$cid;
            $info=model('Golds')->getOne($data);
            if(!$info || !$info['id']==$gid){
                $where['gid']=$gid;
                $row=model('Golds')->updateGolds($where,$data);
            }


        }else{
            $gid=input('param.gid');
            $where['g.id']=$gid;
            $condition['gid']=$gid;
            $list=model('Golds')->getGoldsDetail($where);
            $goodspic=model('Golds')->getPic($condition);
            $this->assign('list',$list);
            $this->assign('goodspic',$goodspic);
            return $this->fetch();
        }
    }

    /*//上传图片
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
            M('Pic1')->add($data);
        }else{
            $this->error($info);
        }
    }*/

    //编辑商品
    public function editor1(){
        if (IS_POST) {
            //得到需要更新商品的商品id
            $gid=input('post.gid');
            $goods = M('Golds');
            $data['addtime'] = time();
            $data['description']=input('post.detail');
            $data['saleprice']=input('post.saleprice');
            $data['ismember']=input('post.ismember');
            $data['goodsname']=input('post.goodsname');
            $data['bid']=input('post.bname');
            $data['markrtprice']=input('post.marketprice');
            $data['num']=input('post.num');
            $data['ml']=input('post.ml');
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
            if ($data){
                //显示需要更新的商品信息
                if ($goods->where(array('id'=>$gid))->save($data)){
                    //更新商品的属性表，以及更新的条件
                    $where2['gid']=$gid;
//                    foreach($mlinfo as $k=>$ml){
//                        $typeml[$k]['ml']=$ml;
//                        $typeml[$k]['saleprice']=$salepriceinfo[$k];
//                        $typeml[$k]['gid']=$gid;
//                    }
//                    if(M('Gtype')->where($where2)->find()){
//                        M('Gtype')->where($where2)->delete();
//                        foreach($typeml as $val){
//                            M('Gtype')->add($val);
//                        }
//                    }
                    //更新图片信息
                    if ($_FILES) {
                        $goodsInfo = $goods->field('imageurl,imagename')->find(input('post.gid'));
                        $upload = new Upload();
                        $upload->maxSize = 3145728;// 设置附件上传大小
                        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型D
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
                                if (M('Pic1')->save($data)) {
                                    //echo $goods->getLastSql();
                                    $picInfo = M('Pic1')->field('picname')->find($pid);
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
            $goodsOne = M('Golds')->alias('g')->join('beauty_category c ON g.cid=c.id')
                ->where(array('g.id' => $gid))->field('g.*,cname,path,g.ml')->find();
            $goodsOne['description'] = html_entity_decode($goodsOne['description']);
            $where['id'] = array('in', $goodsOne['path']);
            $cate = M('category')->where($where)->field('id,cname')->select();
            $goodspic = M('Pic1')->where(array('gid' => $gid))->select();
            $this->assign('goodsOne', $goodsOne);
            $this->assign('cate', $cate);
            $this->assign('goodspic',$goodspic);
            $this->display('editor');
        }
    }

    public function export(){
        $file_name="商品列表".date("Y-m-d H:i:s",time());
        $file_suffix = "xls";
        if(request()->isGet()){
            if(trim(input('get.goodsname'))){
                $goodsname=trim(input('get.goodsname'));
                $where['g.goodsname']=['like',"%$goodsname%"];
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
            if(trim(input('get.bname'))){
                $where['b.bname']=trim(input('get.bname'));
            }
            if(trim(input('get.cname'))){
                $where['c.cname']=trim(input('get.cname'));
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
        }else{
            $where='';
        }





        $model=D('Golds');
        $res=$model->goodsExcel($where);
        if(IS_AJAX){
            if($res){
                $this->success();
                exit;
            }else{
                $this->error('无当前商品列表信息');
            }
        }
        header("Content-Type:application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$file_name.$file_suffix");
        //根据业务，自己进行模板赋值。
        $this->assign('goodsinfo',$res);
    }

    //更细商品上下架
    public function updateshow(){
        if(request()->isAjax()){
            $gid=input('post.gid');
            $where['id']=$gid;
            $info=model('Golds')->getOne($where);
            if($info){
                $data['show']=($info['show']==0)?1:0;
                $row=model('Golds')->updateGolds($where,$data);
                if($row){
                    $res['status']=3;
                    $res['info']='更改状态成功！';
                    return $res;
                }else{
                    $res['status']=3;
                    $res['info']='更改状态失败！';
                    return $res;
                }
            }else{
                $res['status']=3;
                $res['info']='金币商品不存在！';
                return $res;
            }
        }
    }







}