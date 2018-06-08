/**
 * @Author: 江南极客
 * @Date:   2017-10-17
 * @note:   微信网页扫码支付/退款
 * @from:   CSDN博客(江南极客:http://blog.csdn.net/sinat_35861727?viewmode=contents)
 */

这里包含4个文件:
1.webwxpay.class.php  	支付的核心类文件(末尾附使用方法);
2.phpqrcode.php		PHP生成二维码的类文件(工具类,无需改动)
3.webwxpay.php		使用示例,将这几个文件放到自己服务器上,浏览器访问http://yourhost/webwxpay.php即可出现支付二维码
4.notify.php		支付回调验证文件,须将第23行签名函的时候用到的支付密钥改成自己的