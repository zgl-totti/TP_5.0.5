<?php
namespace app\common\validate;

use think\Validate;

class System extends Validate{
    protected $rule=[
        'name'=>'require',
        'priority'=>'require|integer',
    ];

    protected $message=[
        'name.require'=>'网站名称不能为空！',
        'priority.require'=>'优先度不能为空！',
        'priority.integer'=>'优先度必须是数字！'
    ];
}