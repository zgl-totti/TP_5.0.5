<?php
namespace app\admin\validate;

use think\Validate;

class Expert extends Validate{
    protected $rule=[
        'username'=>'require',
        'role'=>'require|max:12',
        'gender'=>'require|integer',
        'department'=>'require|integer',
        'introduce'=>'require'
    ];

    protected $message=[
        'username.require'=>'专家名字不能为空！',
        'role.require'=>'职称不能为空！',
        'role.max'=>'职称长度最大为12个字符！',
        'gender.require'=>'性别不能为空！',
        'gender.integer'=>'性别必须为数字！',
        'department.require'=>'科室名称不能为空！',
        'department.integer'=>'科室必须为数字！',
        'introduce.require'=>'简介不能为空！'
    ];
}