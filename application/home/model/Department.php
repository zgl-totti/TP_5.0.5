<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Department extends Model{
    public static function tableName(){
        return "{{%department}}";
    }

    public function experts(){
        return $this->hasMany('Expert','department','id');
    }
}