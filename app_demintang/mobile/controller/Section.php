<?php
namespace app\mobile\controller;


class Section extends Base{
    public function index(){
        $list=\app\admin\model\Section::where('show',1)->where('pid',0)->paginate(6);
        /*foreach($list as $k=>$v){
            $list[$k]['cate']=\app\admin\model\Section::where('pid',$v['id'])->paginate(4);
        }*/
        $title='科室介绍';
        $this->assign(compact('title'));
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function detail(){
        $id=input('param.id');
        $info=\app\admin\model\Section::get($id);
        $list=\app\admin\model\Section::where('pid',$id)->where('show',1)->paginate(6);
        $title='科室介绍';
        $description=$info['cname'].'详情';
        $this->assign(compact('description'));
        $this->assign(compact('title'));
        $this->assign(compact('list'));
        return $this->fetch();
    }
}
