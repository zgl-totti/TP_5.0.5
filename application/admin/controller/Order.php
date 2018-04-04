<?php
namespace app\admin\controller;


class Order extends Base{
    public function index(){
        $keywords=trim(input('get.keywords'));
        $time1=trim(input('get.time1'));
        $time2=trim(input('get.time2'));
        $time3=strtotime($time1);
        $time4=strtotime($time2);
        if($keywords){
            $where['orderno']=['like',"%$keywords%"];
        }else{
            $where='';
        }
        if($time1 && $time2){
            $condition['create_time']=['between',[$time3,$time4]];
        }elseif($time1 && !$time2){
            $condition['create_time']=['gt',$time3];
        }elseif($time2 && !$time1){
            $condition['create_time']=['lt',$time4];
        }else{
            $condition='';
        }
        $data['query']['keywords']=$keywords;
        $list=\app\admin\model\Order::where($where)
            ->where($condition)
            ->with('orderStatus')
            ->with('users')
            ->paginate(10,false,$data);
        $firstRow=($list->currentPage()-1)*$list->listRows();
        $this->assign('keywords',$keywords);
        $this->assign('time1',$time1);
        $this->assign('time2',$time2);
        $this->assign('list',$list);
        $this->assign('pages',$list->render());
        $this->assign(compact('firstRow'));
        return $this->fetch();
    }


    /**
     * 订单导出
     * @author totti_zgl
     * @date 2018/4/4 17:39
     */
    public function export(){
        $orderno=trim(input('param.search'));
        if($orderno){
            $where['order_syn']=['like',"%$orderno%"];
        }else{
            $where='';
        }
        $list=\app\admin\model\Order::with('orderStatus')
            ->where($where)
            ->select();
        //print_r($list);
        $objPHPExcel= new \PHPExcel();

        /*$objPHPExcel->getProperties()
            ->setCreator("PHPOffice")
            ->setLastModifiedBy("PHPOffice")
            ->setTitle("PHPExcel Test Document")
            ->setSubject("PHPExcel Test Document")
            ->setDescription("Test document for PHPExcel, generated using PHP classes.")
            ->setKeywords("Office PHPExcel php")
            ->setCategory("Test result file");*/

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '编号')
            ->setCellValue('B1', '订单号')
            ->setCellValue('C1','订单状态')
            ->setCellValue('D1','添加时间');
        $objPHPExcel->setActiveSheetIndex()->getColumnDimension('D')->setWidth(50);
        foreach ($list as $k=>$v){
            $objPHPExcel->setActiveSheetIndex()
                ->setCellValue('A'.($k+2),$v['id'])
                ->setCellValue('B'.($k+2),$v['orderno'])
                ->setCellValue('C'.($k+2),$v['orderStatus']['statusname'])
                ->setCellValue('D'.($k+2),date('Y:m:d H:i:s',$v['createtime']));
        }
        $objWriter=\PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
    }
}