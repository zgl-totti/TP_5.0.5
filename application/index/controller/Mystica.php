<?php
namespace app\index\controller;

use app\index\model\Sector;
use think\Controller;

class Mystica extends Controller{
    public function index(){
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Method:POST");
        if(request()->isPost()){
            $token=input('post.token');
            $factor=input('post.factor');
            if(!$this->checkToken($token)){
                $res['code']=100;
                $res['info']='非法操作！';
                return json($res);
            }
            if(!$this->checkFactor($factor)){
                $res['code']=500;
                $res['info']='非法操作！';
                return json($res);
            }
            $model = new \app\index\model\Mystica();
            $weChat = $model->index($factor);
            $res['code'] = 1;
            $res['info'] = $weChat;
            return json($res);
        }
    }

    public function checkToken($data){
        if(empty($data)){
            return false;
        }
        if($data==='1001'){
            return true;
        }else{
            return false;
        }
    }

    public function checkFactor($data){
        if(empty($data)){
            return false;
        }
        $sector= new Sector();
        $res=$sector->index();
        if(in_array($data,$res)){
            return true;
        }else{
            return false;
        }
    }
}