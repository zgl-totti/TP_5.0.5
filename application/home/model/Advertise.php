<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Advertise extends Model{
    public static function tableName(){
        return "{{%advertise}}";
    }
}