<?php
namespace app\common\model;

use think\Db;
use think\Model;

class AuthRule extends Model{

    //权限列表
    public function getRuleList(){
        $ruleList=Db::name('Auth_rule')->order('path asc')->select();
        foreach($ruleList as $k=>$v){
            $count=count(explode(',',$v['path']));
            $ruleList[$k]['level']=$count;
        }
        return $ruleList;
    }

    //添加权限
    public function addRule($data){
        $nid=Db::name('Auth_rule')->field('pid,title,name')->insertGetId($data);
        if($nid){
            if($data['pid']==0){
                $path=$nid;
            }else{
                $path=$this->where(['id'=>$data['pid']])->field('path')->find();
                $path.=','.$nid;
            }
            $save['path']=$path;
            $row=Db::name('Auth_rule')->where(['id'=>$nid])->update($save);
            return $row;
        }else{
            return $nid;
        }
    }

    //获取权限树
    public function getRuleTree(){
        $rule=Db::name('Auth_rule')->where(['pid'=>0])->select();
        if($rule){
            foreach($rule as $k=>$v){
                $child=Db::name('Auth_rule')->where(['pid'=>$v['id']])->select();
                foreach($child as $k1=>$v1){
                    $child1=Db::name('Auth_rule')->where(['pid'=>$v1['id']])->select();
                    $child[$k1]['child']=$child1;
                }
                $rule[$k]['child']=$child;
            }
            return $rule;
        }else{
            return false;
        }
    }

    //编辑权限;
    public function editRule($id,$data){
        $row=Db::name('Auth_rule')->where(['id'=>$id])->update($data);
        return $row;
    }

    //查询权限
    public function getRules($where){
        $rule=Db::name('Auth_rule')->where($where)->select();
        if($rule){
            return $rule;
        }else{
            return false;
        }
    }

    public function getRuleById($id){
        $rule=Db::name('Auth_rule')->where(['id'=>$id])->find();
        if($rule){
            return $rule;
        }else{
            return false;
        }
    }

    //删除权限
    public function delRule($where){
        $row=Db::name('AuthRule')->where($where)->delete();
        return $row;
    }
}