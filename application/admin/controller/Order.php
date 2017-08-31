<?php
namespace app\admin\controller;

class Order extends Base{
    public function index(){
        $keywords=trim(input('get.keywords'));
        $time1=trim(input('get.time1'));
        $time2=trim(input('get.time2'));
        $time3=strtotime($time1);
        $time4=strtotime($time2);
        if($keywords){
            $where['orderno']=['like',"%$keywords%"];
        }else{
            $where='';
        }
        if($time1 && $time2){
            $condition['create_time']=['between',[$time3,$time4]];
        }elseif($time1 && !$time2){
            $condition['create_time']=['gt',$time3];
        }elseif($time2 && !$time1){
            $condition['create_time']=['lt',$time4];
        }else{
            $condition='';
        }
        $data['query']['keywords']=$keywords;
        $list=\app\admin\model\Order::where($where)
            ->where($condition)
            ->with('orderStatus')
            ->with('users')
            ->paginate(10,false,$data);
        $this->assign('keywords',$keywords);
        $this->assign('time1',$time1);
        $this->assign('time2',$time2);
        $this->assign('list',$list);
        $this->assign('pages',$list->render());
        return $this->fetch();
    }
}