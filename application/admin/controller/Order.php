<?php
namespace app\admin\controller;


use think\Exception;

class Order extends Base
{
    public function index()
    {
        $keywords = trim(input('get.keywords'));
        $time1 = trim(input('get.time1'));
        $time2 = trim(input('get.time2'));
        $time3 = strtotime($time1);
        $time4 = strtotime($time2);

        if ($keywords) {
            $where['orderno'] = ['like', "%$keywords%"];
        } else {
            $where = '';
        }

        if ($time1 && $time2) {
            $condition['create_time'] = ['between', [$time3, $time4]];
        } elseif ($time1 && !$time2) {
            $condition['create_time'] = ['gt', $time3];
        } elseif ($time2 && !$time1) {
            $condition['create_time'] = ['lt', $time4];
        } else {
            $condition = '';
        }

        $param['query']['keywords'] = $keywords;
        $param['query']['time1'] = $time1;
        $param['query']['time2'] = $time2;

        $list = \app\common\model\Order::where($where)
            ->where($condition)
            ->with('orderStatus')
            ->with('users')
            ->paginate(10, false, $param);

        $firstRow = ($list->currentPage() - 1) * $list->listRows();
        $this->assign('keywords', $keywords);
        $this->assign('time1', $time1);
        $this->assign('time2', $time2);
        $this->assign('list', $list);
        $this->assign('pages', $list->render());
        $this->assign(compact('firstRow'));
        return $this->fetch();
    }


    /**
     * 订单导出
     * @author totti_zgl
     * @date 2018/4/4 17:39
     */
    public function export()
    {
        //处理大数据量的导出
        set_time_limit(0);                                  #设置超时时间
        ini_set("memory_limit", "1024M");         #设置内存,防止内存溢出
        \PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;  #单元格缓存为MemoryGZip

        $orderno = trim(input('param.search'));
        if ($orderno) {
            $where['order_syn'] = ['like', "%$orderno%"];
        } else {
            $where = '';
        }
        $list = \app\common\model\Order::with('orderStatus')
            ->where($where)
            ->select();
        $objPHPExcel = new \PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '编号')
            ->setCellValue('B1', '订单号')
            ->setCellValue('C1', '订单状态')
            ->setCellValue('D1', '添加时间');

        //设置表格宽度
        $objPHPExcel->setActiveSheetIndex()->getColumnDimension('B')->setWidth(35);
        $objPHPExcel->setActiveSheetIndex()->getColumnDimension('D')->setWidth(35);

        //设置文字左右居中
        $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        foreach ($list as $k => $v) {
            $objPHPExcel->setActiveSheetIndex()
                ->setCellValue('A' . ($k + 2), $v['id'])
                ->setCellValue('B' . ($k + 2), $v['orderno'])
                ->setCellValue('C' . ($k + 2), $v['orderStatus']['statusname'])
                ->setCellValue('D' . ($k + 2), date('Y:m:d H:i:s', $v['createtime']));
        }


        /*
        //设置表单信息
        $objPHPExcel->getProperties()
            ->setCreator("PHPOffice")
            ->setLastModifiedBy("PHPOffice")
            ->setTitle("PHPExcel Test Document")
            ->setSubject("PHPExcel Test Document")
            ->setDescription("Test document for PHPExcel, generated using PHP classes.")
            ->setKeywords("Office PHPExcel php")
            ->setCategory("Test result file");

        //填充表头信息
        $line = ['A','B','C','D'];
        $header = ['编号','订单号','订单状态','添加时间'];
        for($i=0;$i<count($line);$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("$line[$i]1", "$header[$i]");
        }

        //填充表单信息
        foreach ($list as $k=>$v){
            $arr[$k]['id']=$v['id'];
            $arr[$k]['orderno']=$v['orderno'];
            $arr[$k]['status']=$v['orderStatus']['statusname'];
            $arr[$k]['createtime']=date('Y:m:d H:i:s',$v['createtime']);
        }
        for($i=2;$i<count($arr);$i++){
            $j = 0;
            foreach ($arr[$i - 2] as $k=>$v) {
                $objPHPExcel->getActiveSheet()->setCellValue("$line[$j]$i","$v");
                $j++;
            }
        }
        */


        //发送标题强制用户下载文件
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel;charset=UTF-8');
        header('Content-Disposition: attachment;filename="订单列表_' . date('Y/m/d') . '.xls"');
        header('Cache-Control: max-age=0');


        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }


    /**
     * Excel导入
     * @param $file
     * @return array
     * @author totti_zgl
     * @date 2018/5/14 10:55
     */
    public function inputExcel()
    {
        $files = request()->file('file');
        $file = $files->validate(['size' => 3145728, 'ext' => 'xls'])
            ->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . 'excel');
        if (empty($file)) {
            throw new Exception('上传失败', 401);
        }
        $file_name = $file->getFilename();

        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        //加载Excel路径
        $objPHPExcel = $objReader->load($file_name);
        $sheet = $objPHPExcel->getSheet(0);
        //取得总行数
        $highestRow = $sheet->getHighestRow();
        //取得总列数
        $highestColumn = $sheet->getHighestColumn();

        $objWorkerSheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorkerSheet->getHighestRow();
        $highestColumn = $objWorkerSheet->getHighestColumn();
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);

        //设置行的初始位置,从第几行获取数据
        for ($row = 1; $row < $highestRow; $row++) {
            $arr = [];
            //设置列的初始位置,$highestColumnIndex的列数索引从0开始
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                //获取单元格数据
                $arr[$col] = $objWorkerSheet->getCellByColumnAndRow($col, $row)->getValue();
            }
            //获取数据,过滤空行
            !empty($arr) && $list[] = $arr;
        }
        //删除excel文件
        unlink($file);

        return $list;
    }
}