<?php
namespace app\common\validate;

use think\Validate;

class Equipment extends Validate{
    protected $rule=[
        'sid'=>'require|gt:0',
        'username'=>'require',
        'cycle'=>'require|number|gt:0',
        'content'=>'require'
    ];

    protected $message=[
        'username.require'=>'患者不能为空！',
        'cycle.require'=>'服药周期不能为空！',
        'cycle.number'=>'服药周期必须为数字！',
        'cycle.gt'=>'服药周期必须大于0！',
        'sid.require'=>'科室分类不能为空！',
        'sid.gt'=>'科室分类不能为空！',
        'content.require'=>'内容不能为空！',
    ];
}