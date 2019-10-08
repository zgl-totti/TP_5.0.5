<?php
/**
 * Created by PhpStorm.
 * User: zgl
 * Date: 2019/10/8
 * Time: 21:22
 */

namespace app\common\service;


class SwooleMysql
{
    public $db;

    public $config;

    public function __construct()
    {
        $this->db= new swoole_mysql();

        $this->config=[
            'host' => '192.168.56.102',
            'port' => 3306,
            'user' => 'test',
            'password' => 'test',
            'database' => 'test',
            'charset' => 'utf8', //指定字符集
            'timeout' => 2,  // 可选：连接超时时间（非查询超时时间），默认为SW_MYSQL_CONNECT_TIMEOUT（1.0）
        ];
    }

    public function execute()
    {
        $this->db->connect($this->config, function ($db, $r) {
            if ($r === false) {
                var_dump($db->connect_errno, $db->connect_error);
                die;
            }

            $sql = 'show tables';
            $db->query($sql, function(swoole_mysql $db, $r) {
                if ($r === false)
                {
                    var_dump($db->error, $db->errno);
                }
                elseif ($r === true )
                {
                    var_dump($db->affected_rows, $db->insert_id);
                }
                var_dump($r);
                $db->close();
            });
        });
    }
}