<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/1
 * Time: 9:41
 */

namespace app\mobile\controller;


use app\admin\model\News;

class Newes extends Base{
    public function index(){
        $list=News::where('status',1)->order('id','desc')->paginate(5);
        $title='新闻资讯';
        $this->assign(compact('title'));
        $this->assign(compact('list'));
        return $this->fetch();
    }

    public function detail(){
        $id=input('param.id');
        $info=News::get($id);
        $title='新闻资讯';
        $description=$info['title'];
        $this->assign(compact('description'));
        $this->assign(compact('title'));
        $this->assign(compact('info'));
        return $this->fetch();
    }
}