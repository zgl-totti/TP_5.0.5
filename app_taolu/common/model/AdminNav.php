<?php
namespace app\common\model;

use com\Auth;
use think\Db;
use think\Model;

class AdminNav extends Model{
    public function getOne($where){
        $info=Db::name('admin_nav')->where($where)->find();
        return $info;
    }

    public function getAll($where){
        $list=Db::table('beauty_admin_nav')->where($where)->select();
        return $list;
    }

    public function addNav($data){
        $nid=Db::table('beauty_admin_nav')->field('pid,navname,navurl,priority')->insertGetId($data);
        if($nid){
            if($data['pid']==0){
                $path=$nid;
            }else{
                $where['id']=$data['pid'];
                $info=Db::table('beauty_admin_nav')->where($where)->find();
                $path=$info['path'].','.$nid;
            }
            $save['path']=$path;
            $condition['id']=$nid;
            $row=Db::table('beauty_admin_nav')->where($condition)->update($save);
            return $row;
        }else{
            return $nid;
        }
    }

    public function getNavList(){
        $navList=Db::name('admin_nav')->order('priority asc')->select();
        foreach($navList as $k=>$v){
            $count=count(explode(',',$v['path']));
            $navList[$k]['level']=$count;
        }
        return $navList;
    }

    // 显示有权限的菜单
    public function getNavTree(){
        $nav=Db::table('beauty_admin_nav')->where(['pid'=>0])->order('priority')->select();
        if($nav){
            $auth=new Auth();
            foreach($nav as $k1=>$v1){
                if ($auth->check($v1['navurl'],session('aid'))) {
                    $child=Db::table('beauty_admin_nav')->where(array('pid'=>$v1['id']))->order('priority')->select();
                    foreach($child as $k2=>$v2){
                        if (!$auth->check($v2['navurl'],session('aid'))) {
                            // 删除无权限的菜单
                            unset($child[$k2]);
                        }
                    }
                    $nav[$k1]['child']=$child;
                }else{
                    // 删除无权限的菜单
                    unset($nav[$k1]);
                }
            }
            return $nav;
        }else{
            return false;
        }
    }

    public function setPriority($where,$data){
        $row=Db::table('beauty_admin_nav')->where($where)->update($data);
        return $row;
    }

    public function del($where){
        $row=Db::table('beauty_admin_nav')->where($where)->delete();
        return $row;
    }

    public function updateNav($where,$data){
        $row=Db::table('beauty_admin_nav')->where($where)->update($data);
        return $row;
    }
}