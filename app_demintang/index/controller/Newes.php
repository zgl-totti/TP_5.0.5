<?php
namespace app\index\controller;

use app\admin\model\Department;
use app\admin\model\Nav;
use app\admin\model\News;

class Newes extends Base{
    public function index(){
        $title='新闻资讯';
        $list=News::where('status',1)->order('id','desc')->paginate(4);
        $this->assign('title',$title);
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function detail(){
        $id=input('param.id');
        $info=News::get($id);
        $pre=News::where('status',1)->where('id','>',$id)->find();
        $next=News::where('status',1)->where('id','<',$id)->find();
        $title='新闻资讯';
        $description=$info['title'];
        $this->assign('title',$title);
        $this->assign('info',$info);
        $this->assign('pre',$pre);
        $this->assign('next',$next);
        $this->assign(compact('description'));
        return $this->fetch();
    }
}
