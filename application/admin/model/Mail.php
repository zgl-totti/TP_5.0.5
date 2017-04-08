<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Mail extends Model{
    public function getList($where,$num){
        $list=Db::table('new_mail_admin')->alias('ma')
            ->join('new_admin a','ma.sendid=a.id')
            ->join('new_mail m','ma.mailid=m.id')
            ->field('ma.*,a.username,a.avatar,m.title,m.content,m.time')
            ->where($where)
            ->paginate($num);
        return $list;
    }
    public function getAll($where){
        $list=Db::table('new_mail_admin')->alias('ma')
            ->join('new_admin a','ma.sendid=a.id')
            ->join('new_mail m','ma.mailid=m.id')
            ->field('ma.*,a.username,a.avatar,m.title,m.content,m.time')
            ->where($where)
            ->select();
        return $list;
    }
}