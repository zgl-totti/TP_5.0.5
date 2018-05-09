<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Advertise extends Model{
    //广告列表
    public function advertiseList($where,$order='id asc'){
        $list=Db::name('Advertise')->where($where)->order($order)->paginate(10);
        return $list;
    }

    //获取广告
    public function getAdvertise($where){
        $info=Db::name('Advertise')->where($where)->find();
        return $info;
    }

    //添加广告
    public function addAdvertise($data){
        $insertId=Db::name('Advertise')->insertGetId($data);
        return $insertId;
    }

    //编辑广告
    public function editAdvertise($where,$data){
        $row=Db::name('Advertise')->where($where)->update($data);
        return $row;
    }

    //删除广告
    public function delAdvertise($where){
        $row=Db::name('Advertise')->where($where)->delete();
        return $row;
    }
}