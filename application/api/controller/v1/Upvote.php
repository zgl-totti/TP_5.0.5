<?php

namespace app\api\controller\v1;

use think\Exception;

class Upvote extends AuthBase
{
    /**
     * 点赞
     * @return \think\response\Json
     */
    public function save()
    {
        $id=input('post.id',0,'intval');
        if(empty($id)){
            return api(0,'id不存在',[],404);
        }

        //判断新闻是否存在
        $info=News::find($id);
        if(empty($info) || $info->status!=1){
            return api(0,'新闻不存在',[],404);
        }

        $data=[
            'news_id'=>$id,
            'user_id'=>$this->user->id
        ];

        //查询是否存在点赞
        $userNews=UserNews::where($data)->find();
        if($userNews){
            return api(0,'已经点赞过，不能再次点赞',[],401);
        }

        try{
            $row=(new UserNews)->save($data);
            if($row){
                News::where(['id'=>$id])->setInc('upvote_count');
                return api(1,'点赞成功',[],202);
            }else{
                return api(0,'点赞失败',[],500);
            }
        }catch (Exception $e){
            return api(0,$e->getMessage(),[],500);
        }
    }

    /**
     * 取消点赞
     * @return \think\response\Json
     */
    public function delete()
    {
        $id=input('delete.id',0,'intval');
        if(empty($id)){
            return api(0,'id不存在',[],404);
        }

        //判断新闻是否存在
        $info=News::find($id);
        if(empty($info) || $info->status!=1){
            return api(0,'新闻不存在',[],404);
        }

        $data=[
            'news_id'=>$id,
            'user_id'=>$this->user->id
        ];

        $userNews=UserNews::where($data)->find();
        if($userNews){
            return api(0,'没有被点赞过，不能取消',[],401);
        }

        try{
            $row=UserNews::where($data)->delete();
            if($row){
                News::where(['id'=>$id])->setDec('upvote_count');
                return api(1,'取消点赞成功',[],204);
            }else{
                return api(0,'取消点赞失败',[],500);
            }
        }catch (Exception $e){
            return api(0,$e->getMessage(),[],500);
        }
    }

    /**
     * 查看文章是否被该用户点赞
     * @return \think\response\Json
     */
    public function read()
    {
        $id=input('param.id',0,'intval');
        if(empty($id)){
            return api(0,'id不存在',[],404);
        }

        $data=[
            'news_id'=>$id,
            'user_id'=>$this->user->id
        ];

        $userNews=UserNews::where($data)->find();
        if($userNews){
            return api(1,'ok',['isUpvote'=>1],201);
        }else{
            return api(1,'ok',['isUpvote'=>0],201);
        }
    }
}