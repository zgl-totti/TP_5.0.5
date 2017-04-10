<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:70:"D:\phpstudy\WWW\TP_new\public/../application/admin\view\admin\add.html";i:1491553550;s:72:"D:\phpstudy\WWW\TP_new\public/../application/admin\view\Public\left.html";i:1491642240;s:71:"D:\phpstudy\WWW\TP_new\public/../application/admin\view\Public\top.html";i:1491641942;s:73:"D:\phpstudy\WWW\TP_new\public/../application/admin\view\Public\right.html";i:1491442894;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
    
    <title>添加管理员</title>
    
    <!-- <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon"> -->
    <!-- Bootstrap CSS -->
    
    <link rel='stylesheet' href='__PUBLIC__/admin/css/bootstrap.min.css'>
    <link rel='stylesheet' href='__PUBLIC__/admin/css/material.css'>
    <link rel='stylesheet' href='__PUBLIC__/admin/css/style.css'>
    
    <script src='__PUBLIC__/admin/js/jquery.js'></script>
    <script src='__PUBLIC__/admin/js/app.js'></script>
    <script>
        jQuery(window).load(function () {
            $('.piluku-preloader').addClass('hidden');
        });
        $(function(){
            $("select").click(function(){
                var flag = this.value;
                $("#avatar").attr("src",flag);
            });
            $('.btn-primary').click(function(){
                $('#form').submit();
            });
            $('#form').submit(function(){
                $.post("<?php echo url('Admin/add'); ?>",$('#form').serialize(),function(res){
                    if(res.status==1){
                        layer.msg(res.info,{icon:6},function(){
                            location="<?php echo url('Admin/index'); ?>";
                        });
                    }else{
                        layer.msg(res.info,{icon:5});
                    }
                })
            })
        })
    </script>
</head>
<body class="" >
  <div class="piluku-preloader text-center">
  <!-- <div class="progress">
      <div class="indeterminate"></div>
  </div> -->
  <div class="loader">Loading...</div>
</div>
<div class="wrapper ">


