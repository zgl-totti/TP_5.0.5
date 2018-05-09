<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Equipment extends Model{
    public function getSection(){
        return $this->hasOne('Section','id','sid');
    }
}