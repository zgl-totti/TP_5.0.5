<?php
namespace app\common\validate;

use think\Validate;

class Product extends Validate{
    protected $rule=[
        'goodsname'=>'require',
        'content'=>'require',
        'digest'=>'require',
        'sid'=>'require|integer|gt:0',
        'price'=>'require|number|egt:0'
    ];

    protected $message=[
        'goodsname.require'=>'商品名称不能为空！',
        'content.require'=>'商品详情不能为空！',
        'digest.require'=>'商品摘要不能为空！',
        'sid.require'=>'商品分类不能为空！',
        'sid.integer'=>'商品分类不合规则！',
        'sid.gt'=>'商品分类不能为空！',
        'price.require'=>'商品价格不能为空！',
        'price.number'=>'商品价格必须为数字！',
        'price.egt'=>'商品价格必须大于等于0',
    ];
}