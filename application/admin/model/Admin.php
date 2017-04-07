<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Admin extends Model{
    public function getOne($where){
        $info=Db::table('new_admin')->where($where)->find();
        return $info;
    }

    public function addAdmin($data){
        $id=Db::table('new_admin')->insertGetId($data);
        return $id;
    }

    public function saveAdmin($where,$data){
        $row=Db::table('new_admin')->where($where)->update($data);
        return $row;
    }

    public function getList($where,$num){
        $list=Db::name('admin')->where($where)->paginate($num);
        return $list;
    }

    public function del($where){
        $row=Db::name('admin')->where($where)->delete();
        return $row;
    }
}