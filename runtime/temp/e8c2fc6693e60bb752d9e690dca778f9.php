<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:91:"F:\phpStudy-2018\PHPTutorial\WWW\TP_5.0.5\public/../application/admin\view\login\index.html";i:1509330406;}*/ ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <title>登录</title>
	<!--<link rel="shortcut icon" href="__STATIC__/admin/images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="__STATIC__/admin/images/favicon.ico" type="image/x-icon">-->
	<link rel="stylesheet" type="text/css" href="__STATIC__/admin/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="__STATIC__/admin/css/material.css">
	<link rel="stylesheet" type="text/css" href="__STATIC__/admin/css/style.css">
	<link rel="stylesheet" type="text/css" href="__STATIC__/admin/css/signin2.css">

	<script type="text/javascript" src="__STATIC__/admin/js/jquery.js"></script>
    <script type="text/javascript" src="__STATIC__/layer/layer.js"></script>

    <script type="text/javascript">
        $(function(){
            $('.btn-block').click(function(){
                $.post("<?php echo url('Login/index'); ?>",$('form').serialize(),function(res){
                    if(res.status==1){
                        layer.msg(res.info,{icon:6},function(){
                            location="<?php echo url('Index/index'); ?>";
                        });
                    }else{
                        layer.msg(res.info,{icon:5});
                    }
                },'json')
            });
        })
    </script>
</head>
<body>

	<div class="flip-container">
		<div class="flipper">
			<div class="front">
				<div class="holder">
                    <form action="#">
                        <h1 class="heading">登录</h1>
                        <input name="username" class="form-control" type="text" placeholder="请输入用户名">
                        <input name="password" type="password" class="form-control" placeholder="请输入密码">
                        <input name="captcha" type="text" style="width:335px;display: inline-block;" class="form-control" placeholder="验证码" onclick="JavaScript:this.value=''"/>
                        <cite><img src="<?php echo captcha_src(); ?>" width="118" height="50" style="cursor:pointer;" onclick="this.src='<?php echo captcha_src(); ?>'"/></cite>
                        <div class="bottom_info">
                            <a href="#" class="pull-right" data-toggle="modal" data-target="#forgot">忘记密码？</a>
                            <a href="#" class="pull-left"> 注册</a>
                        </div>
                        <div class="clearfix"></div>
                        <a href="#" class="btn btn-primary btn-block">登录</a>
                    </form>
				</div>
			</div>			
		</div>		
	</div>

	<script src="__STATIC__/admin/js/jquery.js"></script>
	<script src="__STATIC__/admin/js/bootstrap.min.js"></script>	
</body>
</html>