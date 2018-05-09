<?php
namespace app\admin\controller;

use app\common\model\Admin;
use app\common\model\MailAdmin;
use app\common\model\Order;
use think\Controller;
use think\Session;

class Base extends Controller{

    public function _initialize()
    {
        $aid=Session::get('aid');
        if(empty($aid)){
            $this->redirect('login/index');
        }
        $info=Admin::get($aid);
        $num1=Order::count();
        $where['receiveid']=$aid;
        $where['status']=1;
        $num2=MailAdmin::where($where)->count();
        $this->assign('info',$info);
        $this->assign('num1',$num1);
        $this->assign('num2',$num2);
    }


    /*public function __construct(){
        parent::__construct();
        $aid=Session::get('aid');
        if(empty($aid)){
            $this->redirect('Login/index');
        }else{
            $info=Admin::get($aid);
            $num1=Order::count();
            $where['receiveid']=$aid;
            $where['status']=1;
            $num2=MailAdmin::where($where)->count();
            $this->assign('info',$info);
            $this->assign('num1',$num1);
            $this->assign('num2',$num2);
        }
    }*/
}