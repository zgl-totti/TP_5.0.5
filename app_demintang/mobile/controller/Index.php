<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/27
 * Time: 15:16
 */

namespace app\mobile\controller;


use app\admin\model\Brand;
use app\admin\model\Equipment;
use app\admin\model\Feature;
use app\admin\model\Section;

class Index extends Base{
    public function index(){
        $brand=Brand::where('status',1)->order('id','desc')->cache(true,rand(1800,3600))->find();
        $section=Section::where('show',1)->where('pid',0)->with('getEquipment')->limit(3)->cache(true,rand(1800,3600))->select();
        $feature['list1']=Feature::where('status',1)->where('cate',1)->limit(4)->cache(true,rand(1800,3600))->select();
        $feature['list2']=Feature::where('status',1)->where('cate',2)->limit(4)->cache(true,rand(1800,3600))->select();
        $feature['list3']=Feature::where('status',1)->where('cate',3)->limit(4)->cache(true,rand(1800,3600))->select();
        $equipment=Equipment::with('getSection')->order('id','desc')->limit(5)->cache(true,rand(1800,3600))->select();
        $title='';
        $this->assign(compact('title'));
        $this->assign(compact('brand'));
        $this->assign(compact('section'));
        $this->assign(compact('feature'));
        $this->assign(compact('equipment'));
        return $this->fetch();
    }

    public function brand(){
        $info=Brand::where('status',1)->order('id','desc')->find();
        $title='品牌文化';
        $this->assign(compact('title'));
        $this->assign('info',$info);
        return $this->fetch();
    }

    public function equipment(){
        $list=Equipment::where('show',1)->with('getSection')->paginate(6);
        $title='患者心声';
        $this->assign(compact('title'));
        $this->assign('list',$list);
        return $this->fetch('equipment');
    }

    public function contact(){
        $title='联系我们';
        $this->assign(compact('title'));
        return $this->fetch();
    }
}