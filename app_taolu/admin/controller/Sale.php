<?php
namespace app\admin\controller;

use think\Cache;

class Sale extends Base{

    //活动列表
    public function index(){
        $where='';
        $stoptime=model('Sale')->getAll($where,'stoptime');
        foreach($stoptime as $v){
            if($v['stoptime']<time()){
                $status['astatus']=0;
                $condition['stoptime']=$v['stoptime'];
                model('Sale')->updateActivity($condition,$status);
            }
        }
        if(input('get.time1') && input('get.time2')){
            $time1=strtotime(input('get.time1'));
            $time2=strtotime(input('get.time2'));
            $where['a.addtime']=['between',[$time1,$time2]];
            $this->assign('time1',$time1);
            $this->assign('time2',$time2);
        }elseif(input('get.time2') && !input('get.time1')){
            $time2=strtotime(input('get.time2'));
            $where['a.addtime']=['lt',$time2];
            $this->assign('time1',$time2);
        }elseif(input('get.time1') && !input('get.time2')){
            $time1=strtotime(input('get.time1'));
            $where['a.addtime']=['gt',$time1];
            $this->assign('time1',$time1);
        }
        if($keywords=input('get.keywords')){
            $where['a.aname']=['like',"%$keywords%"];
            $this->assign('keywords',$keywords);
        }
        $list=model('Sale')->getActivity('a.addtime desc',10);
        $this->assign('list',$list);
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        $this->assign('page',$list->render());
        return $this->fetch('list');
    }

    //活动编辑
    public function editor(){
        if(request()->isAjax()){
            $where['id']=trim(input('post.bname'));
            $brandInfo=model('Brans')->getOne($where);
            if(strtotime(input('post.time1'))<strtotime(input('post.time2'))){
                $data['starttime']=strtotime(input('post.time1'));
                $data['stoptime']=strtotime(input('post.time2'));
                $data['aname']=input('post.aname');
                $data['rules']=input('post.rules');
                $data['astaus']=1;
                $data['bid']=$brandInfo['id'];
                $condition['id']=input('post.id');
                $row=model('Activity')->updateActivity($condition,$data);
                if($row){
                    $res['status']=1;
                    $res['info']='编辑成功！';
                    return $res;
                }else{
                    $res['status']=2;
                    $res['info']='编辑失败！';
                    return $res;
                }
            }else{
                $res['status']=3;
                $res['info']='活动时间错误！';
                return $res;
            }
        }else{
            $where['a.id']=input('param.id');
            $info=model('Sale')->getOneActivity($where);
            $brandsList=model('Brands')->getBrands();
            $this->assign('info',$info);
            $this->assign('bransList',$brandsList);
            return $this->fetch('editor');
        }
    }

    //清除品牌列表缓存
    public function clearCache(){
        if(request()->isAjax()){
            Cache::rm('brandsList');
            $res['status']=1;
            $res['info']='清除成功！';
            return $res;
        }
    }

    //添加活动
    public function add(){
        if (request()->isAjax()) {
            $bname = trim(input('post.bname'));
            $rules = trim(input('post.rules'));
            $aname = trim(input('post.aname'));
            if ($bname>0 && $rules && $aname) {
                if (strtotime(input('post.time1')) < strtotime(input('post.time2')) && strtotime(input('post.time2')) > time()) {
                    $condition['aname'] = $aname;
                    $condition['bid'] = $bname;
                    $info = model('Sale')->getOne($condition);
                    if (!$info) {
                        $data['rules'] = $rules;
                        $data['aname'] = $aname;
                        $data['bid'] = $bname;
                        $data['starttime'] = strtotime(input('post.time1'));
                        $data['stoptime'] = strtotime(input('post.time2'));
                        $data['addtime'] = time();
                        $row = model('Sale')->addActivity($data);
                        if ($row) {
                            $res['status'] = 1;
                            $res['info'] = '添加成功！';
                            return $res;
                        } else {
                            $res['status'] = 2;
                            $res['info'] = '添加失败！';
                            return $res;
                        }
                    } else {
                        $res['status'] = 3;
                        $res['info'] = '添加的活动已存在！';
                        return $res;
                    }
                } else {
                    $res['status'] = 4;
                    $res['info'] = '活动时间错误！';
                    return $res;
                }
            } else {
                $res['status'] = 5;
                $res['info'] = '必填项不能为空！';
                return $res;
            }
        } else {
            $brandsList = Cache::get('brandsList');
            if (!$brandsList) {
                $brandsList = model('Brands')->getBrands();
                Cache::set('brandsList', $brandsList);
            }
            $this->assign('brandsList', $brandsList);
            return $this->fetch('add');
        }
    }
}