<?php
namespace app\admin\validate;

use think\Validate;

class Admin extends Validate{
    protected $rules=[
        'username'=>'require|between:5,12',
        'password'=>'require|between:5,12'
    ];

    protected $message=[
        'username.require'=>'用户名不能为空！',
        'username.between'=>'用户名长度必须在5到12位之间！',
        'password.require'=>'密码不能为空！',
        'password.between'=>'用户名长度必须在5到12位之间！'
    ];

    protected $scene=[
        'login'=>['username','password'],
        'add'=>['username','password'],
        'edit'=>['username','password'],
    ];
}