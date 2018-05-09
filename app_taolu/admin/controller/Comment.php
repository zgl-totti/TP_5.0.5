<?php
namespace app\admin\controller;

class Comment extends Base{
    public function index(){
        if(request()->isGet()){
            if(input('get.time1') && !input('get.time2')){
                $time1=strtotime(input('get.time1'));
                $where['coaddtime']=['gt',$time1];
                $this->assign('time1',date('Y-m-d',$time1));
            }elseif(input('get.time2') && !input('get.time1')){
                $time2=strtotime(input('get.time2'));
                $where['coaddtime']=['lt',$time2];
                $this->assign('time2',date('Y-m-d',$time2));
            }else if(input('get.time2') && input('get.time1')){
                $time1=strtotime(input('get.time1'));
                $time2=strtotime(input('get.time2'));
                $where['coaddtime']=['between',[$time1,$time2]];
                $this->assign('time1',date('Y-m-d',$time1));
                $this->assign('time2',date('Y-m-d',$time2));
            }
            if(input('get.status')){
                $where['respid']=input('get.status');
                if(input('get.status')==1){
                    $statusname='未回复';
                    $this->assign('respid1',$statusname);
                }if(input('get.status')==1){
                    $statusname='已回复';
                    $this->assign('respid2',$statusname);
                }
            }else{
                $where['respid']=['in','1,2'];
                $statusname='全部';
                $this->assign('respid3',$statusname);
            }
        }
        $where['c.cstatus']=['in','5,6'];
        $commentList=model('Comment')->getAll($where,'c.coaddtime desc');
        $this->assign('commentList',$commentList);
        $this->assign('firstRow',($commentList->currentPage()-1)*$commentList->listRows());
        $this->assign('page',$commentList->render());
        return $this->fetch('list');
    }

    public function yiresponse(){
        if(request()->isGet()){
            if(input('get.time1') && !input('get.time2')){
                $time1=strtotime(input('get.time1'));
                $where['coaddtime']=['gt',$time1];
                $this->assign('time1',date('Y-m-d',$time1));
            }elseif(input('get.time2') && !input('get.time1')){
                $time2=strtotime(input('get.time2'));
                $where['coaddtime']=['lt',$time2];
                $this->assign('time2',date('Y-m-d',$time2));
            }else if(input('get.time2') && input('get.time1')){
                $time1=strtotime(input('get.time1'));
                $time2=strtotime(input('get.time2'));
                $where['coaddtime']=['between',[$time1,$time2]];
                $this->assign('time1',date('Y-m-d',$time1));
                $this->assign('time2',date('Y-m-d',$time2));
            }
            if(input('get.status')){
                $where['respid']=input('get.status');
                if(input('get.status')==1){
                    $statusname='未回复';
                    $this->assign('respid1',$statusname);
                }if(input('get.status')==1){
                    $statusname='已回复';
                    $this->assign('respid2',$statusname);
                }
            }else{
                $where['respid']=['in','1,2'];
                $statusname='全部';
                $this->assign('respid3',$statusname);
            }
        }
        $where['c.cstatus']=['in','5,6'];
        $where['c.respid']=2;
        $commentList=model('Comment')->getAll($where,'c.coaddtime desc');
        $this->assign('commentList',$commentList);
        $this->assign('firstRow',($commentList->currentPage()-1)*$commentList->listRows());
        $this->assign('page',$commentList->render());
        $this->assign('empty','<h1 style="font-size: 20px;">没有找到相应的数据</h1>');
        return $this->fetch('yiresponse');
    }

