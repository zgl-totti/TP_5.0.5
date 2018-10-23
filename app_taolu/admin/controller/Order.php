<?php
namespace app\admin\controller;

class Order extends Base{
    //订单列表
    public function index(){
        $keywords=trim(input('get.keywords'));
        $time1=strtotime(trim(input('get.time1')));
        $time2=strtotime(trim(input('get.time2')));
        if($keywords && $time1 && $time2){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['between',[$time1,$time2]];
        }elseif($keywords && $time1){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['gt',$time1];
        }elseif($keywords && $time2){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['lt',$time2];
        }elseif($time1 && $time2){
            $where['o.create_time']=['between',[$time1,$time2]];
        }elseif($time1){
            $where['o.create_time']=['gt',$time1];
        }elseif($time2){
            $where['o.create_time']=['lt',$time1];
        }else{
            $where='';
        }
        $list=model('Order')->orderList($where);
        $this->assign('list',$list);
        $this->assign('page',$list->render());
        $this->assign('keywords',$keywords?$keywords:'');
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        return $this->fetch('list');
    }

    //订单详情
    public function detial(){
        $oid=input('param.oid');
        $list=model('order')->orderDetail($oid);
        $this->assign('list',$list);
        return $this->fetch('detail');
    }

    public function dfk(){
        $keywords=trim(input('get.keywords'));
        $time1=strtotime(trim(input('get.time1')));
        $time2=strtotime(trim(input('get.time2')));
        if($keywords && $time1 && $time2){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['between',[$time1,$time2]];
        }elseif($keywords && $time1){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['gt',$time1];
        }elseif($keywords && $time2){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['lt',$time2];
        }elseif($time1 && $time2){
            $where['o.create_time']=['between',[$time1,$time2]];
        }elseif($time1){
            $where['o.create_time']=['gt',$time1];
        }elseif($time2){
            $where['o.create_time']=['lt',$time1];
        }else{
            $where['o.status']=1;
        }
        $list=model('order')->orderList($where);
        $this->assign('list',$list);
        $this->assign('page',$list->render());
        $this->assign('keywords',$keywords?$keywords:'');
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        return $this->fetch('dfk');
    }
    
    public function dfh(){
        $keywords=trim(input('get.keywords'));
        $time1=strtotime(trim(input('get.time1')));
        $time2=strtotime(trim(input('get.time2')));
        if($keywords && $time1 && $time2){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['between',[$time1,$time2]];
        }elseif($keywords && $time1){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['gt',$time1];
        }elseif($keywords && $time2){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['lt',$time2];
        }elseif($time1 && $time2){
            $where['o.create_time']=['between',[$time1,$time2]];
        }elseif($time1){
            $where['o.create_time']=['gt',$time1];
        }elseif($time2){
            $where['o.create_time']=['lt',$time1];
        }else{
            $where['o.status']=2;
        }
        $list=model('order')->orderList($where);
        $this->assign('list',$list);
        $this->assign('page',$list->render());
        $this->assign('keywords',$keywords?$keywords:'');
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        return $this->fetch('dfh');
    }
    
    public function yfh(){
        $keywords=trim(input('get.keywords'));
        $time1=strtotime(trim(input('get.time1')));
        $time2=strtotime(trim(input('get.time2')));
        if($keywords && $time1 && $time2){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['between',[$time1,$time2]];
        }elseif($keywords && $time1){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['gt',$time1];
        }elseif($keywords && $time2){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['lt',$time2];
        }elseif($time1 && $time2){
            $where['o.create_time']=['between',[$time1,$time2]];
        }elseif($time1){
            $where['o.create_time']=['gt',$time1];
        }elseif($time2){
            $where['o.create_time']=['lt',$time1];
        }else{
            $where['o.status']=3;
        }
        $list=model('order')->orderList($where);
        $this->assign('list',$list);
        $this->assign('page',$list->render());
        $this->assign('keywords',$keywords?$keywords:'');
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        return $this->fetch('yfh');
    }
    
