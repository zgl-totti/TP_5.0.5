<?php
namespace app\index\controller;


class Section extends Base{
    public function index(){
        $title='科室介绍';
        $list=\app\admin\model\Section::where('show',1)->where('pid',0)->select();
        foreach($list as $k=>$v){
            $list[$k]['cate']=\app\admin\model\Section::where('pid',$v['id'])->paginate(4);
        }
        $this->assign('title',$title);
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function detail(){
        $id=input('param.id');
        $info=\app\admin\model\Section::get($id);
        $title='科室介绍';
        $description=$info['cname'];
        $this->assign(compact('description'));
        $this->assign('title',$title);
        $this->assign('info',$info);
        return $this->fetch();
    }
}
