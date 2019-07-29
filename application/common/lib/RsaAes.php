<?php

namespace app\common\lib;

/*
 * RSA及AES双重 加密/解密
 * RSA加密最大缺点：不能对大文本进行加密
 * 用RSA加密后获取的值,当做AES加密的加密key
 */
class RsaAes
{
    private $public;//公钥

    private $private;//私钥

    private $aes_key;

    private $aes_iv;

    function __construct()
    {
        $this->public=config('rsa.public');
        $this->private=config('rsa.private');
        $this->aes_key = hash('sha256', config('app.aes_key'), true);
        $this->aes_iv = substr(md5(config('app.aes_key')),0,16);
    }

    /*
     * 加密
     */
    public function encrypt($str='')
    {
        //用RSA加密获取AES加密的key和iv
        $key=$this->aes($this->aes_key);
        $iv=$this->aes($this->aes_iv);

        //用AES加密
        $data=openssl_encrypt($str,"AES-128-CBC",$key,OPENSSL_RAW_DATA,$iv);
        $data=base64_encode($data);

        return $data;
    }

    /*
     * 解密
     */
    public function decrypt($str)
    {
        //用RSA加密获取AES加密的key和iv
        $key=$this->aes($this->aes_key);
        $iv=$this->aes($this->aes_iv);

        //用AES解密
        $str=base64_decode($str);
        $data=openssl_decrypt($str,"AES-128-CBC",$key,OPENSSL_RAW_DATA,$iv);

        return $data;
    }

    /*
     * AES加密
     */
    private function aes($str)
    {
        openssl_public_encrypt($str,$data,$this->public);

        return base64_encode($data);
    }
}