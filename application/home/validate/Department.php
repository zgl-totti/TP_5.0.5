<?php
namespace app\admin\validate;

use think\Validate;

class Department extends Validate{
    protected $rule=[
        'name'=>'require',
        'intro'=>'require',
    ];

    protected $message=[
        'name.require'=>'科室名称不能为空！',
        'intro.require'=>'简介不能为空！',
    ];
}