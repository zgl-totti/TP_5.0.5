<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Comment extends Model{
    public function getAll($where,$order='id asc',$num=10){
        $list=Db::table(['beauty_comment'=>'c','beauty_order_status'=>'os','beauty_goods'=>'g','beauty_user'=>'u'])
            ->field('g.goodsname,c.oid,os.statusname,c.coaddtime,u.username,c.respid,c.mid,c.gid,c.cosid')
            ->where('c.cstatus=os.id and c.mid=u.id and c.gid=g.id')
            ->where($where)
            ->order($order)
            ->paginate($num);
        return $list;
    }

    public function getCommentAll($where){
        $list=Db::table('beauty_goods g,beauty_user u,beauty_comment c,beauty_comment_status cs')
            ->field('c.oid,c.gid,g.goodsname,g.imageurl,u.username,c.mid,c.content,cs.costatus,c.response,g.imageurl,g.imagename,c.coaddtime')
            ->where('c.gid=g.id and c.cosid=cs.id and c.mid=u.id')
            ->where($where)
            ->select();
        return $list;
    }

    public function updateComment($where,$data){
        $row=Db::name('comment')->where($where)->update($data);
        return $row;
    }

    public function getCosid($where){
        $list=Db::table(['beauty_comment'=>'c'])
            ->field('c.cosid')
            ->where($where)
            ->select();
        return $list;
    }
}