<?php

namespace app\common\service;

use think\App;
use think\Request;
use think\Config;

/*
 * 阿里云日志php-sdk
 */
class Aliyun
{
    protected $config = [
        'endpoint' => 'cn-shanghai.log.aliyuncs.com', // 选择与上面步骤创建项目所属地域匹配的Endpoint
        'accessKeyId' => '******',                    // 使用你的阿里云访问密钥AccessKeyId
        'accessKey' => '**********',                  // 使用你的阿里云访问密钥AccessKeySecret
        'project' => 'ljlog-test',                    // 输入阿里云日志服务创建的项目名称
        'logstore' => 'ljlog-test'                    // 输入阿里云日志服务创建的日志库名称
    ];

    // 实例化并传入参数
    public function __construct($config = [])
    {
        if (is_array($config)) {
            $this->config = array_merge($this->config, $config);
        }
    }

    /**
     * 日志写入接口
     * @access public
     * @param array $log 日志信息
     * @return bool
     */
    public function save(array $log = [])
    {
        $insert = [];
        $timestamp = time();
        $datetime = isset($this->config['time_format'])?date($this->config['time_format']):date("Y-m-d H:i:s");

        if (App::$debug) {
            if (isset($_SERVER['HTTP_HOST'])) {
                $insert['current_url'] =  $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            } else {
                $insert['current_url'] = "cmd:" . implode(' ', $_SERVER['argv']);
            }

            $runtime    = round(microtime(true) - THINK_START_TIME, 10);
            $qps        = $runtime > 0 ? number_format(1 / $runtime, 2). 'req/s]' : '∞'. 'req/s]';
            $runtime_str=  number_format($runtime, 6) . 's';
            $memory_use = number_format((memory_get_usage() - THINK_START_MEM) / 1024, 2);
            $file_load  = count(get_included_files());
            $server     = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '0.0.0.0';
            $remote     = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
            $method     = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'CLI';
            $insert     = [
                'timestamp'=>$timestamp,
                'datetime'=>$datetime,
                'method'=>$method,
                'runtime'=>$runtime_str,
                'qps'=>$qps,
                'memory_use'=>$memory_use . 'kb',
                'file_load'=>$file_load,
                'server'=>$server,
                'remote'=>$remote
            ];
        }

        $content=[];
        foreach ($log as $type => $val) {
            if (isset($content[$type])) {
                $n = count($val);
            } else {
                $n=0;
            }
            foreach ($val as $msg) {
                if (!is_string($msg)) {
                    $msg = var_export($msg, true);
                }
                $insert[$type.'_'.$n]=$msg;
                $n++;
            }
            // $content .= $type.$msg;
            // if (in_array($type, $this->config['apart_level'])) {
            //     $this->log(['log'=>$content]);
            // }
        }
        dump($insert);
        // $insert['log']=json_encode($content, 256);

        //\array_push($insert, $content);
        $this->log($insert);
        return true;
    }

    protected function log($insert=[])
    {
        vendor('aliyunlog.Log_Autoload');
        $client = new \Aliyun_Log_Client($this->config['endpoint'], $this->config['accessKeyId'], $this->config['accessKey']);
        #列出当前project下的所有日志库名称
        // $req1 = new \Aliyun_Log_Models_ListLogstoresRequest($project);
        // $res1 = $client->listLogstores($req1);

        $topic = "";
        $source = "";
        $logitems = array();

        $contents = $insert;
        dump($contents);
        $logItem = new \Aliyun_Log_Models_LogItem();
        $logItem->setTime(time());
        $logItem->setContents($contents);
        array_push($logitems, $logItem);

        $req2 = new \Aliyun_Log_Models_PutLogsRequest($this->config['project'], $this->config['logstore'], $topic, $source, $logitems);
        $res2 = $client->putLogs($req2);
    }
}