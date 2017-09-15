<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Service extends Model{
    public static function tableName(){
        return "{{%service}}";
    }
}