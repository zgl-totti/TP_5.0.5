<?php
namespace app\common\lib;

class Aes
{
    private $iv;
    private $key;

    function __construct()
    {
        $this->key = hash('sha256', config('app.key'), true);
        $this->iv = config('app.iv');
    }

    public function encrypt($str)
    {
        $data['iv']=base64_encode(substr($this->iv,0,16));
        $data['value']=openssl_encrypt($str, 'AES-256-CBC',$this->key,0,base64_decode($data['iv']));
        $encrypt=base64_encode(json_encode($data));
        return $encrypt;
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