<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Product extends Model{
    public function getSection(){
        return $this->hasOne('Section','id','sid');
    }
}