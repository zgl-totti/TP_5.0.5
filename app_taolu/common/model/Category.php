<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Category extends Model{
    //分类列表
    public function cateList($where,$order='id asc'){
        $list=Db::name('Category')->where($where)->order($order)->select();
        return $list;
    }

    public function cate($where){
        $list=Db::name('Category')->where($where)->select();
        return $list;
    }

    public function one($where){
        $info=Db::name('Category')->where($where)->find();
        return $info?$info:false;
    }

    public function editCategory($where,$data){
        $row=Db::name('Category')->where($where)->update($data);
        return $row;
    }

    public function addCategory($data){
        $insertId=Db::name('Category')->insertGetId($data);
        return $insertId;
    }
}