<?php
namespace app\index\controller;


class Feature extends Base{
    public function index(){
        $title='特色疗法';
        $list=\app\admin\model\Feature::where('status',1)->order('id','desc')->paginate(4);
        $this->assign('title',$title);
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function detail(){
        $id=input('param.id');
        $info=\app\admin\model\Feature::get($id);
        $pre=\app\admin\model\Feature::where('status',1)->where('id','>',$id)->find();
        $next=\app\admin\model\Feature::where('status',1)->where('id','<',$id)->find();
        $title='特色疗法';
        $description=$info['title'];
        $this->assign(compact('description'));
        $this->assign('title',$title);
        $this->assign('info',$info);
        $this->assign('pre',$pre);
        $this->assign('next',$next);
        return $this->fetch();
    }
}
