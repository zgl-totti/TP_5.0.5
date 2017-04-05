<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Admin extends Model{
    public function getOne($where){
        $info=Db::table('taolu_admin')->where($where)->find();
        return $info;
    }

    public function add($data){
        $id=Db::table('taolu_admin')->insertGetId($data);
        return $id;
    }

    public function save($where,$data){
        $row=Db::table('taolu_admin')->where($where)->update($data);
        return $row;
    }
}