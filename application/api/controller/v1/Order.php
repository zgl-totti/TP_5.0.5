<?php

namespace app\api\controller\v1;

use app\api\controller\Common;
use app\common\exception\ApiException;
use think\Exception;
use think\Request;

class Order extends Common
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        try{
            $data=\app\common\model\Order::paginate(10);
        }catch (Exception $e){
            throw new ApiException($e->getMessage(),400,0);
        }

        if(empty($data)){
            throw new ApiException('数据为空',404,0);
        }

        return api(1,'',$data->toArray(),200);
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
        try{
            $info=\app\common\model\Order::get($id);
        }catch (Exception $e){
            throw new ApiException($e->getMessage(),400,0);
        }

        if(empty($info)){
            throw new ApiException('数据为空',404,0);
        }

        return api(1,'',$info->toArray(),200);
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
        try{
            $info=\app\common\model\Order::get($id);
            $info->status=$info['status']==1?0:1;
        }catch (Exception $e){
            throw new ApiException($e->getMessage(),400,0);
        }

        $row=$info->save();
        if(empty($row)){
            throw new ApiException('更新失败',404,0);
        }

        return api(1,'更新成功',$info->toArray(),202);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        try{
            $row=\app\common\model\Order::get($id)->delete();
        }catch (Exception $e){
            throw new ApiException($e->getMessage(),400,0);
        }

        if(empty($row)){
            throw new ApiException('删除失败',404,0);
        }

        return api(1,'删除成功',[],204);
    }
}