    public function ysh(){
        $keywords=trim(input('get.keywords'));
        $time1=strtotime(trim(input('get.time1')));
        $time2=strtotime(trim(input('get.time2')));
        if($keywords && $time1 && $time2){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['between',[$time1,$time2]];
        }elseif($keywords && $time1){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['gt',$time1];
        }elseif($keywords && $time2){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['lt',$time2];
        }elseif($time1 && $time2){
            $where['o.create_time']=['between',[$time1,$time2]];
        }elseif($time1){
            $where['o.create_time']=['gt',$time1];
        }elseif($time2){
            $where['o.create_time']=['lt',$time1];
        }else{
            $where['o.status']=4;
        }
        $list=model('order')->orderList($where);
        $this->assign('list',$list);
        $this->assign('page',$list->render());
        $this->assign('keywords',$keywords?$keywords:'');
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        return $this->fetch('ysh');
    }

    public function ypj(){
        $keywords=trim(input('get.keywords'));
        $time1=strtotime(trim(input('get.time1')));
        $time2=strtotime(trim(input('get.time2')));
        if($keywords && $time1 && $time2){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['between',[$time1,$time2]];
        }elseif($keywords && $time1){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['gt',$time1];
        }elseif($keywords && $time2){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['lt',$time2];
        }elseif($time1 && $time2){
            $where['o.create_time']=['between',[$time1,$time2]];
        }elseif($time1){
            $where['o.create_time']=['gt',$time1];
        }elseif($time2){
            $where['o.create_time']=['lt',$time1];
        }else{
            $where['o.status']=5;
        }
        $list=model('order')->orderList($where);
        $this->assign('list',$list);
        $this->assign('page',$list->render());
        $this->assign('keywords',$keywords?$keywords:'');
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        return $this->fetch('ysh');
    }

    public function sendGoods(){
        if(request()->isAjax()){
            $where['id']=input('post.id');
            $info=model('order')->one($where);
            if($info['status']==2){
                $data['status']=3;
                $row=model('order')->updateSatus($where,$data);
                if($row){
                    $res['status']=1;
                    $res['info']='更新成功！';
                    return $res;
                }else{
                    $res['status']=2;
                    $res['info']='更新失败！';
                    return $res;
                }
            }else{
                $res['status']=3;
                $res['info']='更新失败！';
                return $res;
            }
        }
    }

    public function export(){
        $file_name="订单列表".date("Y-m-d H:i:s",time());
        $file_suffix = "xls";
        $keywords=trim(input('get.keywords'));
        $time1=strtotime(trim(input('get.time1')));
        $time2=strtotime(trim(input('get.time2')));
        if($keywords && $time1 && $time2){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['between',[$time1,$time2]];
        }elseif($keywords && $time1){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['gt',$time1];
        }elseif($keywords && $time2){
            $where['o.orderno']=['like',"%$keywords%"];
            $where['o.create_time']=['lt',$time2];
        }elseif($time1 && $time2){
            $where['o.create_time']=['between',[$time1,$time2]];
        }elseif($time1){
            $where['o.create_time']=['gt',$time1];
        }elseif($time2){
            $where['o.create_time']=['lt',$time1];
        }else{
            $where='';
        }
        $list=model('order')->orderList($where);
        if(request()->isAjax()){
            if($list){
                $res['status']=1;
                return $res;
            }else{
                $res['status']=2;
                $res['info']='无当前订单信息';
                return $res;
            }
        }

        //处理大数据量的导出
        set_time_limit(0);                                  #设置超时时间
        ini_set("memory_limit", "1024M");         #设置内存,防止内存溢出
        \PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;  #单元格缓存为MemoryGZip

        header("Content-Type:application/vnd.ms-excel");
        header("Content-Disposition: attachment;filename=$file_name.$file_suffix");
        //根据业务，自己进行模板赋值。
        $this->assign('list',$list);
        return $this->fetch('export');
    }
}