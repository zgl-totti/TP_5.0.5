<?php
namespace app\admin\controller;

use think\Session;

class Message extends Base{
    public function index(){
        $aid=Session::get('aid');
        $where['a.receiveId']=$aid;
        $where['a.status']=['neq',3];
        $condition1['receiveId']=$aid;
        $condition1['status']=['neq',3];
        $condition2['receiveId']=$aid;
        $condition2['status']=1;
        $list=model('message')->getAll($where);
        $count1=model('message')->num($condition1);
        $count2=model('message')->num($condition2);
        $this->assign('list',$list);
        $this->assign('page',$list->render());
        $this->assign('count1',$count1);
        $this->assign('count2',$count2);
        return $this->fetch('list');
    }

    //发送站内信;
    public function sendMessage(){
        if(request()->isAjax()){
            $aid=Session::get('aid');
            $gid=input('post.role');
            dump($gid);
            $where['id']=['neq',$aid];
            $condition['group_id']=$gid;
            //判断收件人信息;
            if($gid==0){
                $uidInfo=model('Admin')->getAll($where,'id as uid');
            }else{
                $uidInfo=model('AuthGroup')->selectGroupAccess($condition,'uid');
            }
            //处理站内信主题和内容;
            $title=trim(input('post.title'));
            $content=trim(input('post.content'));
            if($title && $content){
                $data['title']=$title;
                $data['content']=$content;
                $data['time']=time();
                $id=model('Message')->addMessage($data);
                //插入站内信主表;
                if($id){
                    foreach($uidInfo as $k=>$v){
                        $info[$k]['receiveId']=$v['uid'];
                        $info[$k]['sendId']=$aid;
                        $info[$k]['textId']=$id;
                    }
                    foreach($info as $val) {
                        model('Message')->addMessageAdmin($val);
                    }
                    $res['status']=1;
                    $res['info']='发送成功';
                    return $res;
                }else{
                    $res['status']=2;
                    $res['info']='发送失败';
                    return $res;
                }
            }else{
                $res['status']=3;
                $res['info']='主题或内容不能为空！';
                return $res;
            }
        }else{
            $list=model('AuthGroup')->getGroup();
            $this->assign('list',$list);
            return $this->fetch();
        }
    }

    //删除站内信;
    public function delMessage(){
        if(request()->isAjax()) {
            $idGroup = input('post.checkbox');
            if ($idGroup) {
                foreach ($idGroup as $k1 => $v1) {
                    $info[$k1]['mailid'] = $v1;
                    $info[$k1]['status'] = 3;
                }
                if ($info) {
                    foreach ($info as $v2) {
                        $where['id'] = $v2['mailid'];
                        $data['status']=$v2['status'];
                        model('Message')->updateMessageAdmin($where,$data);
                    }
                    $res['status'] = 1;
                    $res['info'] = '删除成功';
                    return $res;
                } else {
                    $res['status'] = 2;
                    $res['info'] = '删除失败';
                    return $res;
                }
            } else {
                $res['status'] = 3;
                $res['info'] = '您还没有选择要删除的信息哦';
                return $res;
            }
        }
    }

    //彻底删除站内信;
    public function packMessage(){
        $idGroup=input('post.checkbox');
        if($idGroup) {
            foreach ($idGroup as $k1 => $v1) {
                $info[$k1]['mailid'] = $v1;
            }
            if ($info) {
                foreach ($info as $v2) {
                    $where['id']=$v2['mailid'];
                    model('Message')->delMessageAdmin($where);
                }
                $res['status'] = 1;
                $res['info'] = '删除成功';
                return $res;
            } else {
                $res['status'] = 2;
                $res['info'] = '删除失败';
                return $res;
            }
        }else{
            $res['status'] = 3;
            $res['info'] = '您还没有选择要删除的信息哦';
            return $res;
        }
    }

    //全部标为已读;
    public function readMessage(){
        if(request()->isAjax()) {
            $idGroup = input('post.checkbox');
            if ($idGroup) {
                foreach ($idGroup as $k1 => $v1) {
                    $info[$k1]['mailid'] = $v1;
                    $info[$k1]['status'] = 2;
                }
                if ($info) {
                    foreach ($info as $v2) {
                        $where['id'] = $v2['mailid'];
                        $data['status']=$v2['status'];
                        model('Message')->updateMessageAdmin($where,$data);
                    }
                    $res['status'] = 1;
                    $res['info'] = '操作成功';
                    return $res;
                } else {
                    $res['status'] = 2;
                    $res['info'] = '操作失败';
                    return $res;
                }
            } else {
                $res['status'] = 3;
                $res['info'] = '您还没有选择要删除的信息哦';
                return $res;
            }
        }
    }

    //站内信内容;
    public function messageContent(){
        $id=input('param.id');
        $where['id']=$id;
        $info=model('Message')->oneMessageAdmin($where);
        if($info['status']==1){
            $data['status']=2;
            model('Message')->updateMessageAdmin($where,$data);
        }
        $condition['a.id']=$id;
        $list=model('Message')->getOne($condition);
        $this->assign('list',$list);
        return $this->fetch('messageContent');
    }
}