<?php
namespace app\common\validate;

use think\Validate;

class Admin extends Validate{
    protected $rule=[
        'username'=>'require|length:5,12',
        'password'=>'require|length:5,12',
        'repassword'=>'require|confirm:password',
        'phone'=>'require|integer',
        'permission'=>'require',
        'newphone'=>'require|integer',
        'rephone'=>'require|confirm:newphone',
        'verify'=>'require|captcha'
    ];

    protected $message=[
        'username.require'=>'用户名不能为空！',
        'username.length'=>'用户名长度必须在5到12位之间！',
        'password.require'=>'密码不能为空！',
        'password.length'=>'用户名长度必须在5到12位之间！',
        'repassword.require'=>'确认密码不能为空！',
        'repassword.confirm'=>'两次密码不一致！',
        'phone.require'=>'电话不能为空！',
        'phone.integer'=>'电话必须为数字！',
        'permission.require'=>'管理员身份不能为空',
        'newphone.require'=>'电话不能为空！',
        'newphone.integer'=>'电话必须为数字！',
        'rephone.require'=>'电话不能为空！',
        'rephone.confirm'=>'两次电话不一致！',
        'verify.require'=>'验证码不能为空！',
        'verify.captcha'=>'验证码错误！'
    ];

    protected $scene = [
        'login' => ['username','password','verify'],
        'add' => ['username','password','repassword','phone','permission'],
        'edit' => ['username','phone','permission'],
        'change1' => ['phone','password','repassword'],
        'change2' => ['phone','newphone','rephone','password']
    ];
}