<?php

namespace app\common\service;

/*
 * swoole_websocket 是基于 swoole_http_server
 */
class WebSocket
{
    const HOST = '0.0.0.0';

    const PORT = 8811;

    public $server = null;

    public function __construct()
    {
        $this->server = new swoole_websocket_server(self::HOST, self::PORT);

        $this->server->on([
            'enable_static_handler' => true,
            'document_root' => '/1_TP_5.05/public/static',
            'worker_num' => 4,
            'task_worker_num' => 4
        ]);

        $this->server->on('open', [$this, 'onOpen']);
        $this->server->on('message', [$this, 'onMessage']);
        $this->server->on('workerstart', [$this, 'onWorkerStart']);
        $this->server->on('request', [$this, 'onRequest']);
        $this->server->on('task', [$this, 'onTask']);
        $this->server->on('finish', [$this, 'onFinish']);
        $this->server->on('close', [$this, 'onClose']);

        $this->server->start();
    }

    /*
     * 监听连接事件
     */
    public function onOpen($server, $request)
    {
        //swoole开启时把fd放入redis有序集合，关闭时踢出集合
        Redis::sAdd('live_redis_key',$request->fd);
    }

    /*
     * 监听消息事件
     */
    public function onMessage($server, $frame)
    {
        echo 'ser_push_message:' . $frame->data;

        $data = [
            'task' => 1,
            'fd' => $frame->fd
        ];

        //任务异步执行
        $server->task($data);

        //隔2秒后执行
        swoole_timer_after(2000, function () use ($server, $frame) {
            echo '5s_after';

            $server->push($frame->fd, 'server_timer_after:' . date('Y-m-d H:i:s'));
        });

        $server->push($frame->fd, 'server_push:' . date('Y-m-d H:i:s'));
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

        $_SERVER = $_GET = $_POST = $_FILES = [];
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

        if (isset($request->files)) {
            foreach ($request->files as $k => $v) {
                $_FILES[$k] = $v;
            }
        }

        $_POST['http_server'] = $this->server;
        ob_start();
        //执行应用并响应
        try {
            think\Container::get('app', ['APP_PATH'])
                ->run()
                ->send();
        } catch (\Exception $e) {
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
        $task = new \app\common\swoole\Task();

        $method = $data['method'];
        $task->$method($server,$data['data']);

        return true;

        /*print_r($data);
        sleep(10);
        return 'on task finish';*/
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
        //关闭时把fd删除有序集合
        Redis::sRem('live_redis_key',$fd);

        echo 'client_id:' . $fd;
    }
}