    public function weiresponse(){
        if(request()->isGet()){
            if(input('get.time1') && !input('get.time2')){
                $time1=strtotime(input('get.time1'));
                $where['coaddtime']=['gt',$time1];
                $this->assign('time1',date('Y-m-d',$time1));
            }elseif(input('get.time2') && !input('get.time1')){
                $time2=strtotime(input('get.time2'));
                $where['coaddtime']=['lt',$time2];
                $this->assign('time2',date('Y-m-d',$time2));
            }else if(input('get.time2') && input('get.time1')){
                $time1=strtotime(input('get.time1'));
                $time2=strtotime(input('get.time2'));
                $where['coaddtime']=['between',[$time1,$time2]];
                $this->assign('time1',date('Y-m-d',$time1));
                $this->assign('time2',date('Y-m-d',$time2));
            }
            if(input('get.status')){
                $where['respid']=input('get.status');
                if(input('get.status')==1){
                    $statusname='未回复';
                    $this->assign('respid1',$statusname);
                }if(input('get.status')==1){
                    $statusname='已回复';
                    $this->assign('respid2',$statusname);
                }
            }else{
                $where['respid']=['in','1,2'];
                $statusname='全部';
                $this->assign('respid3',$statusname);
            }
        }
        $where['c.cstatus']=['in','5,6'];
        $where['c.respid']=1;
        $commentList=model('Comment')->getAll($where,'c.coaddtime desc');
        /*$cosid=model('Comment')->getCosid($where);
        dump($cosid);
        $this->assign('cosid',$cosid);*/
        $this->assign('commentList',$commentList);
        $this->assign('firstRow',($commentList->currentPage()-1)*$commentList->listRows());
        $this->assign('page',$commentList->render());
        $this->assign('empty','<h1 style="font-size: 20px;">没有找到相应的数据</h1>');
        return $this->fetch('weiresponse');
    }

    public function response(){
        //更新评论表里面的卖家回复
        if(request()->isAjax()){
            $condition['oid']=input('post.oid');
            $condition['mid']=input('post.mid');
            $condition['gid']=input('post.gid');
            $condition['coaddtime']=input('post.coaddtime');
            $data['respid']=2;
            $data['response']=trim(input('post.content'));
            $data['readdtime']=time();
            if($data['response']){
                $row=model('Comment')->updateComment($condition,$data);
                if($row){
                    $res['status']=1;
                    $res['info']='回复成功！';
                    return $res;
                }else{
                    $res['status']=2;
                    $res['info']='回复失败！';
                    return $res;
                }
            }else{
                $res['status']=3;
                $res['info']='回复不能为空！';
                return $res;
            }
        }else {
            $where['c.oid']=input('param.oid');
            $where['c.gid']=input('param.gid');
            $where['c.mid']=input('param.mid');
            $where['c.coaddtime']=input('param.coaddtime');
            $commentList = model('Comment')->getCommentAll($where);
            $this->assign('commentList', $commentList);
            return $this->fetch('response');
        }
    }

    public function see(){
        $where['c.oid']=input('param.oid');
        $where['c.gid']=input('param.gid');
        $where['c.mid']=input('param.mid');
        $where['c.coaddtime']=input('param.coaddtime');
        $commentList=model('Comment')->getCommentAll($where);
        $this->assign('commentList',$commentList);
        return $this->fetch('see');
    }

    public function duoresponse(){
        $cosid=input('param.cosid');
        $this->assign('cosid',$cosid);
        return $this->fetch('duoresponse');
    }

    public function pilresponse(){
        if(request()->isAjax()){
            if(input('post.cosid')){
                $cosid=input('post.cosid');
            }else{
                $cosid=['in','1,2,3'];
            }
            $where['cosid']=$cosid;
            $where['respid']=1;
            $data['response']=trim(input('post.content'));
            $data['readdtime']=time();
            $row=model('Comment')->updateComment($where,$data);
            if($row){
                $info['respid']=2;
                $id=model('Comment')->updateComment($where,$info);
                if($id){
                    $res['status']=1;
                    $res['info']='回复成功！';
                    return $res;
                }else{
                    $res['status']=2;
                    $res['info']='回复失败！';
                    return $res;
                }
            }else{
                $res['status']=3;
                $res['info']='回复失败！';
                return $res;
            }
        }
    }
}