<?php

namespace app\common\service;

use app\common\model\Partner;
use PHPQRCode\QRcode;
use think\Cache;
use think\Controller;
use think\Log;
use think\Session;

class HttpClient extends Controller
{
    private static $headers = [];

    private static $cookie = null;

    public static function setHeader($header)
    {
        self::$headers = $header;
    }

    /**
     * 万能curl
     */
    public static function curl($url, $type = 'get', $data = null)
    {
        //初始化curl
        $curl = curl_init();
        //设置curl配置项
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //设置返回的内容不直接在界面中显示

        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_CERTINFO, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

        if (config('curl') && isset(config('curl')['timeout'])) {
            curl_setopt($curl, CURLOPT_TIMEOUT, config('curl')['timeout']);
        } else {
            curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        }

        if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        }

        if (!empty(self::$headers)) {
            $headerArr = [];
            foreach (self::$headers as $n => $v) {
                $headerArr[] = $n . ':' . $v;
            }
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArr);
        }

        if (self::$cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, self::$cookie);
        }

        if ($type == 'post') {
            curl_setopt($curl, CURLOPT_POST, 1); //设置请求类型为POST
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); //设置POST提交的数据
        }
        //执行http请求
        $res = curl_exec($curl);

        $errno = curl_errno($curl);
        $error = '';
        if ($errno) {
            $error = curl_error($curl);
        }

        //关闭curl资源
        curl_close($curl);

        Log::write('CURL：' . date('Y-m-d H:i:s') . "[url:{$url};method:{$type};data:" . json_encode($data) . ";result:{$res};errno:{$errno};error:{$error}", 'log', true);

        return $res;
    }

    /**
     * 获取全局access_token
     */
    public static function getAccessToken()
    {
        $config = config('wexin');
        $access_token = Cache::get('access_token');

        if (empty($access_token)) {

            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $config['appid'] . "&secret=" . $config['secret'];
            $res = self::curl($url);
            $arr = json_decode($res, true);

            $access_token = $arr['access_token'];
            Cache::set('access_token', $access_token, 7100);
        }

        return $access_token;
    }

    /**
     * 网页授权登录
     */
    public static function getUser()
    {
        $config = config('wexin');
        $code = input('param.code');
        if ($code) {
            $code_array = Cache::get('code_array');
            if (empty($code_array)) {
                $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $config['appid'] . "&secret=" . $config['secret'] . "&code=$code&grant_type=authorization_code";
                $res = HttpClient::curl($url);

                if (empty($res)) {
                    return false;
                }

                $code_array = json_decode($res, true);
                Cache::set('code_array', $code_array, 7100);
            }

            $access_token = $code_array['access_token'];
            $openid = $code_array['openid'];

            $url_info = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
            $info = self::curl($url_info);

            if (empty($info)) {
                return false;
            }

            $userInfo = json_decode($info, true);

            Session::set('wechat_info', $userInfo);
            return redirect('wexin/index');

        } else {
            $callBack = urlencode("http://" . $_SERVER['HTTP_HOST'] . "/wexin/getUser");

            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $config['appid'] . "&redirect_uri=" . $callBack . "&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";

            header("location:" . $url);
        }
    }

    /**
     * 发送模板消息
     */
    public static function sendTemplateMessage($data)
    {
        $access_token = self::getAccessToken();

        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access_token;
        $res = HttpClient::curl($url, 'post', $data);

        return json_decode($res, true);
    }

    //推送模板消息
    public static function send($openid, $data)
    {
        $template = [
            'touser' => $openid,
            'template_id' => 'MbyKVgU9yNFKBwClf25reuPzg8kKs0sLOyv2fwDcWb0',
            'data' => [
                'first' => [
                    'value' => '尊敬的客户，你的订单已经支付成功！',
                    'color' => '#173177'
                ],
                'keyword1' => [
                    'value' => '商城',
                    'color' => '#173177'
                ],
                'keyword2' => [
                    'value' => $data['order_sn'],
                    'color' => '#173177'
                ],
                'keyword3' => [
                    'value' => $data['amount'],
                    'color' => '#173177'
                ],
                'keyword4' => [
                    'value' => $data['pay_time'],
                    'color' => '#173177'
                ],
                'remark' => [
                    'value' => '我们会及时为您发货！',
                    'color' => '#173177'
                ]
            ]
        ];

        return self::sendTemplateMessage(urldecode(json_encode($template)));
    }

    /**
     * 是否微信浏览器
     */
    public static function isWechat()
    {
        $ua = $_SERVER['HTTP_USER_AGENT'];
        if (stripos($ua, 'micromessenger') !== false) {
            return true;
        }

        return false;
    }

    /**
     * 生成订单编号
     */
    public static function create_order_sn()
    {
        do {
            $time = explode(' ', microtime());
            $time = $time[1] . ($time[0] * 1000);
            $time = explode('.', $time);
            $time = (isset($time[1]) ? $time[1] : 0);
            $time = date('YmdHis') + $time;
            mt_srand((double)microtime() * 1000000);

            $order_sn = $time . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

        } while (\app\common\model\Order::where('order_sn', $order_sn)->find());

        return $order_sn;
    }

    /**
     * 生成订单编号
     */
    public static function get_order_sn()
    {
        do {
            $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $time = date('YmdHis', time());
            $orderNum = 'zjwam' . substr(str_shuffle($str), 0, 3) . $time;
        } while (\app\common\model\Order::where('order_sn', $orderNum)->find());

        return $orderNum;
    }

    /**
     * 获取加密字符串
     */
    public static function getToken()
    {
        do {
            $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $token = substr(str_shuffle($str), 0, 10);

        } while (Partner::where('token', $token)->find());

        return $token;
    }

    /**
     * 获取token
     */
    public static function getTokenType($token, $type)
    {
        $data = [
            'sign' => $token,
            'type' => $type
        ];

        $str = base64_encode(json_encode($data));

        return $str;
    }

    /**
     * 获取ip
     */
    public static function get_client_ip()
    {
        $cip = 'unknown';

        if ($_SERVER['REMOTE_ADDR']) {
            $cip = $_SERVER['REMOTE_ADDR'];
        } elseif (getenv('REMOTE_ADDR')) {
            $cip = getenv('REMOTE_ADDR');
        }

        return $cip;
    }

    /**
     * 生成二维码
     */
    public static function makeQrcode($url)
    {
        $errorCorrectionLevel = "Q"; // 纠错级别：L、M、Q、H
        $matrixPointSize = "8";      //图片大小

        ob_start();
        QRcode::png($url, false, $errorCorrectionLevel, $matrixPointSize, 2);

        //这里就是把生成的图片流从缓冲区保存到内存对象上，使用base64_encode变成编码字符串，通过json返回给页面。
        $image = base64_encode(ob_get_contents());
        //关闭缓冲区
        ob_end_clean();

        return $image;
    }

    /**
     * 生成门票凭证码
     * 字母大小写加数字共10位
     */
    public static function get_voucher_sn()
    {
        do {
            $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $voucherNum = substr(str_shuffle($str), 0, 10);
        } while (\app\common\model\Order::where('voucher', $voucherNum)->find());

        return $voucherNum;
    }
}