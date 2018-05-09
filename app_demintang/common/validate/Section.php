<?php
namespace app\common\validate;

use think\Validate;

class Section extends Validate{
    protected $rule=[
        'cname'=>'require',
        'intro'=>'require',
        'pid'=>'require'
    ];

    protected $message=[
        'cname.require'=>'科室名称不能为空！',
        'intro.require'=>'简介不能为空！',
        'pid.require'=>'分类不能为空！',
    ];
}