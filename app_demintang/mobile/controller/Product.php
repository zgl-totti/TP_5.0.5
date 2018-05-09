<?php
namespace app\mobile\controller;


class Product extends Base{
    public function index(){
        $list1=\app\admin\model\Product::where('sid',1)->where('status',1)->paginate(6);
        $list2=\app\admin\model\Product::where('sid',5)->where('status',1)->paginate(6);
        $list3=\app\admin\model\Product::where('sid',11)->where('status',1)->paginate(6);
        $title='产品列表';
        $this->assign(compact('title'));
        $this->assign(compact('list1'));
        $this->assign(compact('list2'));
        $this->assign(compact('list3'));
        return $this->fetch();
    }

    public function detail(){
        $id=input('param.id');
        $info=\app\admin\model\Product::get($id);
        $title='产品列表';
        $description=$info['goodsname'];
        $this->assign(compact('description'));
        $this->assign(compact('title'));
        $this->assign('info',$info);
        return $this->fetch();
    }
}
