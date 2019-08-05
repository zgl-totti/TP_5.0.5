<?php

namespace app\common\service;

use think\Db;
use think\Log;
use think\Cache;
use Flc\Dysms\Client;
use Flc\Dysms\Request\SendSms;

class Connect
{
    private static $_instance = null;

    private function __construct(){}

    //静态方法，单例模式统一入口
    public static function getInstance()
    {
        if(is_null(self::$_instance)){
            self::$_instance= new self();
        }

        return self::$_instance;
    }

    public function index()
    {
        $connect=Db::connect([
            // 数据库类型
            'type' => 'mysql',
            // 服务器地址
            'hostname' => '125.46.13.246',
            // 数据库名
            'database' => 'fwpt',
            // 数据库用户名
            'username' => 'root',
            // 数据库密码
            'password' => 'p40xdP23H0NX',
            // 数据库编码默认采用utf8
            'charset' => 'utf8',
            // 数据库表前缀
            'prefix' => 'hbb_',
            // 数据集返回类型
            'resultset_type'  => 'collection',
        ]);

        return $connect;
    }
}