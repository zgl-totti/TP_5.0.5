<?php

use think\migration\Migrator;
use think\migration\db\Column;

class AdminUser extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('admin_user',['comment'=>'举例表']);

        $table->addColumn('user_name','string',['comment'=>'用户名'])
            ->addColumn('phone','string',['limit'=>11,'comment'=>'手机号'])
            ->addColumn('nick_name','string',['null'=>true,'comment'=>'用户昵称'])
            ->addColumn('password','string',['comment'=>'密码'])
            ->addColumn('token','string',['comment'=>'密码token'])
            ->addColumn('type','integer',['default'=>1,'comment'=>'用户类型:1为普通用户;2为专家用户'])
            ->addColumn('method','integer',['default'=>1,'comment'=>'注册方式:1为PC端注册;2为APP注册;3为后台添加;'])
            ->addColumn('vip','integer',['default'=>2,'comment'=>'是否是VIP用户:1为vip;2为非vip'])
            ->addColumn('over_time','date',['null'=>true,'comment'=>'VIP用户的过期时间'])
            ->addColumn('integral','integer',['default'=>0,'comment'=>'积分'])
            ->addColumn('admin_id','integer',['null'=>true,'comment'=>'管理员ID'])
            ->addColumn('pic','string',['null'=>true,'comment'=>'用户头像'])
            ->addColumn('login_ip','string',['null'=>true,'comment'=>'登录IP'])
            ->addColumn('login_time','integer',['null'=>true,'comment'=>'登录时间'])
            ->addColumn('third_login','integer',['null'=>true,'comment'=>'第三方登录:1为QQ;2为微信;3为微博;4为其它'])
            ->addColumn('unionid','string',['null'=>true,'comment'=>'第三方登录唯一ID'])
            ->addColumn('status','integer',['default'=>1,'comment'=>'状态:1为正常;2为下架'])
            ->addColumn('create_time','integer',['comment'=>'创建时间'])
            ->addColumn('update_time','integer',['comment'=>'更新时间'])
            ->addIndex('nick_name')
            ->addIndex(['user_name','phone'], ['unique' => true,'name'=>'name_phone_unique'])
            ->addIndex(['type','method','vip','status'], ['limit'=>8,'type'=>'fulltext'])
            ->addIndex(['user_name','status'], ['limit'=>['user_name'=>2,'status'=>2]])
            ->create();
    }
}
