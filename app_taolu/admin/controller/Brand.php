<?php
namespace app\admin\controller;

class Brand extends Base{
    //品牌列表
    public function index(){
        $keywords=trim(input('get.chaXun'));
        if($keywords) {
            $where['bname'] = ['like', "$keywords"];
        }else{
            $where='';
        }
        $list=model('Brands')->getAll($where,10);
        $this->assign('keywords',$keywords?$keywords:'');
        $this->assign('list',$list);
        $this->assign('page',$list->render());
        return $this->fetch('list');
    }

    public function upData(){
        if(request()->isAjax()){
            $id=input('post.id');
            $where['id']=$id;
            $info=model('Brands')->getOne($where);
            if($info){
                $data['status']=($info['status']==1)?0:1;
                $row=model('Brands')->updateBrands($where,$data);
                if($row){
                    $res['status']=1;
                    $res['info']='更新状态成功！';
                    return $res;
                }else{
                    $res['status']=2;
                    $res['info']='更新状态失败！';
                    return $res;
                }
            }else{
                $res['status']=3;
                $res['info']='该品牌不存在！';
                return $res;
            }
        }
    }

    public function addbrands(){
        if(request()->isAjax()){
            $bname = trim(input('post.catename'));
            $brandtype=input('post.brandtype');
            $addtime=input('post.time1');
            if($bname && $brandtype>0 && $addtime){
                $data['bname']=$bname;
                $data['brandtype']=$brandtype;
                $data['addtime']=$addtime;
                $id=model('Brands')->addBrands($data);
                if($id){
                    //创建上传文件夹;
                    if (!file_exists(ROOT_PATH.'public'.DS.'uploads'.DS.'brands')) {
                        mkdir(ROOT_PATH.'public'.DS.'uploads'.DS.'brands');
                    }
                    $file=request()->file('image');
                    $info=$file->validate(['size'=>3145728,'ext'=>'jpg,gif,png,jpeg'])
                        ->move(ROOT_PATH.'public'.DS.'uploads'.DS.'brands');
                    if($info){
                        $pic['blogoname']=$file->getFilename();
                        $pic['blogopath']=$file->getSaveName();
                        $where['id']=$id;
                        $row=model('Brands')->updateBrands($where,$pic);
                        if($row){
                            $res['status']=1;
                            $res['info']='添加成功！';
                            return $res;
                        }else{
                            $res['status']=2;
                            $res['info']='添加失败！';
                            return $res;
                        }
                    }else{
                        $res['status']=3;
                        $res['info']='上传失败！';
                        return $res;
                    }
                }else{
                    $res['status']=4;
                    $res['info']='添加失败！';
                    return $res;
                }
            }else{
                $res['status']=5;
                $res['info']='必填项不能为空！';
                return $res;
            }
        }else{
            return $this->fetch('Brand/add');
        }
    }

    //验证品牌是否已添加
    public function chkBname(){
        $bname = trim(input('post.catename'));
        $where['bname'] = $bname;
        $info = model('Brands')->getOne($where);
        if ($info) {
            echo 'false';
        } else {
            echo 'true';
        }
    }
}