<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Admin extends Model
{
    /**
     * 查询的结果集类型
     */
    protected $resultSetType = 'collection';

    /**
     * 获取器：获取数据的字段值后自动进行处理
     */
    public function getStatusAttr($value)
    {
        $status = [-1=>'删除',0=>'禁用',1=>'正常',2=>'待审核'];
        return $status[$value];
    }

    /**
     * 修改器：在数据赋值的时候自动进行转换处理
     */
    public function setNameAttr($value)
    {
        return strtolower($value);
    }

    /**
     * 自动写入创建和更新的时间戳字段
     */
    protected $autoWriteTimestamp = true;
    //protected $autoWriteTimestamp = 'datetime';


    /**
     * 追加关联模型的属性
     */
    //$user = User::find(1);
    //$user->appendRelationAttr('profile',['email','nickname'])->toArray();


    /**
     * 在模型类的init方法里面统一注册模型事件
     */
    protected static function init()
    {
        self::event('before_insert', function ($user) {
            if ($user->status != 1) {
                return false;
            }
        });
    }

}