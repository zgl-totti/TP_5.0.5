<?php
namespace app\common\lib;

class Aes
{
    private $aes_key;
    private $aes_iv;

    function __construct()
    {
        $this->aes_key = hash('sha256', config('app.key'), true);
        $this->aes_iv = config('app.key');
    }

    public function encrypt($str='')
    {
        $aes_iv=base64_encode(substr($this->aes_iv,0,16));
        $data=openssl_encrypt($str, 'AES-256-CBC',$this->aes_key,0,$aes_iv);
        $data=base64_encode($data);
        return $data;
    }

    public function decrypt($encrypt)
    {
        $encrypt = json_decode(base64_decode($encrypt), true);
        $iv = base64_decode($encrypt['iv']);
        $decrypt = openssl_decrypt($encrypt['value'], 'AES-256-CBC', $this->key, 0, $iv);
        $str = unserialize($decrypt);
        return $str ?? '';
    }

    public function sign()
    {
        $data['key']=$this->key;
        $data['iv']=$this->iv;
        $sign=openssl_sign($this->key,$this->iv,$this->key);
        return $sign;
    }
}