<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Order extends Model{
    public function getAll($where){
        $list=Db::table('new_order')
            ->where($where)
            ->select();
        return $list;
    }

    public function orderNum(){
        $count['num1']=Db::table('new_order')->where('status',1)->count();
        $count['num2']=Db::table('new_order')->where('status',2)->count();
        $count['num3']=Db::table('new_order')->where('status',3)->count();
        $count['num4']=Db::table('new_order')->where('status',4)->count();
        return $count;
    }

    public function orderList($where,$num){
        $list=Db::table('new_order_status os,new_order o,new_user u')
            ->field('o.price,o.orderno,o.create_time,u.username,os.adminstatus,os.statusname,o.id')
            ->where('os.id=o.status and o.mid=u.id ')
            ->where($where)
            ->order('o.id desc')
            ->paginate($num);
        return $list;
    }
}