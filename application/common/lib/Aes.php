<?php

namespace app\common\lib;

/*
 * AES 加密/解密
 */
class Aes
{
    private $aes_key;

    private $aes_iv;

    function __construct()
    {
        $this->aes_key = hash('sha256', config('app.aes_key'), true);
        $this->aes_iv = substr(md5(config('app.aes_key')),0,16);
    }

    /*
     * 加密
     */
    public function encrypt($str='')
    {
        $data=openssl_encrypt($str,"AES-128-CBC",$this->aes_key,OPENSSL_RAW_DATA,$this->aes_iv);
        $data=base64_encode($data);

        return $data;
    }

    /*
     * 解密
     */
    public function decrypt($str)
    {
        $str=base64_decode($str);
        $data=openssl_decrypt($str,"AES-128-CBC",$this->aes_key,OPENSSL_RAW_DATA,$this->aes_iv);

        return $data;
    }
}