<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Department extends Model{
    public function experts(){
        return $this->hasMany('Expert','department','id');
    }
}