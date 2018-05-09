<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Message extends Model{
    public function getAll($where,$order='id asc'){
        $list=Db::table('beauty_message_admin a')
            ->join('beauty_messagetext t','a.textId=t.id')
            ->join('beauty_admin ad','a.sendId=ad.id')
            ->field('a.id,a.status,t.title,t.content,t.time,ad.username')
            ->where($where)
            ->order($order)
            ->paginate(10);
        return $list;
    }

    public function getOne($where){
        $list=Db::table('beauty_message_admin a')
            ->join('beauty_messagetext t','a.textId=t.id')
            ->join('beauty_admin ad','a.sendId=ad.id')
            ->field('a.id,a.status,t.title,t.content,t.time,ad.username')
            ->where($where)
            ->find();
        return $list;
    }

    //message_admin表信息的数量
    public function num($where){
        $count=Db::table('beauty_message_admin')->where($where)->count();
        return $count;
    }

    //添加信息
    public function addMessage($data){
        $id=Db::name('messagetext')->insertGetId($data);
        return $id;
    }

    //查找message_admin表
    public function oneMessageAdmin($where){
        $info=Db::table('beauty_message_admin')->where($where)->find();
        return $info;
    }

    //添加message_admin表
    public function addMessageAdmin($data){
        $row=Db::table('beauty_message_admin')->insert($data);
        return $row;
    }

    //更新message_admin表
    public function updateMessageAdmin($where,$data){
        $row=Db::table('beauty_message_admin')->where($where)->update($data);
        return $row;
    }

    //删除message_admin表
    public function delMessageAdmin($where){
        $row=Db::table('beauty_message_admin')->where($where)->delete();
        return $row;
    }

    //添加message_user表
    public function addMessageUser($data){
        $row=Db::table('beauty_message_user')->insert($data);
        return $row;
    }

    /*//获得信息内容
    public function getOneContent($where){
        $info=Db::table('beauty_messagetext')->where($where)->find();
        return $info;
    }*/
}