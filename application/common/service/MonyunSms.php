<?php

namespace app\common\service;


use think\Cache;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use think\Log;

class MonyunSms
{
    const LOG_SMS = 'monyun:';

    const LOG_MAIL = 'email:';

    private static $_instance = null;

    private function __construct(){}

    /**
     * 静态方法，单例模式统一入口
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * 发送短信验证码
     */
    public function setSmsIdentify($phone, $type)
    {
        vendor("PhpSmsAPI.SmsSendConn");
        vendor("PhpSmsAPI.ConfigManager");

        $cache = Cache::get($type.'_'.$phone);
        if($cache){
            $res=[
                'code'=>1
            ];
            return $res;
        }

        $ConfigManager = new \ConfigManager();
        //主IP,请前往您的控制台获取请求域名(IP)或联系梦网客服进行获取
        $ip['ipAddress1'] = 'api01.monyun.cn:7901';
        //备IP1
        $ip['ipAddress2'] = '192.168.2.6:1001';
        //备IP2
        $ip['ipAddress3'] = '192.168.2.6:1002';
        //备IP3
        $ip['ipAddress4'] = '192.168.2.6:1003';
        try {
            if ($ConfigManager->set_usableip($ip)) {
                /*
                * 单条发送
                */
                $SmsSendConn = new \SmsSendConn();
                //初始化数组
                $data = array();
                //设置账号(账号需要大写)
                $data['userid'] = 'E100MS';
                //设置密码（密码MD5加密模式下时间戳在encrypt_pwd函数中自动获取时间戳并生成MD5密文密码，在这里不管加密还是不加密都不用设置时间戳）
                $data['pwd'] = '8UdE3E';
                // 设置手机号码 此处只能设置一个手机号码
                $data['mobile'] = $phone;

                //设置发送短信内容
                $code = rand(100000,999999);
                $data['content'] = "您的验证码为{$code}，请于5分钟内正确输入，如非本人操作，请忽略此短信。";
                // 业务类型
                $data['svrtype'] = 'SMS001';
                // 设置扩展号
                $data['exno'] = '11';
                //用户自定义流水编号
                $data['custid'] = 'b3d1a2783d31b21b8573';
                // 自定义扩展数据
                $data['exdata'] = '12316';
                //请求地址
                $url = '/sms/v2/std/';
                //密码是否加密
                $isEncryptPwd = true;

                $result = $SmsSendConn->singleSend($url, $data, $isEncryptPwd);
                if ($result['result'] === 0) {
                    //设置验证码失效时间
                    Cache::set($type.'_'.$phone,$code,300);

                    Log::write(self::LOG_SMS.'success--'.$type.'_'.$phone);

                    return true;
                }

                Log::write(self::LOG_SMS.'set--'.json_encode($result));
            }

            return false;
        } catch (\Exception $e) {
            Log::record(self::LOG_SMS.'set--'.$e->getMessage());
            return false;
        }
    }

    /**
     * 发送邮件验证码
     */
    public static function sendEmail($email)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 1;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.qq.com';                          // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'zjwamgw@qq.com';                   // SMTP username
            $mail->Password = 'ddqjqixukavuddce';                 // SMTP password
            $mail->SMTPSecure = 'TLS';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
            $mail->setFrom('zjwamgw@qq.com', '中教网盟');
            $mail->addAddress('zjwamgw@qq.com');
            $mail->addAddress("{$email}");
            $mail->Subject = '中教网盟公共服务平台';
            $code = rand(100000,999999);
            $mail->Body = "您的邮箱验证码是：{$code}，如果不是您本人操作，请忽略。 ";

            $result=$mail->send();
            if ($result) {
                //设置验证码失效时间
                Cache::set('mail'.'_'.$email,$code,config('aliSms.identify_time'));

                return true;
            }

            Log::write(self::LOG_MAIL.'set--'.json_encode($result));

            return false;
        } catch (\Exception $e) {
            Log::record(self::LOG_MAIL.'set--'.$e->getMessage());

            return false;
        }
    }

    /**
     * 根据手机号/邮箱查验验证码
     */
    public function checkSmsIdentify($str,$type)
    {
        if(!$str){
            return false;
        }

        if(!$type){
            return false;
        }

        return Cache::get($type.'_'.$str);
    }
}