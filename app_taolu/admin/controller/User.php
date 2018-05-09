<?php
namespace app\admin\controller;

use think\Session;

class User extends Base{
    //列表
    public function UserList(){
        $keywords=strtolower(trim(input('get.chaXun')));
        if($keywords){
            $where['username'] = ['like', "%{$keywords}%"];
            $this->assign('chaXun',$keywords);
        }else {
            $where='';
        }
        $UserInfo=model('User')->getAll($where);
        //dump($UserInfo);
        $this->assign('UserInfo', $UserInfo);
        $this->assign('page',$UserInfo->render());
        $this->assign('firstRow',($UserInfo->currentPage()-1)*$UserInfo->listRows());
        return $this->fetch('list');
    }

    //发送站内信;
    public function sendUserMessage(){
        if(request()->isAjax()){
            $aid=Session::get('aid');
            $gid=input('post.role');
            //判断收件人信息;
            if($gid==0){
                $where='';
                $midInfo=model('User')->getAllUser($where,'id as mid');
            }else{
                $where['memberorder']=$gid;
                $midInfo=model('User')->getAllUser($where,'id as mid');
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
                    foreach($midInfo as $k=>$v){
                        $info[$k]['receiveId']=$v['mid'];
                        $info[$k]['sendId']=$aid;
                        $info[$k]['textId']=$id;
                    }
                    foreach($info as $val) {
                        model('Message')->addMessageUser($val);
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
            $where='';
            $list=model('User')->getAllVipinfo($where);
            $this->assign('list',$list);
            return $this->fetch();
        }
    }
}