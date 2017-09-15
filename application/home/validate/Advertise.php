<?php
namespace app\admin\validate;

use think\Validate;

class Advertise extends Validate{
    protected $rule=[
        'title'=>'require',
        'pic'=>'require',
    ];

    protected $message=[
        'title.require'=>'用户名不能为空！',
        'pic.require'=>'密码不能为空！',
    ];
}