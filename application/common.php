<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


/**
 * 通用API接口
 * @param int $status
 * @param string $message
 * @param array $data
 * @param int $httpCode
 * @return \think\response\Json
 * @author totti_zgl
 * @date 2018/5/10 9:28
 */
function api(int $status,string $message,array $data=[],int $httpCode=200)
{
    $data=[
        'status'=>$status,
        'message'=>$message,
        'data'=>$data
    ];
    return json($data,$httpCode);
}