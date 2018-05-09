<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/1
 * Time: 10:09
 */

namespace app\mobile\controller;


class Feature extends Base{
    public function index(){
        $list=\app\admin\model\Feature::where('status',1)->order('id','desc')->paginate(5);
        $title='特色疗法';
        $this->assign(compact('title'));
        $this->assign(compact('list'));
        return $this->fetch();
    }

    public function detail(){
        $id=input('param.id');
        $info=\app\admin\model\Feature::get($id);
        $title='特色疗法';
        $description=$info['title'];
        $this->assign(compact('description'));
        $this->assign(compact('title'));
        $this->assign(compact('info'));
        return $this->fetch();
    }
}