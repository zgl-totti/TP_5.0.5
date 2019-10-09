<?php

namespace app\api\controller\v1;

use app\api\controller\Common;
use app\common\exception\ApiException;
use app\common\model\Advertise;
use app\common\model\Goods;
use app\common\model\Version;
use think\Exception;
use think\Log;
use think\Request;

class Index extends Common
{
    //版本初始化接口
    public function init()
    {
        try{
            $version=Version::where('app_type',$this->headers['app_type'])
                ->order('id desc')
                ->find();
        }catch (Exception $e){
            throw new ApiException($e->getMessage(),400);
        }

        if(empty($version)){
            return new ApiException('error',404);
        }

        //1为强制更新,2为更新,3为不更新
        if($version->version>$this->headers['version']){
            $version->is_update=$version->is_force==1?2:1;
        }else{
            $version->is_update=0;
        }

        //记录用户的基本信息
        $actives=[
            'version'=>$this->headers['version'],
            'app_type'=>$this->headers['app_type'],
            'did'=>$this->headers['did']
        ];
        try{
            $actives= new AppActives();
            $actives->save($actives);
        }catch (Exception $e){
            Log::record($e->getMessage());
        }

        return api(1,'ok',$version,200);
    }


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
