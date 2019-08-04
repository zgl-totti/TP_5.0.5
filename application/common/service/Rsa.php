<?php

namespace app\common\service;

/*
 * RSA 加密/解密
 */
class Rsa
{
    private $public;//公钥

    private $private;//私钥

    function __construct()
    {
        $this->public=config('rsa.public');
        $this->private=config('rsa.private');
    }

    /*
     * 加密
     */
    public function encrypt($str='')
    {
        openssl_public_encrypt($str,$data,$this->public);
        $data=base64_encode($data);

        return $data;
    }

    /*
     * 解密
     */
    public function decrypt($str)
    {
        $str=base64_decode($str);
        openssl_private_decrypt($str,$data,$this->private);

        return $data;
    }
}