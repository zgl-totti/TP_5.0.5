<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Section extends Model{
    public function getEquipment(){
        return $this->hasMany('Equipment','sid','id')->limit(3);
    }
}