<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;

class Base extends Controller{
    public function __construct(){
        parent::__construct();
        if(!Session::get('aid')){
            $this->redirect('Login/index');
        }else{
            $aid=Session::get('aid');
            $where['id']=$aid;
            $condition['ma.receiveid']=$aid;
            $condition['ma.status']=1;
            $userinfo=model('Admin')->getOne($where);
            $mailinfo=model('Mail')->getAll($condition);
            $orderinfo=model('Order')->orderNum();
            $this->assign('userinfo',$userinfo);
            $this->assign('mailinfo',$mailinfo);
            $this->assign('orderinfo',$orderinfo);
        }
    }
}