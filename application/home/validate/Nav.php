<?php
namespace app\admin\validate;

use think\Validate;

class Nav extends Validate{
    protected $rule=[
        'navname'=>'require',
        'navurl'=>'require',
        'priority'=>'require',
    ];

    protected $message=[
        'navname.require'=>'导航名称不能为空！',
        'navurl.require'=>'导航地址不能为空！',
        'priority.require'=>'导航优先度不能为空！',
    ];
}