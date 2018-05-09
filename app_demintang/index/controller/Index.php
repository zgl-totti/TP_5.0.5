<?php
namespace app\index\controller;

use app\admin\model\Department;
use app\admin\model\Equipment;
use app\admin\model\Feature;
use app\admin\model\Nav;
use app\admin\model\Brand;
use app\admin\model\News;
use app\admin\model\Section;
use think\Debug;

class Index extends Base{
    public function index(){
        $title='';
        $section=Section::where('show',1)->where('pid',0)->with('getEquipment')->limit(3)->cache(true,rand(1800,3600))->select();
        $news=News::where('status',1)->limit(4)->cache(true,rand(1800,3600))->select();
        $brand=Brand::where('status',1)->order('id','desc')->cache(true,rand(1800,3600))->find();
        $feature['list1']=Feature::where('status',1)->where('cate',1)->limit(10)->cache(true,rand(1800,3600))->select();
        $feature['list2']=Feature::where('status',1)->where('cate',2)->limit(10)->cache(true,rand(1800,3600))->select();
        $feature['list3']=Feature::where('status',1)->where('cate',3)->limit(10)->cache(true,rand(1800,3600))->select();
        $equipment=Equipment::with('getSection')->order('id','desc')->limit(5)->cache(true,rand(1800,3600))->select();
        $this->assign('title',$title);
        $this->assign('section',$section);
        $this->assign('news',$news);
        $this->assign('brand',$brand);
        $this->assign('feature',$feature);
        $this->assign('equipment',$equipment);
        return $this->fetch();
    }

    public function brand(){
        $title='品牌文化';
        $info=Brand::where('status',1)->order('id','desc')->find();
        $this->assign('title',$title);
        $this->assign('info',$info);
        return $this->fetch('detail');
    }

    public function product(){
        $title='产品详情';
        $this->assign('title',$title);
        return $this->fetch('list_1');
    }

    public function equipment(){
        $title='患者心声';
        $list=Section::where('pid',0)->with('getEquipment')->select();
        $this->assign('title',$title);
        $this->assign('list',$list);
        return $this->fetch('equipment');
    }

    public function equipmentDetail(){
    	$title='患者心声';
        $id=input('param.id');
        $info=Equipment::get($id);
        $description='患者心声详情';
        $this->assign(compact('description'));
        $this->assign('title',$title);
        $this->assign('info',$info);
        return $this->fetch();
    }

    public function contact(){
        $title='关于我们';
        $this->assign('title',$title);
        return $this->fetch('about');
    }

    public function map(){
    	return $this->fetch();
    }
}
