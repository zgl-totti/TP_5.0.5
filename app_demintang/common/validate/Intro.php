<?php
namespace app\common\validate;

use think\Validate;

class Intro extends Validate{
    protected $rule=[
        'title'=>'require',
        'content'=>'require',
    ];

    protected $message=[
        'title.require'=>'用户名不能为空！',
        'content.require'=>'密码不能为空！',
    ];
}