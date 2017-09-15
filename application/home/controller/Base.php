<?php
namespace app\admin\controller;

use app\admin\model\Admin;
use Symfony\Component\DomCrawler\Tests\FormTest;
use think\Controller;
use think\Session;

class Base extends Controller{
    public function __construct(){
        parent::__construct();
        $id=Session::get('aid');
        if(is_int($id) && $id>0){
            $info=Admin::get($id);
            $this->assign('info',$info);
        }else{
            $this->redirect('Login/index');
        }
    }
}