<div class="left-bar ">
    <div class="admin-logo">
        <div class="logo-holder pull-left">
            <img class="logo" src="__PUBLIC__/admin/images/example.png" alt="logo">
        </div>
        <!-- logo-holder -->
        <a href="#" class="menu-bar  pull-right"><i class="ti-menu"></i></a>
    </div>
    <!-- admin-logo -->
    <ul class="list-unstyled menu-parent" id="mainMenu">
        <li class='current'>
            <a href="<?php echo url('Index/index'); ?>" class="current waves-effect waves-light">
                <i class="icon ti-home"></i>
                <span class="text ">后台首页</span>
            </a>
        </li>
        <li class="submenu">
            <a class="waves-effect waves-light" href="#system">
                <i class="icon ti-briefcase"></i>
                <span class="text">系统管理</span>
                <i class="chevron ti-angle-right"></i>
            </a>
            <ul class="list-unstyled" id="system">
                <li><a href="<?php echo url('Admin/index'); ?>">管理员列表</a></li>
                <li><a href="<?php echo url('Admin/add'); ?>">添加管理员</a></li>
                <li><a href="<?php echo url('Admin/changeinfo'); ?>">个人信息修改</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a class="waves-effect waves-light" href="#menu">
                <i class="icon ti-layout"></i>
                <span class="text">菜单管理</span>
                <i class="chevron ti-angle-right"></i>
            </a>
            <ul class="list-unstyled" id="menu">
                <li><a href="">菜单列表</a></li>
                <li><a href="">添加菜单</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a class="waves-effect waves-light" href="#permission">
                <i class="icon ti-gift"></i>
                <span class="text">权限管理</span>
                <i class="chevron ti-angle-right"></i>
            </a>
            <ul class="list-unstyled" id="permission">
                <li><a href="">管理组列表</a></li>
                <li><a href="">添加管理组</a></li>
                <li><a href="">权限列表</a></li>
                <li><a href="">添加权限</a></li>
            </ul>
        </li>
        <!--<li>
            <a href="typography.html">
                <i class="icon ti-smallcap"></i>
                <span class="text">字体设置</span>
            </a>
        </li>-->

        <li class="submenu">
            <a class="waves-effect waves-light" href="#navigation">
                <i class="icon ti-layout-list-thumb"></i>
                <span class="text">导航管理</span>
                <i class="chevron ti-angle-right"></i>
            </a>
            <ul class="list-unstyled" id="navigation">
                <li><a href="#">导航列表</a></li>
                <li><a href="#">添加导航</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a class="waves-effect waves-light" href="#member">
                <i class="icon-user"></i>
                <span class="text">会员管理</span>
                <i class="chevron ti-angle-right"></i>
            </a>
            <ul class="list-unstyled" id="member">
                <li><a href="">会员列表</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a class="waves-effect waves-light" href="#mail">
                <i class="ion-android-mail"></i>
                <span class="text">信息管理</span>
                <i class="chevron ti-angle-right"></i>
            </a>
            <ul class="list-unstyled" id="mail">
                <li><a href="<?php echo url('Mail/index'); ?>">信息列表</a></li>
                <li><a href="">发送信息</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a class="waves-effect waves-light" href="#brand">
                <i class="icon ti-book"></i>
                <span class="text">品牌管理</span>
                <i class="chevron ti-angle-right"></i>
            </a>
            <ul class="list-unstyled" id="brand">
                <li><a href="">品牌列表</a></li>
                <li><a href="">添加品牌</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a class="waves-effect waves-light" href="#category">
                <i class="icon ti-layout-grid2"></i>
                <span class="text">分类管理</span>
                <i class="chevron ti-angle-right"></i>
            </a>
            <ul class="list-unstyled" id="category">
                <li><a href="">分类列表</a></li>
                <li><a href="">添加分类</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a class="waves-effect waves-light" href="#goods">
                <i class="icon-briefcase"></i>
                <span class="text">商品管理</span>
                <i class="chevron ti-angle-right"></i>
            </a>
            <ul class="list-unstyled" id="goods">
                <li><a href="">商品列表</a></li>
                <li><a href="">添加商品</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a class="waves-effect waves-light" href="#order">
                <i class="icon-bell"></i>
                <span class="text">订单管理</span>
                <i class="chevron ti-angle-right"></i>
            </a>
            <ul class="list-unstyled" id="order">
                <li><a href="<?php echo url('Order/index'); ?>">订单列表</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a class="waves-effect waves-light" href="#advertise">
                <i class="ion-cube"></i>
                <span class="text">广告管理</span>
                <i class="chevron ti-angle-right"></i>
            </a>
            <ul class="list-unstyled" id="advertise">
                <li><a href="">广告列表</a></li>
                <li><a href="">添加广告</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a class="waves-effect waves-light" href="#comment">
                <i class="ion-ios-pricetag"></i>
                <span class="text">评论管理</span>
                <i class="chevron ti-angle-right"></i>
            </a>
            <ul class="list-unstyled" id="comment">
                <li><a href="">评论列表</a></li>
                <li><a href="">添加评论</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a class="waves-effect waves-light" href="#activity">
                <i class="ion-social-snapchat-outline"></i>
                <span class="text">活动管理</span>
                <i class="chevron ti-angle-right"></i>
            </a>
            <ul class="list-unstyled" id="activity">
                <li><a href="">活动列表</a></li>
                <li><a href="">添加活动</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a class="waves-effect waves-light" href="#feedback">
                <i class="ion-ios-analytics"></i>
                <span class="text">反馈管理</span>
                <i class="chevron ti-angle-right"></i>
            </a>
            <ul class="list-unstyled" id="feedback">
                <li><a href="">反馈列表</a></li>
                <li><a href="">添加反馈</a></li>
            </ul>
        </li>
        <li class="submenu">
            <a class="waves-effect waves-light" href="#bottom">
                <i class="icon ti-bar-chart-alt"></i>
                <span class="text">底部管理</span>
                <i class="chevron ti-angle-right"></i>
            </a>
            <ul class="list-unstyled" id="bottom">
                <li><a href="">底部列表</a></li>
                <li><a href="">添加底部</a></li>
            </ul>
        </li>
    </ul>
