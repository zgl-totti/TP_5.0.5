<?php


namespace app\index\controller;


use think\Controller;
use think\Db;

class Roma extends Controller
{
    public $connect;

    public function __construct()
    {
        $connect=Db::connect([
            // 数据库类型
            'type' => 'mysql',
            // 服务器地址
            'hostname' => 'localhost',
            // 数据库名
            'database' => 'fwpt_new_migrate',
            // 数据库用户名
            'username' => 'root',
            // 数据库密码
            'password' => 'root',
            // 数据库编码默认采用utf8
            'charset' => 'utf8',
            // 数据库表前缀
            'prefix' => 'hbb_',
            // 数据集返回类型
            'resultset_type'  => 'collection',
        ]);

        $this->connect=$connect;
    }

    public function index()
    {
        $list=$this->connect->name('copy')->where('status',1)->select();
        print_r($list);
    }
}