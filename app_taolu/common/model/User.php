<?php
namespace app\common\model;

use think\Db;
use think\Model;

class User extends Model{
    protected $table='user';

    public function vipinfos(){
        return $this->hasOne(VIP,'id','memberorder');
    }
}