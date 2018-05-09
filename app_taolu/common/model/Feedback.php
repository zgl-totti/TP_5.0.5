<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Feedback extends Model{
    public function getOne($where){
        $info=Db::name('userfeedback')->where($where)->find();
        return $info;
    }

    public function getAll($where,$order='id asc',$num=10){
        $list=Db::name('userfeedback')->where($where)->order($order)->paginate($num);
        return $list;
    }

    public function del($where){
        $row=Db::name('userfeedback')->where($where)->delete();
        return $row;
    }
}