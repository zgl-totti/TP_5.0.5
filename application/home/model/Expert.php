<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Expert extends Model{
    public static function tableName(){
        return "{{%expert}}";
    }

    public function departments(){
        return $this->hasOne('Department','id','department');
    }
}