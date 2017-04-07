<?php
namespace app\admin\controller;

use think\Session;

class Index extends Base{
    public function index(){
        /*$aid=Session::get('aid');
        $where['id']=$aid;
        $info=model('Admin')->getOne($where);
        $this->assign('info',$info);*/
        return $this->fetch();
    }

    public function search(){
        $keywords=trim(input('keywords'));
        $where['keywords']=$keywords;
        $this->assign('keywords',$keywords);
    }
}