<?php
namespace Home\Controller;
Use Think\Controller;
use Think\Upload;
class CommonController extends Controller{
    public function uploadPic(){
        $upload=new Upload();
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './CommentImg/'; // 设置附件上传根目录
        // $upload->autoSub =false;
        if(!file_exists($upload->rootPath)){
            mkdir($upload->rootPath);
        }
        $info=$upload->upload();
        if($info){
            return $info;
        }else{
            return $upload->getError();
        }
    }
}