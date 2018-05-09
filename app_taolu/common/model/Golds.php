<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Golds extends Model{

    public function getAll($where){
        $list=Db::name('golds')->where($where)->select();
        return $list;
    }

    public function getList($where,$order,$num){
        $list=Db::table('beauty_golds g,beauty_category c,beauty_brands b')
            ->field('g.imagename,g.ml,g.id,g.goodsname,g.imageurl,g.saleprice,g.marketprice,c.cname,b.bname,g.description,g.num,g.salenum,g.addtime,g.show')
            ->where('g.cid=c.id and g.bid=b.id')
            ->where($where)
            ->order($order)
            ->paginate($num);
        return $list;
    }

    public function getGoldsDetail($where){
        $list=Db::table('beauty_golds g,beauty_category c,beauty_pic1 p')
            ->field('g.*,c.cname,p.picurl,p.picname')
            ->where('g.cid=c.id and g.id=p.gid')
            ->where($where)
            ->find();
        return $list;
    }

    public function updateGolds($where,$data){
        $row=Db::table('beauty_golds')->where($where)->update($data);
        return $row;
    }

    public function getPic($where){
        $list=Db::table('beauty_pic')->where($where)->select();
        return $list;
    }
}