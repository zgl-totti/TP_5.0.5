<?php
namespace app\admin\controller;

class Advertise extends Base{

    //广告列表
    public function index(){
        $keywords=input('get.keywords');
        if($keywords){
            $where['title']=['like',"%$keywords%"];
        }else{
            $where='';
        }
        $list=model('Advertise')->advertiseList($where);
        $this->assign('keywords',$keywords?$keywords:'');
        $this->assign('list',$list);
        $this->assign('firstRow',($list->currentPage()-1)*$list->listRows());
        $this->assign('page',$list->render());
        return $this->fetch('list');
    }

    //添加广告操作;
    public function add(){
        if(request()->isPost()){
            $data['title'] = trim(input('param.title'));
            $data['position'] = trim(input('param.position'));
            $data['detail'] = trim(input('param.content'));
            //判断上传的信息;
            if($data['title'] && $data['position'] && $data['detail']){
                $data['addtime']=time();
                //把数据添加到数据库;
                $id=model('Advertise')->addAdvertise($data);
                if($id){
                    //创建上传文件夹;
                    if (!file_exists(ROOT_PATH.'public'.DS.'uploads'.DS.'advertise')) {
                        mkdir(ROOT_PATH.'public'.DS.'uploads'.DS.'advertise');
                    }
                    //处理图片上传;
                    $file=request()->file('pic');
                    $info=$file->validate(['size'=>3145728,'ext'=>'jpg,gif,png,jpeg'])
                        ->move(ROOT_PATH.'public'.DS.'uploads'.DS.'advertise');
                    if($info){
                        $pic['picname']=$file->getFilename();
                        $pic['picurl']=$file->getSaveName();
                        $where['id']=$id;
                        $row=model('Advertise')->editAdvertise($where,$pic);
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
                $res['info']='上传不能为空！';
                return $res;
            }
        }else{
            return $this->fetch('add');
        }
    }

    /*//添加广告操作;
    public function add(){
        if (IS_POST) {
            $advertise = M('Advertise');
            $data['title'] = trim(input('param.title'));
            $data['position'] = input('param.position');
            $data['detail'] = trim(input('param.content'));
            //判断上传的信息;
            if (input('param.title') && input('param.position') > 0 && input('param.content')) {
                $data['addtime'] = time();
                //把数据添加到数据库;
                if ($id = $advertise->add($data)) {
                    //处理图片上传;
                    $upload = new Upload();
                    $upload->maxSize = 3145728;
                    $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                    $upload->rootPath = './Uploads/Advertises/';
                    //创建上传文件夹;
                    if (!file_exists($upload->rootPath)) {
                        mkdir($upload->rootPath);
                    }
                    //上传操作;
                    $info = $upload->upload();
                    if($info){
                        foreach($info as $file){
                            //获取图片文件路径;
                            $filename='./Uploads/Advertises/'.$file['savepath'].$file['savename'];
                            //生成缩略图;
                            $image=new Image();
                            if(input('param.position')==1){
                                $thumb='/Uploads/Advertises/1/'.$file['savepath'].$file['savename'];
                                $image->open($filename)->thumb(1200,300)->save($thumb);
                            }elseif(input('param.position')==2){
                                $thumb='/Uploads/Advertises/2/'.$file['savepath'].$file['savename'];
                                $image->open($filename)->thumb(1200,460)->save($thumb);
                            }elseif(input('param.position')==3){
                                $thumb='/Uploads/Advertises/3/'.$file['savepath'].$file['savename'];
                                $image->open($filename)->thumb(300,320)->save($thumb);
                            }elseif(input('param.position')==4){
                                $thumb='/Uploads/Advertises/4/'.$file['savepath'].$file['savename'];
                                $image->open($filename)->thumb(100,100)->save($thumb);
                            }else{
                                $thumb='/Uploads/Advertises/5/'.$file['savepath'].$file['savename'];
                                $image->open($filename)->thumb(100,100)->save($thumb);
                            }
                            $data['picurl']=$file['savepath'];
                            $data['picname']=$file['savename'];
                            if($advertise->where(array('id'=>$id))->field('picurl,picname')->save($data)){
                                $this->success('广告添加成功,请继续添加');
                            } else {
                                $this->error('广告添加失败');
                            }
                        }
                    } else {
                        $upload->getError();
                    }
                }
            } else {
                $this->error('上传广告不能为空');
            }
        } else {
            return $this->fetch('add');
        }
    }*/

    //更改广告状态;
    public function operate(){
        if(request()->isAjax()){
            $where['id']=input('post.id');
            $info=model('Advertise')->getAdvertise($where);
            if($info){
                $data['status']=($info['status']==1)?0:1;
                $row=model('Advertise')->editAdvertise($where,$data);
                if($row){
                    $res['status']=1;
                    $res['info']='状态更改成功！';
                    return $res;
                }else{
                    $res['status']=2;
                    $res['info']='状态更改失败！';
                    return $res;
                }
            }else{
                $res['status']=3;
                $res['info']='广告不存在！';
                return $res;
            }
        }
    }

    //删除广告操作;
    public function delAdvertise(){
        if(request()->isAjax()){
            $where['id']=input('post.id');
            $info=model('Advertise')->getAdvertise($where);
            if($info){
                $row=model('Advertise')->delAdvertise($where);
                if($row){
                    $res['status']=1;
                    $res['info']='删除成功！';
                    return $res;
                }else{
                    $res['status']=2;
                    $res['info']='删除失败！';
                    return $res;
                }
            }else{
                $res['status']=3;
                $res['info']='广告不存在！';
                return $res;
            }
        }
    }

    //广告编辑操作;
    public function edit(){
        if(request()->isAjax()){
            $where['id']=input('post.id');
            $data['title']=trim(input('post.title'));
            $data['position']=input('post.position');
            $data['detail']=trim(input('post.content'));
            //判断上传的信息;
            if($data['title'] && $data['position'] && $data['detail']){
                $data['addtime'] = time();
                //把数据更新到数据库;
                $row1=model('Advertise')->editAdvertise($where,$data);
                if($row1){
                    //处理图片上传
                    $file=request()->file('image');
                    $info=$file->validate(['size'=>3145728,'ext'=>'jpg,gif,png,jpeg'])
                        ->move(ROOT_PATH.'public'.DS.'uploads'.DS.'advertise');
                    if($info){
                        $pic['picname']=$file->getFilename();
                        $pic['picurl']=$file->getSaveName();
                        $row2=model('Advertise')->editAdvertise($where,$pic);
                        if($row2){
                            $res['status']=1;
                            $res['info']='编辑成功！';
                            return $res;
                        }else{
                            $res['status']=2;
                            $res['info']='编辑失败！';
                            return $res;
                        }
                    }else{
                        $res['status']=3;
                        $res['info']=$file->getError();
                        return $res;
                    }
                }else{
                    $res['status']=4;
                    $res['info']='编辑失败！';
                    return $res;
                }
            }else{
                $res['status']=5;
                $res['info']='上传不能为空！';
                return $res;
            }
        }else{
            $where['id']=input('param.id');
            $info=model('Advertise')->getAdvertise($where);
            $this->assign('info',$info);
            return $this->fetch('edit');
        }
    }
}







