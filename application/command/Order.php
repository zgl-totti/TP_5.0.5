<?php

namespace app\common\command;

use app\common\model\Goods;
use app\common\model\OrderGoods;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Log;

# sh -c "cd /www/wwwroot/shop.jinagc.com;php think order;"
# 0 */1 * * * /home/crontab/shop_jinagc_com.sh

class Order extends Command
{
    protected function configure()
    {
        $this->setName('order')->setDescription('Here is the remark ');
    }

    protected function execute(Input $input, Output $output)
    {
        //$output->writeln("TestCommand:");

        try {

            $where['pay_status'] = 0;
            $where['add_time'] = ['<', time() - 72 * 3600];
            $where['order_status'] = ['<>', 10];

            $list = OrderGoods::where('order_id', 'in', function ($query) use ($where) {
                $query->table('dsc_order_info')->where($where)->field('order_id');
            })
                ->field('goods_id,goods_number')
                ->lock(true)
                ->select();

            if ($list) {
                foreach ($list as $v) {
                    Goods::where('goods_id', $v['goods_id'])->setInc('goods_number', $v['goods_number']);

                    $sales_volume = Goods::where('goods_id', $v['goods_id'])->value('sales_volume');
                    if (intval($sales_volume) >= intval($v['goods_number'])) {
                        Goods::where('goods_id', $v['goods_id'])->setDec('sales_volume', $v['goods_number']);
                    } else {
                        Goods::where('goods_id', $v['goods_id'])->update(['sales_volume' => 0]);
                    }
                }
            }

            $row = \app\common\model\Order::where($where)->update(['order_status' => 10]);

            if ($row) {
                Log::write('command:success_' . time() . '_条数：' . $row);
            } else {
                Log::write('command:error_' . time());
            }
        } catch (\Exception $e) {
            Log::write('command:warning_' . time() . '_' . $e->getMessage());
        }
    }
}