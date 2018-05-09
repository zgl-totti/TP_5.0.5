<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Order extends Model{
    public function orderList($where){
        $list=Db::table('beauty_order_status os,beauty_order o,beauty_user u')
            ->field('o.price,o.orderno,o.create_time,u.username,os.adminstatus,os.statusname,o.id')
            ->where('os.id=o.status and o.mid=u.id ')
            ->where($where)
            ->order('o.id desc')
            ->paginate(5);
        return $list;
    }

    public function orderAll($where,$order='id asc'){
        $list=Db::name('Order')->where($where)->order($order)->paginate(10);
        return $list;
    }

    public function orderDetail($oid){
        $list=Db::name('order')->alias('o')
            ->join('beauty_address a','o.address=a.id')
            ->where(['o.id'=>$oid])
            ->field('a.username,a.area,a.address,o.create_time,a.mobile,a.ecode,o.orderno,o.id')
            ->select();
        foreach($list as $k=>$v){
            $list[$k]['goods']=Db::table('beauty_goods g','beauty_order_goods og')
                ->field('g.goodsname,og.buynum,og.saleprice,g.imagename,g.imageurl')
                ->where('og.gid=g.id')
                ->where(array('og.oid'=>$v['id']))
                ->select();
        }
        return $list;
    }

    public function one($where){
        $info=Db::name('order')->where($where)->find();
        return $info;
    }

    public function updateStatus($where,$data){
        $row=Db::name('order')->where($where)->update($data);
        return $row;
    }
}