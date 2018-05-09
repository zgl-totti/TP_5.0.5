<?php
namespace app\admin\controller;

use think\Session;

class Index extends Base{
    public function index(){
        return $this->fetch();
    }
    public function main(){
        $aid=session('aid');
        if($aid){
            $where['id']=$aid;
            $userInfo=model('Admin')->getOne($where);
            $goodsList1=model('Goods')->getAll('salenum desc',5);
            $goodsList2=model('Goods')->getAll('num',5);
            $this->assign('a',400);
            $this->assign('userInfo',$userInfo);
            $this->assign('goodsList1',$goodsList1);
            $this->assign('goodsList2',$goodsList2);
            return $this->fetch('main');
        }
    }

    public function footer(){
        return $this->fetch('public/footer');
    }

    public function top(){
        $aid = session('aid');
        $where['id']=$aid;
        $info=model('Admin')->getOne($where);
        $condition['receiveId']=$aid;
        $condition['status']=1;
        $mail=model('Message')->num($where);
        $this->assign('username', $info['username']);
        $this->assign('mail', $mail);
        return $this->fetch('public/top');
    }

    public function left(){
        //获取左侧栏菜单
        $navList=model('AdminNav')->getNavTree();
        $this->assign('navList',$navList);
        return $this->fetch('public/left');
    }

    public function getGoodsTop($num=10){
        if(request()->isAjax()){
            $list=model('Goods')->getGoodsTop($num);
            $goodsList=array();
            //饼状图;
            foreach($list as $k=>$v){
                $goodsList['x'][$k]=mb_substr($v['goodsname'],0,12,'utf-8');
                $goodsList['y'][$k]['value']=$v['salenum'];
                $goodsList['y'][$k]['name']=mb_substr($v['goodsname'],0,12,'utf-8');
            }
            /*//柱状图;
            foreach($list as $k=>$v){
                $goodsList['x'][$k]=mb_substr($v['goodsname'],0,10,'utf-8');
                $goodsList['y'][$k]=$v['salenum'];
            }*/
        }
        $res['status']=1;
        $res['info']=$goodsList;
        return $res;
    }
}
