<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/8
 * Time: 9:51
 */

namespace app\index\controller;


use think\Controller;

class WxPayPc extends Controller
{
    public function index()
    {
        $app_id = config('wxpay.app_id');          //公众号APPID 通过微信支付商户资料审核后邮件发送
        $mch_id = config('wxpay.mach_id');         //微信支付商户号 PartnerID 通过微信支付商户资料审核后邮件发送
        $api_key = config('wxpay.api_key');        //https://pay.weixin.qq.com 帐户设置-安全设置-API安全-API密钥-设置API密钥
        $wxPay = new WxpayService($app_id,$mch_id,$api_key);
        $outTradeNo = uniqid();                    //你自己的商品订单号
        $payAmount = 0.01;                         //付款金额，单位:元
        $orderName = '支付测试';                    //订单标题
        $notifyUrl = 'https://www.xxx.com/wx/';    //付款成功后的回调地址(不要有问号)
        $payTime = time();                         //付款时间

        $arr = $wxPay->createJsBizPackage($payAmount,$outTradeNo,$orderName,$notifyUrl,$payTime);

        /*//生成二维码
        $url = 'http://qr.liantu.com/api.php?text='.$arr['code_url'];
        echo "<img src='{$url}' style='width:300px;'>";*/

        $text=base64_encode($arr['code_url']);

        $this->assign(compact('text'));
        return $this->fetch('');
    }

    /**
     * 二维码。
     * @param string $text
     * @return png
     */
    public function qrcode($text) {
        \think\Loader::import('qrcode.qrcode');
        $text = base64_decode($text);
        return \QRcode::png($text);
        exit;
    }

    /**
     * 微信通知页面。
     */
    public function wxpayNotify() {
        ini_set('date.timezone', 'Asia/Shanghai');
        \think\Loader::import('wxpay.Autoloader');
        error_reporting(E_ERROR);
        //初始化日志
        $logHandler = new \CLogFileHandler("../logs/" . date('Y-m-d') . '.log');
        \Log::Init($logHandler, 15);
        \Log::DEBUG("begin notify");

        //在PayNotifyCallBack中重写了NotifyProcess，会发起一个订单支付状态查询，其实也可以不去查询，因为从php://input中已经可以获取到订单状态。file_get_contents("php://input")
        //$notify = new \WxPayNotify();
        $notify = new \PayNotifyCallBack();
        $notify->Handle(false);
        $result = $notify->GetValues();
        if ($result['return_code'] == 'SUCCESS') {
            //订单支付完成，修改订单状态，发货。
        }
        \Log::DEBUG("end notify");
        \Log::INFO(str_repeat("=", 20));
    }


    //查询支付状态
    public function checkOrderStatus()
    {
        $order_sn=input('post.order_sn');
        if(isset($order_sn) && $order_sn){
            $out_trade_no=$order_sn;
            $input = new WxPayOrderQuery();
            $input->SetOut_trade_no($out_trade_no);

            $result=WxPayApi::orderQuery($input);

            $status['code'] =  $result['trade_state'];
            $status['openid'] =  $result['openid'];
            $status['total_fee'] =  $result['total_fee'];
            $status['transaction_id'] =  $result['transaction_id'];
            $status['time'] =  $result['time_end'];

            //print_r(json_encode($status));
            //exit();

            return $status;
        }


        $order_id=input('post.order_id',0,'intval');
        if(empty($order_id)){
            $res=[
                'status'=>0,
                'info'=>'id不能为空！'
            ];
            return $res;
        }

        try {
            $info = Order::find($order_id);
            if (empty($info)) {
                $res = [
                    'status' => 0,
                    'info' => '订单不存在！'
                ];
                return $res;
            }

            if ($info->order_status == 2) {
                $res = [
                    'status' => 1,
                    'info' => 'ok！'
                ];
                return $res;
            }

            $res = [
                'status' => 0,
                'info' => 'error！'
            ];
            return $res;

        }catch (\Exception $e){
            $res = [
                'status' => 0,
                'info' => $e->getMessage()
            ];
            return $res;
        }
    }
}