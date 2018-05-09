<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Foote extends Model{
    public function getOne($where){
        $info=Db::name('foote')->where($where)->find();
        return $info;
    }

    public function getAll($where=''){
        $list=Db::name('foote')->where($where)->select();
        return $list;
    }

    public function getList($where,$num){
        $list=Db::table('beauty_foote')->where($where)->paginate($num);
        return $list;
    }

    public function addFoote($data){
        $id=Db::name('foote')->insertGetId($data);
        return $id;
    }

    public function updateFoote($where,$data){
        $row=Db::name('foote')->where($where)->update($data);
        return $row;
    }

    public function getTree($where){

    }
}