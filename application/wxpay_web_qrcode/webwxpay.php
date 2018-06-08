<?php 

/**
 * @Author: 小尤
 * @Date:   2017-10-17
 * @note:   微信网页二维码支付示例
 * @from:   CSDN博客(江南极客:http://blog.csdn.net/sinat_35861727?viewmode=contents)
 */

//生成原始的二维码(不生成图片文件)  
function scerweima($url=''){  
    require_once 'phpqrcode.php';  
      
    $value = $url;                  //二维码内容  
    $errorCorrectionLevel = 'L';    //容错级别   
    $matrixPointSize = 8;           //生成图片大小    
    //生成二维码图片  
    $QR = QRcode::png($value,false,$errorCorrectionLevel, $matrixPointSize, 2);  
}

require_once "webwxpay.class.php";

$config = array(
	'appid'			=> 'wx123456789876',
	'mch_id'	 	=> '123456789',
	'pay_apikey' 	=> '123456789876123456789876123456789876'
);

$wxpay = new WxPay($config);
$result = $wxpay->paytest();
//print_r($result);
scerweima($result['code_url']);		//生成的支付二维码,用户可以扫码付款
?>

