<?php

namespace app\api\controller\v1;

use app\api\controller\Common;
use app\common\lib\exception\ApiException;
use app\common\model\Advertise;
use app\common\model\Goods;
use think\Controller;
use think\Exception;
use think\Request;

class Index extends Common
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        try{
            $goods=Goods::where('status',1)
                ->field(['id','goods_name'])
                ->limit(10)
                ->select();
            $advertise=Advertise::where('status',1)
                ->field(['id'])
                ->limit(5)
                ->select();
        }catch (Exception $e){
            throw new ApiException($e->getMessage(),400,0);
        }

        if (empty($goods) || empty($advertise)){
            throw new ApiException('数据为空',404,0);
        }

        $data=[compact('goods','advertise')];
        return api(1,'ok',$data,200);
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
