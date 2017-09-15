<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Intro extends Model{
    public static function tableName(){
        return "{{%intro}}";
    }
}