</div>
<!-- left-bar -->

<div class="content" id="content">
	
	<div class="overlay"></div>

    
<div class="top-bar">
	<nav class="navbar navbar-default top-bar">
		<div class="menu-bar-mobile" id="open-left"><i class="ti-menu"></i>
		</div>

		<!--<form class="navbar-left" role="search">
			<div class="search">
				<input type="text" class="form-control" name="keywords" placeholder="搜索...">
			</div>
		</form>-->
		<ul class="nav navbar-nav navbar-right top-elements">
			<!--<li class="piluku-dropdown dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img class="flag_img" src="__PUBLIC__/admin/images/flags/india-flag.jpg" alt=""> English<span class="drop-icon"><i class="ion ion-chevron-down"></i></span>
				</a>
				<ul class="dropdown-menu dropdown-piluku-menu  animated fadeInUp wow language-drop neat_drop" data-wow-duration="1500ms" role="menu">
					<li>
						<a href="#"><img class="flag_img" src="__PUBLIC__/admin/images/flags/gm.gif" alt="flags"> German</a>
					</li>
					<li>
						<a href="#"><img class="flag_img" src="__PUBLIC__/admin/images/flags/usa.png" alt="flags"> Spanish</a>
					</li>
					<li>
						<a href="#"><img class="flag_img" src="__PUBLIC__/admin/images/flags/gm.gif" alt="flags"> german</a>
					</li>
					<li>
						<a href="#"><img class="flag_img" src="__PUBLIC__/admin/images/flags/gm.gif" alt="flags"> german</a>
					</li>
				</ul>
			</li>-->
			<li class="piluku-dropdown dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    <i class="ion-ios-bell-outline icon-notification"></i>
                    <span class="badge info-number message"><?php echo $orderinfo['num2']; ?></span>
                </a>
				<ul class="dropdown-menu dropdown-piluku-menu  animated fadeInUp wow notification-drop neat_drop dropdown-right" data-wow-duration="1500ms" role="menu">
                    <li>
                        <a href="profile.html">
                            <div class="hexagon warning">
                                <span><i class="ion-ios-cart-outline"></i></span>
                            </div>
                            <span class="text_info"> 未付款订单</span>
                            <span class="flatOrangec counter" data-to="<?php echo $orderinfo['num1']; ?>"></span>
                        </a>
                    </li>
                    <li>
						<a href="profile.html">
							<div class="hexagon danger">
								<span><i class="ion-ios-alarm-outline"></i></span>
							</div>
							<span class="text_info"> 未发货订单</span>
							<span class="flatRedc counter" data-to="<?php echo $orderinfo['num2']; ?>"></span>
						</a>
					</li>
                    <li>
                        <a href="profile.html">
                            <div class="hexagon success">
                                <span><i class="ion-ios-body-outline"></i></span>
                            </div>
                            <span class="text_info"> 已发货订单</span>
                            <span class="flatGreenc counter" data-to="<?php echo $orderinfo['num3']; ?>"></span>
                        </a>
                    </li>
					<li>
						<a href="profile.html">
							<div class="hexagon info">
								<span><i class="ion-ios-calendar-outline"></i></span>
							</div>
							<span class="text_info"> 已收货订单</span>
							<span class="flatBluec counter" data-to="<?php echo $orderinfo['num4']; ?>"></span>
						</a>
					</li>
					<!--<li>
						<a href="profile.html">
							<div class="outline-hexagon">
								<span><i class="ion-ios-checkmark-outline"></i></span>
							</div>
							<span class="text_info"> Marked as complete</span>
							<span class="time_info">1:30pm</span>
						</a>
					</li>-->
					<li>
						<a href="profile.html" class="last_info">查看更多</a>
					</li>

				</ul>
			</li>
			<li class="piluku-dropdown dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    <i class="ion-ios-box-outline icon-notification"></i>
                    <span class="badge info-number bell"><?php echo count($mailinfo); ?></span>
                </a>
				<ul class="dropdown-menu dropdown-piluku-menu  animated fadeInUp wow message_drop neat_drop dropdown-right" data-wow-duration="1500ms" role="menu">
					<?php if(is_array($mailinfo) || $mailinfo instanceof \think\Collection || $mailinfo instanceof \think\Paginator): $i = 0; $__LIST__ = $mailinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?>
                        <li>
                            <a href="#">
                                <div class="avatar_left"><img src="__PUBLIC__/admin/images/avatar/<?php echo $val['avatar']; ?>" alt=""></div>
                                <div class="info_right">
                                    <span class="text_head pull-left"><?php echo $val['username']; ?></span>
                                    <span class="time_info pull-right"><?php echo date('Y-m-d H:i:s',$val['time']); ?> <i class="online ion-record"></i></span>
                                    <div class="text_info"> <?php echo $val['title']; ?></div>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
				</ul>
			</li>
			<li class="piluku-dropdown dropdown">
				<!-- @todo Change design here, its bit of odd or not upto usable -->

				<a href="#" class="dropdown-toggle avatar_width" data-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="avatar-holder"><img src="__PUBLIC__/admin/images/avatar/<?php echo $userinfo['avatar']; ?>" alt=""></span>
                    <span class="avatar_info"><?php echo $userinfo['username']; ?></span>
                    <span class="drop-icon"><!-- <i class="ion ion-chevron-down"></i> --></span>
                </a>
				<ul class="dropdown-menu dropdown-piluku-menu  animated fadeInUp wow avatar_drop neat_drop dropdown-right" data-wow-duration="1500ms" role="menu">
					<li>
						<a href="profile.html"> <i class="ion-android-settings"></i>设置</a>
					</li>
					<li>
						<a href="mailbox.html"> <i class="ion-android-chat"></i>信息</a>
					</li>
					<li>
						<a href="dropzone-file-upload.html"> <i class="ion-android-cloud-circle"></i>上传</a>
					</li>
					<li>
						<a href="profile.html"> <i class="ion-android-create"></i>编辑</a>
					</li>
					<li>
						<a href="lock-screen.html" class="logout_button"><i class="ion-power"></i>退出</a>
					</li>
				</ul>
			</li>
			<li class="chat_btn">
				<a href="#" class="right-bar-toggle flatRed">
					<i class="ion-ios-people-outline"></i>
				</a>
			</li>
		</ul>

	</nav>

