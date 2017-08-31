<?php
namespace app\admin\controller;

use app\admin\model\Mails;
use think\Session;

class Mail extends Base{
    public function index(){
        $aid=Session::get('aid');
        $where['receiveid']=$aid;
        $list=Mails::where($where)
            ->with('mailContent')
            ->with('user')
            ->paginate(10);
        $this->assign('list',$list);
        $this->assign('page',$list->render());
        return $this->fetch();
    }
}