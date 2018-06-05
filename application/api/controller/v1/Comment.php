<?php

namespace app\api\controller\v1;


use think\Exception;

class Comment extends AuthBase
{
    /**
     * 评论
     * @return \think\response\Json
     */
    public function save()
    {
        $data=input('post.');

        //validate验证

        if(empty($data['news_id'])){
            return api(0,'news_id不存在',[],404);
        }

        //判断新闻是否存在
        $info=News::find($data['news_id']);
        if(empty($info) || $info->status!=1){
            return api(0,'新闻不存在',[],404);
        }

        $data['user_id']=$this->user->id;

        try{
            $row=(new Comment)->save($data);
            if($row){
                return api(1,'评论成功',[],202);
            }else{
                return api(0,'评论失败',[],500);
            }
        }catch(Exception $e){
            return api(0,$e->getMessage(),[],500);
        }
    }

    public function read()
    {
        $news_id=input('param.id',0,'intval');
        if(empty($news_id)){
            return api(0,'news_id不存在',[],404);
        }

        //判断新闻是否存在
        $info=News::find($news_id);
        if(empty($info) || $info->status!=1){
            return api(0,'新闻不存在',[],404);
        }

        $list=Comment::with('user')
            ->where('news_id',$news_id)
            ->order('id desc')
            ->get();
        $count=Comment::with('user')
            ->where('news_id',$news_id)
            ->order('id desc')
            ->count();

        $result=[
            'total'=>$count,
            'page_num'=>ceil($count/$this->size),
            'list'=>$list
        ];

        return api(1,'ok',$result,200);
    }
}