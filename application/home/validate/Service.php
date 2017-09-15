<?php
namespace app\admin\validate;

use think\Validate;

class Service extends Validate{
    protected $rule=[
        'name'=>'require',
        'qq'=>'require',
    ];

    protected $message=[
        'name.require'=>'客服名字不能为空！',
        'qq.require'=>'客服QQ不能为空！',
    ];
}