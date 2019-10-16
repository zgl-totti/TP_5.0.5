<?php

namespace app\common\service;


class HttpServer
{
    /*
     * 启动swoole_http_server
     */
    public function index()
    {
        $server=new swoole_http_server('0.0.0.0',8811);

        $server->set([
            'enable_static_handle'=>true,
            'document_root'=>'/1_TP_5.05/public/static'
        ]);

        $server->on('WorkerStart',function (swoole_server $server,$worker_id){
            // *有坑，需要更改框架中的path和input(*)的代码，并且每次请求需要重启swoole_server
            // 定义应用目录
            define('APP_PATH', __DIR__ . '/../../../application/');
            // 加载框架引导文件
            require __DIR__ . '/../../../thinkphp/base.php';
        });

        $server->on('request',function ($request,$response) use ($server){
            /*
            //每次请求加载一次框架，性能受影响，但是不需要重启swoole_server
            define('APP_PATH', __DIR__ . '/../../../application/');
            require_once __DIR__ . '/../../../thinkphp/base.php';
            */

            $_SERVER=$_GET=$_POST=[];
            if(isset($request->server)){
                foreach ($request->server as $k=>$v){
                    $_SERVER[strtoupper($k)]=$v;
                }
            }

            if(isset($request->header)){
                foreach ($request->header as $k=>$v){
                    $_SERVER[strtoupper($k)]=$v;
                }
            }

            if(isset($request->get)){
                foreach ($request->get as $k=>$v){
                    $_GET[$k]=$v;
                }
            }

            if(isset($request->post)){
                foreach ($request->post as $k=>$v){
                    $_POST[$k]=$v;
                }
            }

            ob_start();
            //执行应用并响应
            think\Container::get('app',['APP_PATH'])
                ->run()
                ->send();
            $res=ob_get_contents();
            ob_end_clean();

            $response->end($res);
            $server->close();
            //$response->cookie('singwa','hahaha',time()+1800);
            //$response->end('sss'.json_encode($request->get));
        });

        $server->start();
    }
}