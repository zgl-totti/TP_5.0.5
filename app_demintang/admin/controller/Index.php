<?php
namespace app\admin\controller;

use think\Session;

class Index extends Base{
    public function index(){
        return $this->fetch();
    }

    public function top(){
        return $this->fetch('public/top');
    }

    public function left(){
        return $this->fetch('public/left');
    }

    public function main(){
        return $this->fetch();
    }

    public function footer(){
        return $this->fetch('public/footer');
    }
}