<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Order extends Model{
    protected $table='new_order';

    public function orderStatus(){
        return $this->hasOne('Status','id','status');
    }

    public function users(){
        return $this->hasOne('User','id','mid');
    }
}