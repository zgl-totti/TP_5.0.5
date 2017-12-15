<?php
namespace app\admin\controller;

use app\admin\model\MailAdmin;
use think\Session;

class Mail extends Base{
    public function index(){
        $aid=Session::get('aid');
        $where['receiveid']=$aid;
        $list=MailAdmin::where($where)
            ->with('mailContent')
            ->with('user')
            ->paginate(10);
        $this->assign('list',$list);
        $this->assign('page',$list->render());
        return $this->fetch();
    }
}