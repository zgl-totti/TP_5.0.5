<?php

namespace app\api\controller\v1;

use app\api\controller\Common;
use think\Controller;
use think\Request;

class Goods extends Common
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $data=input('get.');
        if(!empty($data['keywords'])){
            $where['goods_name']=['like',$data['keywords'].'%'];
        }
        if(!empty($data['cate_id'])) {
            $where['cate_id'] = $data['cate_id'] ?? 0;
        }
        $where['status']=1;
        $list=\app\common\model\Goods::where($where)
            ->field(['id','goods_name'])
            ->limit(10)
            ->select();
        return api(1,'ok',$list,200);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