</div>
    <!-- /top-bar -->

	<!-- main content -->
	<div class="main-content">
		<!-- *** Editable Tables *** -->
		<!-- panel -->
		<div class="panel panel-piluku">
			<div class="panel-heading">
				<h3 class="panel-title">
					添加管理员
				</h3>
			</div>
			<div class="panel-body">
                <form action="#" id="form">
                    <table id="user" class="table table-bordered table-striped table-hover" style="margin-top:30px;">
                        <tbody>
                            <tr>
                                <td>用户名</td>
                                <td><input type="text" name="username" /></td>
                            </tr>
                            <tr>
                                <td>密码</td>
                                <td><input type="password" name="password" /></td>
                            </tr>
                            <tr>
                                <td>确认密码</td>
                                <td><input type="password" name="pwd" /></td>
                            </tr>
                            <tr>
                                <td>电话</td>
                                <td><input type="text" name="phone" /></td>
                            </tr>
                            <tr>
                                <td>身份</td>
                                <td>
                                    <select name="permission" style="width: 160px;height: 40px;">
                                        <option value="2">普通管理员</option>
                                        <option value="1">超级管理员</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>头像</td>
                                <td>
                                    <select name="avatar" style="width: 160px;height: 40px;">
                                        <option value="__PUBLIC__/admin/images/avatar/1.jpeg">1</option>
                                        <option value="__PUBLIC__/admin/images/avatar/2.png">2</option>
                                        <option value="__PUBLIC__/admin/images/avatar/3.png">3</option>
                                        <option value="__PUBLIC__/admin/images/avatar/4.png">4</option>
                                        <option value="__PUBLIC__/admin/images/avatar/5.png">5</option>
                                        <option value="__PUBLIC__/admin/images/avatar/6.png">6</option>
                                        <option value="__PUBLIC__/admin/images/avatar/7.png">7</option>
                                        <option value="__PUBLIC__/admin/images/avatar/8.png">8</option>
                                        <option value="__PUBLIC__/admin/images/avatar/9.png">9</option>
                                        <option value="__PUBLIC__/admin/images/avatar/10.png">10</option>
                                        <option value="__PUBLIC__/admin/images/avatar/11.png">11</option>
                                    </select>
                                    <img src="__PUBLIC__/admin/images/avatar/1.jpeg" id="avatar" style="width: 40px;border-radius: 50%">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-primary" style="font-weight:bold;margin: 50px auto">确定</button>
                </form>
            </div>
		</div>
		<!-- /panel -->

	</div>

