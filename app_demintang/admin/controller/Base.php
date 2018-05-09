<?php
namespace app\admin\controller;

use app\common\model\Admin;
use think\Controller;
use think\Session;

class Base extends Controller{

    public function _initialize()
    {
        $aid=Session::get('aid');
        if(is_int($aid) && $aid>0){
            $info=Admin::get($aid);
            $this->assign(compact('info'));
        }else{
            $this->redirect('login/index');
        }
    }


    /*public function __construct(){
        parent::__construct();
        $id=Session::get('aid');
        if(is_int($id) && $id>0){
            $info=Admin::get($id);
            $this->assign('info',$info);
        }else{
            $this->redirect('Login/index');
        }
    }*/
}