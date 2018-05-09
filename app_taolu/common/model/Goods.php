<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Goods extends Model{
    public function goodsAll($where){
        $list=Db::name('Goods')->alias('g')
            ->join('beauty_category c','g.cid=c.id')
            ->join('beauty_brands b','b.id=g.bid')
            ->field('g.imagename,g.id,g.goodsname,g.imageurl,g.saleprice,g.marketprice,g.discount,c.cname,b.bname,g.score,g.description,g.num,g.salenum,g.addtime,g.show')
            ->order('g.addtime','desc')
            ->where($where)
            ->paginate(10);
        return $list;
    }

    public function one($where){
        $info=Db::name('goods')->where($where)->find();
        return $info;
    }

    public function addGoods($data){
        $insertId=Db::name('goods')->insertGetId($data);
        return $insertId;
    }

    public function editGoods($where,$data){
        $row=Db::name('goods')->where($where)->update($data);
        return $row;
    }

    public function getAll($order='id',$limit){
        $list=Db::table('beauty_goods')->order($order)->limit($limit)->select();
        return $list;
    }

    public function getGoodsTop($num){
        $list=Db::table('beauty_goods')->field('goodsname,salenum')->limit("0,$num")->order('salenum desc')->select();
        return $list;
    }
}