<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\phpstudy\WWW\TP_new\public/../application/admin\view\login\index.html";i:1491376146;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">	
	<title>登录</title>
	<!-- <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="images/favicon.ico" type="image/x-icon"> -->
	<!-- Bootstrap CSS -->

	<link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/css/material.css">
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/css/style.css">
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/css/signin2.css">	
	
	<!-- custom scrollbar stylesheet -->	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
</head>
<body>

	<div class="flip-container">
		<div class="flipper">
			<div class="front">
				<!-- front content -->
				<div class="holder">
					<h1 class="heading">登录</h1>
					<input name="username" class="form-control" type="text" placeholder="请输入用户名">
					<input name="password" type="password" class="form-control" placeholder="请输入密码">
					<div class="bottom_info">
						<a href="#" class="pull-right" data-toggle="modal" data-target="#forgot">忘记密码？</a>
						<a href="signup2.html" class="pull-left"> 注册</a>
					</div>		
					<div class="clearfix"></div>
					<a href="" class="btn btn-primary btn-block">登录</a>
				</div>
			</div>			
		</div>		
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="forgot" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><i class="ion-android-settings"></i> 重置密码</h4>
				</div>
				<div class="modal-body">
					<div class="col-sm-12">
						<input type="text" class="form-control" placeholder="请输入你的邮箱">
						<h6 class="note"><i class="ion-android-mail"></i> 密码将发到你的邮箱 </h6>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-red" data-dismiss="modal">关闭</button>
					<button type="button" class="btn btn-primary">发送</button>
				</div>
			</div>
		</div>
	</div>
	<!-- modal -->
	<script src="__PUBLIC__/admin/js/jquery.js"></script>
	<script src="__PUBLIC__/admin/js/bootstrap.min.js"></script>	
</body>
</html>