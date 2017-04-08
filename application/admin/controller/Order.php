<?php
namespace app\admin\controller;

class Order extends Base{
    public function index(){
        if(request()->isGet()){
            $keywords=trim(input('get.keywords'));
            if($keywords){
                $where['o.orderno']=['like',"%$keywords%"];
                $this->assign('keywords',$keywords);
            }
            if(input('get.time1')&& !input('get.time2')){
                $time1=strtotime(input('get.time1'));
                $where['o.create_time']=['gt',$time1];
                $this->assign('time1',date('Y-m-d',$time1));
            }elseif(input('get.time2') && !input('get.time1')){
                $time2=strtotime(input('get.time2'));
                $where['o.create_time']=['lt',$time2];
                $this->assign('time2',date('Y-m-d',$time2));
            }else if(input('get.time2') && input('get.time1')){
                $time1=strtotime(input('get.time1'));
                $time2=strtotime(input('get.time2'));
                $where['o.create_time']=['between',[$time1,$time2]];
                $this->assign('time1',date('Y-m-d',$time1));
                $this->assign('time2',date('Y-m-d',$time2));
            }
        }
        $where='';
        $list=model('Order')->orderList($where,10);
        $this->assign('list',$list);
        $this->assign('page',$list->render());
        return $this->fetch();
    }
}