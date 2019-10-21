<?php

namespace app\common\command;

# php Monitor.php

//后台不间断运行脚本，如果有输出则写入a.txt
# nohup php Monitor.php > a.txt &

/*
 * 监控服务
 */
class Monitor
{
    const PORT = 8811;

    public function port()
    {
        //监听端口是否运行
        $shell = 'netstat -anp 2>/dev/null | grep ' . self::PORT . ' | grep LISTEN | wc -l';
        $result = shell_exec($shell);
        if ($result != 1) {
            //发送报警 短信、邮件

            echo 'error_' . date('Y-m-d H:i:s');
        } else {
            echo 'success_' . date('Y-m-d H:i:s');
        }
    }
}

//swoole的定时器
//2秒监听一次服务
swoole_timer_tick(2000,function ($timer_id){
    (new Monitor())->port();
});