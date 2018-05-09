<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/27
 * Time: 15:40
 */

namespace app\mobile\controller;


use app\admin\model\Nav;
use app\admin\model\System;
use think\Controller;

class Base extends Controller {
    public function __construct(){
        parent::__construct();
        $info=System::where('status',1)->order('priority')->cache(true,rand(1800,3600))->find();
        if(empty($info)){
            $system='网站';
        }else{
            $system=$info['name'];
        }
        $nav=Nav::where('status',1)->order('priority')->limit(8)->cache(true,rand(1800,3600))->select();
        $icon=['home','asterisk','fire','th-large','magnet','globe','list','heart'];
        foreach ($nav as $k=>$val){
            $nav[$k]['icon']=$icon[$k];
        }
        $this->assign(compact('nav'));
        $this->assign(compact('system'));
        $this->assign('description','');
    }
}