<?php
namespace app\common\validate;

use think\Validate;

class Brand extends Validate{
    protected $rule=[
        'title'=>'require',
        'content'=>'require',
        'digest'=>'require'
    ];

    protected $message=[
        'title.require'=>'文章标题不能为空！',
        'content.require'=>'文章内容不能为空！',
        'digest.require'=>'文章摘要不能为空！'
    ];
}