<?php
namespace app\admin\controller;

class Feedback extends Base{

    //后台活动发布中的活动列表
    public function index(){
        $time1=strtotime(input('get.time1'));
        $time2=strtotime(input('get.time2'));
        if($time1 && $time2){
            $where['backtime']=['between',[$time1,$time2]];
        }elseif($time1){
            $where['backtime']=['gt',$time1];
        }elseif($time2){
            $where['backtime']=['lt',$time2];
        }else{
            $where='';
        }
        $list=model('Feedback')->getAll($where,'backtime desc');
        $this->assign('time1',$time1?$time1:'');
        $this->assign('time2',$time2?$time2:'');
        $this->assign('list',$list);
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        $this->assign('page',$list->render());
        return $this->fetch('list');
    }

    public function deleteFeed(){
        if(request()->isAjax()){
            $where['id']=input('get.id');
            $row=model('Feedback')->del($where);
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

    public function see(){
        $id=input('param.id');
        $where['id']=$id;
        $backInfo=model('Feedback')->getOne($where);
        $this->assign('backInfo',$backInfo);
        return $this->fetch('see');
    }

}