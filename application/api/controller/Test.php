<?php

namespace app\api\controller;

use app\common\lib\exception\ApiException;
use app\common\model\Admin;
use think\Controller;
use think\exception\HttpException;
use think\Log;
use think\Request;

class Test extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $data=Admin::all();
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
        $data=input('post.');
        $validator=validate('Admin');
        if($validator->scene('add')->check($data)){
            $data['password']=md5($data['password'].$data['token']);
            $admin= new Admin();
            $admin->allowField(true)->save($data);
            return api(1,'添加成功',$admin->toArray(),201);
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        $info=Admin::get($id)->toArray();
        return api(1,'',$info,200);
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
        try {
            $info = Admin::get($id);
            $info->status = $info['status'] == 1 ? 0 : 1;
            $info->save();
            $data = $info->toArray();
            return api(1, '更新成功', $data, 202);
        }catch (\Exception $e) {
            //Log::record('错误异常'.$e->getMessage());
            exception($e->getMessage(), 404,'\app\common\lib\exception\ApiException');
            //return api(0,$e->getMessage(),[],404);
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        Admin::get($id)->delete();
        return api(1,'删除成功',[],204);
    }
}
