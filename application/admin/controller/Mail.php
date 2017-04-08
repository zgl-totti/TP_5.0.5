<?php
namespace app\admin\controller;

use think\Session;

class Mail extends Base{
    public function index(){
        $aid=Session::get('aid');
        $where['ma.receiveid']=$aid;
        $list=model('Mail')->getList($where,10);
        $this->assign('list',$list);
        $this->assign('page',$list->render());
        return $this->fetch();
    }
}