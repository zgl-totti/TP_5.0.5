<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Brands extends Model{
    public function getAll($where='',$num){
        $list=Db::name('brands')->cache(true,86400)->where($where)->paginate($num);
        return $list;
    }

    public function getBrands(){
        $list=Db::name('brands')->select();
        return $list;
    }

    public function getOne($where){
        $info=Db::name('brands')->where($where)->find();
        return $info;
    }

    public function addBrands($data){
        $id=Db::name('brands')->insertGetId($data);
        return $id;
    }

    public function updateBrands($where,$data){
        $row=Db::name('brands')->where($where)->update($data);
        return $row;
    }
}