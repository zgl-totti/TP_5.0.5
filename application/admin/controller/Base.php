<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;

class Base extends Controller{
    public function __construct(){
        parent::__construct();
        /*if(!Session::get('aid')){
            $this->redirect('Login/index');
        }*/
    }
}