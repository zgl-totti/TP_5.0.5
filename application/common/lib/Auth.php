<?php
namespace app\common\lib;

use think\Cache;

class Auth
{
    /**
     * 生成签名sign
     * @param array $data
     * @return string
     */
    public static function setSign($data=[])
    {
        //签名sign中包含type、time

        //按字段排序
        ksort($data);
        //拼接字符串数据
        $str=http_build_str($data);

        //通过aes加密
        $str=(new Aes())->encrypt($str);

        //通过rsa加密
        //$str=(new Rsa())->encrypt($str);

        //通过rsa_aes加密
        //$str=(new RsaAes())->encrypt($str);

        //所有字符串转化成大写
        $str=strtoupper($str);

        return $str;
    }

    /*
     * 签名验证
     */
    public static function checkSign(array $data)
    {
        //aes解密
        $str=(new Aes())->decrypt($data['sign']);

        //rsa解密
        //$str=(new Rsa())->decrypt($data['sign']);

        //rsa_aes解密
        //$str=(new RsaAes())->decrypt($data['sign']);

        if(empty($str)){
            return false;
        }

        parse_str($str,$arr);

        if(!is_array($arr) || empty($arr) || $arr['type'] != $data['type']){
            return false;
        }

        //请求有效期
        if((time()-abs(ceil($arr['time']/1000)))>config('app.app_sign_time')){
            return false;
        }

        //唯一性判定
        if(Cache::get($data['sign'])){
            return false;
        }

        return true;
    }

    /*
     * 生成密码
     */
    public static function setPassword($data)
    {
        return md5($data.config('app.password_pre_halt'));
    }

    /*
     * 生成唯一Token
     */
    public static function setAppLoginToken($phone='')
    {
        $str = md5(uniqid(md5(strtotime(true)),true));
        $str = sha1($str.$phone);

        return $str;
    }
}