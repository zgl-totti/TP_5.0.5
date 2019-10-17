<?php

namespace app\common\swoole;


class HttpServer
{
    const HOST = '0.0.0.0';

    const PORT = 8811;

    public $server = null;

    public function __construct()
    {
        $this->server = new swoole_http_server(self::HOST, self::PORT);

        $this->server->on([
            'enable_static_handler' => true,
            'document_root' => '/1_TP_5.05/public/static',
            'worker_num' => 4,
            'task_worker_num' => 4
        ]);

        $this->server->on('workerstart', [$this, 'onWorkerStart']);
        $this->server->on('request', [$this, 'onRequest']);
        $this->server->on('task', [$this, 'onTask']);
        $this->server->on('finish', [$this, 'onFinish']);
        $this->server->on('close', [$this, 'onClose']);

        $this->server->start();
    }

    /*
     * workerStart回调
     */
    public function onWorkerStart($server, $worker_id)
    {
        // *有坑，需要更改框架中的path和input(*)的代码，并且每次请求需要重启swoole_server
        // 定义应用目录
        define('APP_PATH', __DIR__ . '/../../../application/');
        // 加载框架引导文件
        //require __DIR__ . '/../../../thinkphp/base.php';
        require __DIR__ . '/../../../thinkphp/start.php';
    }

    /*
     * Request回调
     */
    public function onRequest($request, $response)
    {
        /*
        //每次请求加载一次框架，性能受影响，但是不需要重启swoole_server
        define('APP_PATH', __DIR__ . '/../../../application/');
        require_once __DIR__ . '/../../../thinkphp/base.php';
        */

        $_SERVER = $_GET = $_POST = [];
        if (isset($request->server)) {
            foreach ($request->server as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }

        if (isset($request->header)) {
            foreach ($request->header as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }

        if (isset($request->get)) {
            foreach ($request->get as $k => $v) {
                $_GET[$k] = $v;
            }
        }

        if (isset($request->post)) {
            foreach ($request->post as $k => $v) {
                $_POST[$k] = $v;
            }
        }

        $_POST['http_server']=$this->server;
        ob_start();
        //执行应用并响应
        try {
            think\Container::get('app', ['APP_PATH'])
                ->run()
                ->send();
        }catch (\Exception $e){
            // todo
        }

        $res = ob_get_contents();
        ob_end_clean();

        $response->end($res);
    }

    /*
    * 监听任务事件
    */
    public function onTask($server, $taskId, $workId, $data)
    {
        //分发task任务机制，不同的任务走不同的逻辑
        $task=new \app\common\swoole\Task();

        $method=$data['method'];
        $task->$method($data['data']);

        return true;

        //print_r($data);
        //sleep(10);
        //return 'on task finish';
    }

    /*
     * 监听任务完成事件
     */
    public function onFinish($server, $taskId, $data)
    {
        echo 'task_id:' . $taskId;
        echo 'finish_data_success:' . $data;
    }

    /*
     * 监听关闭事件
     */
    public function onClose($server, $fd)
    {
        echo 'client_id:' . $fd;
    }
}