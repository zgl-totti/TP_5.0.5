<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Admin extends Model{
    public function getAll($where,$field='*'){
        $list=Db::name('admin')->field($field)->where($where)->select();
        return $list;
    }

    public function getList($where){
        $list=Db::name('admin')->where($where)->select();
        foreach($list as $k=>$v){
            $info=Db::table('beauty_auth_group_access')->alias('ga')
                ->join('beauty_auth_group g','ga.group_id=g.id')
                ->field('g.title')
                ->where('ga.uid',$v['id'])
                ->select();
            $str='';
            foreach($info as $a){
                $str.=$a['title'].',';
            }
            $list[$k]['group']=substr($str,0,-1);
        }
        return $list;
    }

    public function saveAdmin($where,$data){
        $row=Db::table('beauty_admin')->where($where)->update($data);
        return $row;
    }

    public function addAdmin($data){
        $row=Db::table('beauty_admin')->insertGetId($data);
        return $row;
    }

    public function getOne($where){
        $info=Db::table('beauty_admin')->where($where)->find();
        return $info;
    }

    public function login($data){
        $info=Db::name('admin')->where($data)->find();
        if($info){
            return $info;
        }else{
            return false;
        }
    }

    public function admins($where,$order='id'){
        $list=Db::name('admin')->where($where)->order($order)->select();
        if($list){
            return $list;
        }else{
            return false;
        }
    }
}