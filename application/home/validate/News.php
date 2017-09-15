<?php
namespace app\admin\validate;

use think\Validate;

class News extends Validate{
    protected $rule=[
        'title'=>'require',
        'content'=>'require',
    ];

    protected $message=[
        'title.require'=>'文章标题不能为空！',
        'content.require'=>'文章内容不能为空！',
    ];
}