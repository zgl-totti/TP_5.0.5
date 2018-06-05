<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

Route::resource('api/test','api/test');
Route::resource('api/:ver/order','api/:ver.order');
Route::resource('api/:ver/goods','api/:ver.goods');
Route::resource('api/:ver/index','api/:ver.index');
Route::resource('api/:ver/login','api/:ver.login');
Route::resource('api/:ver/authBase','api/:ver.authBase');
Route::resource('api/:ver/identify','api/:ver.identify');
Route::resource('api/:ver/upvote','api/:ver.upvote');


/*return [
    //配置多域名指定模块
    '__domain__' => [
        'test1' => 'index',
        'test2' => 'admin'
    ],

    // 定义资源路由
    '__rest__'=>[
        'api/test'=>'api/test',
        'api/:ver/order'=>'api/:ver.order',
        'api/:ver/goods'=>'api/:ver.goods',
        'api/:ver/index'=>'api/:ver.index',
    ],

    '__pattern__' => [
        'name' => '\w+',
    ],

    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];*/

