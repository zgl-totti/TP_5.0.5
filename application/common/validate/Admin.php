<?php
namespace app\common\validate;

use think\Validate;

class Admin extends Validate{
    protected $rule=[
        'username'=>'require|min:5|max:12',
        'password'=>'require|min:5|max:12',
        'captcha'=>'require|captcha'
    ];

    protected $message=[
        'username.require'=>'用户名不能为空！',
        'username.min'=>'用户名长度必须在5到12位之间！',
        'username.max'=>'用户名长度必须在5到12位之间！',
        'password.require'=>'密码不能为空！',
        'password.min'=>'密码长度必须在5到12位之间！',
        'password.max'=>'密码长度必须在5到12位之间！',
        'captcha.require'=>'验证码不能为空！',
        'captcha.captcha'=>'验证码错误'
    ];

    protected $scene=[
        'login'=>['username','password','captcha'],
        'add'=>['username','password'],
        'edit'=>['username','password'],
    ];
}