</div>  

	
<div class="side-bar right-bar ">
    <div class="contacts">
        <div class="col col-md-12">
            <ul class="tabs">
                <li class="tab col-md-3"><a href="#test1" class="active">Chat</a></li>
                <li class="tab col-md-3"><a href="#test2">Settings</a></li>
                <li class="tab col-md-3"><a href="#test3">Messages</a></li>
            </ul>
        </div>
        <div class="content-holder">
            <div id="test1" class="col-md-12 no_padding">
                <div class="panel-body no_padding">
                    <div class="panel-group piluku-accordion piluku-accordion-two" id="accordionOne" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingModalOne">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionOne" href="#collapseModalOne" aria-expanded="true" aria-controls="collapseOne">
                                        Online <i class="chevron ti-angle-down"></i>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseModalOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body no_padding">
                                    <ul class="list-group contacts-list">
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/one.png" alt="">
                                                </div>
                                                <span class="name">Richards carlson</span>
                                                <i class="ion ion-record online"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/two.png" alt="">
                                                </div>
                                                <span class="name">Firing Arc</span>
                                                <i class="ion ion-record online"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/three.png" alt="">
                                                </div>
                                                <span class="name">strapzen</span>
                                                <i class="ion ion-record online"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/four.png" alt="">
                                                </div>
                                                <span class="name">Reeves</span>
                                                <i class="ion ion-record online"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/five.png" alt="">
                                                </div>
                                                <span class="name">Bootstrap Guru</span>
                                                <i class="ion ion-record online"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/six.png" alt="">
                                                </div>
                                                <span class="name">Carlson</span>
                                                <i class="ion ion-record online"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/seven.png" alt="">
                                                </div>
                                                <span class="name">Paris hilton</span>
                                                <i class="ion ion-record online"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/eight.png" alt="">
                                                </div>
                                                <span class="name">Henry Richards</span>
                                                <i class="ion ion-record online"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/nine.png" alt="">
                                                </div>
                                                <span class="name">Richie Rich</span>
                                                <i class="ion ion-record online"></i>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingModalTwo">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordionOne" href="#collapseModalTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        offline
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseModalTwo" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingTwo">

                                <div class="panel-body no_padding">
                                    <ul class="list-group contacts-list">
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/one.png" alt="">
                                                </div>
                                                <span class="name">Richards carlson</span>
                                                <i class="ion ion-record offline"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/two.png" alt="">
                                                </div>
                                                <span class="name">Firing Arc</span>
                                                <i class="ion ion-record offline"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/three.png" alt="">
                                                </div>
                                                <span class="name">strapzen</span>
                                                <i class="ion ion-record offline"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/four.png" alt="">
                                                </div>
                                                <span class="name">Reeves</span>
                                                <i class="ion ion-record offline"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/five.png" alt="">
                                                </div>
                                                <span class="name">Bootstrap Guru</span>
                                                <i class="ion ion-record offline"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/six.png" alt="">
                                                </div>
                                                <span class="name">Carlson</span>
                                                <i class="ion ion-record offline"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/seven.png" alt="">
                                                </div>
                                                <span class="name">Paris hilton</span>
                                                <i class="ion ion-record offline"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/eight.png" alt="">
                                                </div>
                                                <span class="name">Henry Richards</span>
                                                <i class="ion ion-record offline"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/nine.png" alt="">
                                                </div>
                                                <span class="name">Richie Rich</span>
                                                <i class="ion ion-record offline"></i>
                                            </a>
                                        </li>

                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingModalThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionOne" href="#collapseModalThree" aria-expanded="false" aria-controls="collapseThree">
                                        Away
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseModalThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body no_padding">
                                    <ul class="list-group contacts-list">
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/one.png" alt="">
                                                </div>
                                                <span class="name">Richards carlson</span>
                                                <i class="ion ion-record away"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/two.png" alt="">
                                                </div>
                                                <span class="name">Firing Arc</span>
                                                <i class="ion ion-record away"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/three.png" alt="">
                                                </div>
                                                <span class="name">strapzen</span>
                                                <i class="ion ion-record away"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/four.png" alt="">
                                                </div>
                                                <span class="name">Reeves</span>
                                                <i class="ion ion-record away"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/five.png" alt="">
                                                </div>
                                                <span class="name">Bootstrap Guru</span>
                                                <i class="ion ion-record away"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/six.png" alt="">
                                                </div>
                                                <span class="name">Carlson</span>
                                                <i class="ion ion-record away"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/seven.png" alt="">
                                                </div>
                                                <span class="name">Paris hilton</span>
                                                <i class="ion ion-record away"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/eight.png" alt="">
                                                </div>
                                                <span class="name">Henry Richards</span>
                                                <i class="ion ion-record away"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <a href="#">
                                                <div class="avatar">
                                                    <img src="__PUBLIC__/admin/images/avatar/nine.png" alt="">
                                                </div>
                                                <span class="name">Richie Rich</span>
                                                <i class="ion ion-record away"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="test2" class="col-md-12 no_padding">
                <br>
                <div class="form-group">
                    <div class="toggle-switch">
                        <label class="col-sm-8 control-label">Reminders</label>
                        <div class="col-sm-4">
                            <input type="checkbox" class="mark-complete" id="toggle-switch" name="" value="" checked="">
                            <div class="toggle">
                                <label for="toggle-switch"><i></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="toggle-switch">
                        <label class="col-sm-8 control-label">theme options</label>
                        <div class="col-sm-4">
                            <input type="checkbox" class="mark-complete" id="toggle-switch1" name="" value="" checked="">
                            <div class="toggle">
                                <label for="toggle-switch1"><i></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="toggle-switch">
                        <label class="col-sm-8 control-label">dark / light theme</label>
                        <div class="col-sm-4">
                            <input type="checkbox" class="mark-complete" id="toggle-switch2" name="" value="" checked="">
                            <div class="toggle">
                                <label for="toggle-switch2"><i></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="toggle-switch">
                        <label class="col-sm-8 control-label">Email Updates</label>
                        <div class="col-sm-4">
                            <input type="checkbox" class="mark-complete" id="toggle-switch3" name="" value="" checked="">
                            <div class="toggle">
                                <label for="toggle-switch3"><i></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="toggle-switch">
                        <label class="col-sm-8 control-label">Notifications</label>
                        <div class="col-sm-4">
                            <input type="checkbox" class="mark-complete" id="toggle-switch4" name="" value="" checked="">
                            <div class="toggle">
                                <label for="toggle-switch4"><i></i>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group check-radio">
                        <label class="col-sm-9 control-label">Loader animation</label>
                        <div class="col-sm-3">
                            <ul class="list-inline checkboxes-radio">
                                <li class="ms-hover">
                                    <input type="checkbox" class="mark-complete" id="c1">
                                    <label for="c1"><span></span></label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group check-radio">
                        <label class="col-sm-9 control-label">delay load</label>
                        <div class="col-sm-3">
                            <ul class="list-inline checkboxes-radio">
                                <li class="ms-hover">
                                    <input type="checkbox" class="mark-complete" id="c2">
                                    <label for="c2"><span></span></label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group check-radio">
                        <label class="col-sm-9 control-label">Graphs animations</label>
                        <div class="col-sm-3">
                            <ul class="list-inline checkboxes-radio">
                                <li class="ms-hover">
                                    <input type="checkbox" class="mark-complete" id="c3" checked="">
                                    <label for="c3"><span></span></label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="test3" class="col-md-12 no_padding">
                <div class="heading no_border_bottom">
                    Todays
                    <div class="left"><a href="#"><i class="ion-android-refresh"></i></a></div>
                    <div class="right"><a href="#"><i class="ion-gear-a"></i></a></div>
                </div>
                <div class="list-group message-list">
                    <a href="#" class="list-group-item">
                        <h4 class="list-group-item-heading">henry richards</h4>
                        <p class="list-group-item-text">has pushed all the code to github and saved some fixes too..</p>
                    </a>
                    <a href="#" class="list-group-item">
                        <h4 class="list-group-item-heading">mary </h4>
                        <p class="list-group-item-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto accusamus officiis vero magnam amet, quas corru</p>
                    </a>
                </div>
                <div class="heading no_border_bottom">
                    june 15 1990
                    <div class="left"><a href="#"><i class="ion-android-refresh"></i></a></div>
                    <div class="right"><a href="#"><i class="ion-gear-a"></i></a></div>
                </div>
                <div class="list-group message-list">
                    <a href="#" class="list-group-item">
                        <h4 class="list-group-item-heading">henry richards</h4>
                        <p class="list-group-item-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto accusamus officiis vero magnam amet, quas corru</p>
                    </a>
                    <a href="#" class="list-group-item">
                        <h4 class="list-group-item-heading">mary </h4>
                        <p class="list-group-item-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto accusamus officiis vero magnam amet, quas corru</p>
                    </a>
                </div>
            </div>
        </div>
        <!-- content_holder -->
    </div>
</div>
	<!-- /Right-bar -->
</div>
<!-- wrapper -->

<script src='__PUBLIC__/admin/js/jquery-ui-1.10.3.custom.min.js'></script>
<script src='__PUBLIC__/admin/js/bootstrap.min.js'></script>
<script src='__PUBLIC__/admin/js/jquery.nicescroll.min.js'></script>
<script src='__PUBLIC__/admin/js/wow.min.js'></script>
<script src='__PUBLIC__/admin/js/jquery.loadmask.min.js'></script>
<script src='__PUBLIC__/admin/js/jquery.accordion.js'></script>
<script src='__PUBLIC__/admin/js/materialize.js'></script>
<script src='__PUBLIC__/admin/js/bic_calendar.js'></script>
<script src='__PUBLIC__/admin/js/bootstrap-editable.min.js'></script>
<script src='__PUBLIC__/admin/js/jquery.listarea.js'></script>
<script src='__PUBLIC__/admin/js/editable-tables.js'></script>
<script src='__PUBLIC__/admin/js/core.js'></script>

<script src="__PUBLIC__/admin/js/jquery.countTo.js"></script>
</body>
</html>