<?php
/*namespace Admin\Model;
use Think\Model;
class AuthGroupModel extends Model{*/
namespace app\common\model;


use think\Db;
use think\Model;

class AuthGroup extends Model{

    protected $_validate=array(
        //array('验证字段','验证规则','错误提示',['验证条件','附加规则','验证时间']);
        //验证规则：require 字段值必须、email 邮箱、url URL地址、currency 货币、number 数字、double浮点、integer整数、zip邮政编码、english英文
        //验证条件：0代表字段存在时必须验证、1代表字段必须验证、2代表字段存在而且不为空时验证
        //附加规则:默认为regex,附加规则的值决定了验证规则的值
        //验证时间:1代表添加时验证，2代表更新时验证，3代表任何情况下都验证
        array('title','require','管理组名称不能为空',0,'regex',1)
    );

    //所有管理组对应的管理员
    public function getGroupList(){
        $groupList=Db::name('AuthGroup')->select();
        foreach($groupList as $k=>$v){
            $adminInfo=Db::name('AuthGroupAccess')->alias('g')
                ->join('beauty_admin a','g.uid=a.id')
                ->field('a.username')
                ->where(['g.group_id'=>$v['id']])
                ->select();
            $str='';
            foreach($adminInfo as $a){
                $str.=$a['username'].',';
            }
            $groupList[$k]['member']=substr($str,0,-1);
        }
        return $groupList;
    }

    public function getGroup($where=''){
        $list=Db::name('AuthGroup')->where($where)->select();
        return $list;
    }

    //查询管理组
    public function selectGroup($where=''){
        $groupList=Db::name('AuthGroup')->where($where)->find();
        return $groupList;
    }

    //添加管理组
    public function addGroup($data){
        $id=Db::name('AuthGroup')->field('title')->insertGetId($data);
        return $id;
    }

    //删除管理组
    public function delGroup($where){
        $row=Db::name('AuthGroup')->where($where)->delete();
        return $row;
    }

    public function setPriority($where,$data){
        $row=Db::name('AuthGroup')->where($where)->update($data);
        return $row;
    }

    //编辑管理组
    public function editGroup($where,$data){
        $row=Db::name('AuthGroup')->where($where)->update($data);
        return $row;
    }

    //查询管理组对应的管理员
    public function selectGroupAccess($where,$field='*'){
        $groupAccess=Db::name('AuthGroupAccess')->field($field)->where($where)->select();
        return $groupAccess;
    }

    //删除查询管理组对应的管理员
    public function delAccess($where){
        $row=Db::name('AuthGroupAccess')->where($where)->delete();
        return $row;
    }

    public function addAccess($data){
        $row=Db::name('AuthGroupAccess')->insert($data);
        return $row;
    }

    public function selectAccess($where){
        $access=Db::name('AuthGroupAccess')->where($where)->find();
        return $access;
    }
}