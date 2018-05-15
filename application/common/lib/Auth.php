<?php
namespace app\common\lib;

class Auth
{
    public static function setPassword($data)
    {
        return md5($data.config('app.password_pre_halt'));
    }

    /**
     * 生成sign
     * @param array $data
     * @return string
     */
    public static function setSign($data=[])
    {
        //按字段排序
        ksort($data);
        //拼接字符串数据
        $str=http_build_str($data);
        //通过aes加密
        $str=(new Aes())->encrypt($str);
        //所有字符串转化成大写
        $str=strtoupper($str);

        return $str;
    }

    public static function checkSign(array $data)
    {
        $str=(new Aes())->decrypt($data['sign']);

        if(empty($str)){
            return false;
        }

        parse_str($str,$arr);

        if(!is_array($arr) || $arr != config('app.aes_key')){
            return false;
        }

        /*if((time()-ceil($arr['time']/1000))>config('app.app_sign_time')){
            return false;
        }*/

        return true;
    }
}