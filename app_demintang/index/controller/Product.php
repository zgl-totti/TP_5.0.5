<?php
namespace app\index\controller;


class Product extends Base{
    public function index(){
        $title='产品详情';
        $list=\app\admin\model\Section::where('show',1)->where('pid',0)->select();
        foreach($list as $k=>$v){
            $list[$k]['goods']=\app\admin\model\Product::where('sid',$v['id'])->paginate(4);
        }
        $this->assign('title',$title);
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function detail(){
        $id=input('param.id');
        $info=\app\admin\model\Product::get($id);
        $title='产品详情';
        $description=$info['goodsname'];
        $this->assign(compact('description'));
        $this->assign('title',$title);
        $this->assign('info',$info);
        return $this->fetch();
    }
}
