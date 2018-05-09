<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Sale extends Model{
    public function getAll($where,$field='*'){
        $list=Db::name('activity')->field($field)->where($where)->select();
        return $list;
    }

    public function getOne($where,$field='*'){
        $info=Db::name('activity')->field($field)->where($where)->find();
        return $info;
    }

    public function getOneActivity($where){
        $info=Db::table('beauty_activity a')
            ->join('beauty_brands b','a.bid=b.id')
            ->field('a.*,b.bname')
            ->where($where)
            ->find();
        return $info;
    }

    public function updateActivity($where,$data){
        $row=Db::name('activity')->where($where)->update($data);
        return $row;
    }

    public function getActivity($order,$pagesize){
        $list=Db::table('beauty_activity a')
            ->join('beauty_brands b','b.id=a.bid')
            ->field('a.*,b.bname')
            ->order($order)
            ->paginate($pagesize);
        return $list;
    }

    public function addActivity($data){
        $row=Db::name('activity')->insert($data);
        return $row;
    }

}