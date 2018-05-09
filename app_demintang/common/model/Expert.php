<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Expert extends Model{
    public function departments(){
        return $this->hasOne('Department','id','department');
    }
}