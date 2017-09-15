<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class News extends Model{
    public static function tableName(){
        return "{{%news}}";
    }
}