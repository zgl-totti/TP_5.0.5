<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:91:"F:\phpStudy-2018\PHPTutorial\WWW\TP_5.0.5\public/../application/admin\view\order\index.html";i:1522822870;s:92:"F:\phpStudy-2018\PHPTutorial\WWW\TP_5.0.5\public/../application/admin\view\layout\index.html";i:1504315535;s:91:"F:\phpStudy-2018\PHPTutorial\WWW\TP_5.0.5\public/../application/admin\view\public\left.html";i:1504315535;s:90:"F:\phpStudy-2018\PHPTutorial\WWW\TP_5.0.5\public/../application/admin\view\public\top.html";i:1504315535;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> <!--320-->
    <title>后台管理系统</title>

    <!-- <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon"> -->
    <!-- Bootstrap CSS -->

    <link rel='stylesheet' href='__STATIC__/admin/css/bootstrap.min.css'>
    <link rel='stylesheet' href='__STATIC__/admin/css/material.css'>
    <link rel='stylesheet' href='__STATIC__/admin/css/style.css'>
    <link rel='stylesheet' href='__STATIC__/admin/css/animated-masonry-gallery.css'>
    <link rel='stylesheet' href='__STATIC__/admin/css/rotated-gallery.css'>
    <link rel='stylesheet' href='__STATIC__/admin/css/sweet-alerts/sweetalert.css'>
    <link rel='stylesheet' href='__STATIC__/admin/css/jtree.css'>
    <script src='__STATIC__/admin/js/jquery.js'></script>
    <script src='__STATIC__/admin/js/app.js'></script>
    <script src='__STATIC__/admin/js/jquery-ui-1.10.3.custom.min.js'></script>
    <script src='__STATIC__/admin/js/bootstrap.min.js'></script>
    <script src='__STATIC__/admin/js/jquery.nicescroll.min.js'></script>
    <script src='__STATIC__/admin/js/wow.min.js'></script>
    <script src='__STATIC__/admin/js/jquery.loadmask.min.js'></script>
    <script src='__STATIC__/admin/js/jquery.accordion.js'></script>
    <script src='__STATIC__/admin/js/materialize.js'></script>
    <script src='__STATIC__/admin/js/chartist.min.js'></script>
    <script src='__STATIC__/admin/js/CustomChart.js'></script>
    <script src='__STATIC__/admin/js/build/d3.min.js'></script>
    <script src='__STATIC__/admin/js/nvd3/nv.d3.js'></script>
    <script src='__STATIC__/admin/js/sparkline.js'></script>
    <script src='__STATIC__/admin/js/bic_calendar.js'></script>
    <script src='__STATIC__/admin/js/widgets.js'></script>
    <script src='__STATIC__/admin/js/core.js'></script>
    <script src="__STATIC__/admin/js/jquery.countTo.js"></script>
    <script>
        jQuery(window).load(function () {
            $('.piluku-preloader').addClass('hidden');
        });
    </script>
</head>
<body>
    <div class="piluku-preloader text-center">
        <div class="loader">Loading...</div>
    </div>
    <div class="wrapper ">
        
<div class="left-bar ">
    <div class="admin-logo">
        <div class="logo-holder pull-left">
            <img class="logo" src="__STATIC__/admin/images/example.png" alt="logo">
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
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img class="flag_img" src="__STATIC__/admin/images/flags/india-flag.jpg" alt=""> English<span class="drop-icon"><i class="ion ion-chevron-down"></i></span>
                </a>
                <ul class="dropdown-menu dropdown-piluku-menu  animated fadeInUp wow language-drop neat_drop" data-wow-duration="1500ms" role="menu">
                    <li>
                        <a href="#"><img class="flag_img" src="__STATIC__/admin/images/flags/gm.gif" alt="flags"> German</a>
                    </li>
                    <li>
                        <a href="#"><img class="flag_img" src="__STATIC__/admin/images/flags/usa.png" alt="flags"> Spanish</a>
                    </li>
                    <li>
                        <a href="#"><img class="flag_img" src="__STATIC__/admin/images/flags/gm.gif" alt="flags"> german</a>
                    </li>
                    <li>
                        <a href="#"><img class="flag_img" src="__STATIC__/admin/images/flags/gm.gif" alt="flags"> german</a>
                    </li>
                </ul>
            </li>-->
            <li class="piluku-dropdown dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    <i class="ion-ios-bell-outline icon-notification"></i>
                    <span class="badge info-number message"><?php echo $num1; ?></span>
                </a>
                <ul class="dropdown-menu dropdown-piluku-menu  animated fadeInUp wow notification-drop neat_drop dropdown-right" data-wow-duration="1500ms" role="menu">
                    <li>
                        <a href="profile.html">
                            <div class="hexagon warning">
                                <span><i class="ion-ios-cart-outline"></i></span>
                            </div>
                            <span class="text_info"> 未付款订单</span>
                            <span class="flatOrangec counter" data-to="{orderinfo.num1}"></span>
                        </a>
                    </li>
                    <li>
                        <a href="profile.html">
                            <div class="hexagon danger">
                                <span><i class="ion-ios-alarm-outline"></i></span>
                            </div>
                            <span class="text_info"> 未发货订单</span>
                            <span class="flatRedc counter" data-to="{orderinfo.num2}"></span>
                        </a>
                    </li>
                    <li>
                        <a href="profile.html">
                            <div class="hexagon success">
                                <span><i class="ion-ios-body-outline"></i></span>
                            </div>
                            <span class="text_info"> 已发货订单</span>
                            <span class="flatGreenc counter" data-to="{orderinfo.num3}"></span>
                        </a>
                    </li>
                    <li>
                        <a href="profile.html">
                            <div class="hexagon info">
                                <span><i class="ion-ios-calendar-outline"></i></span>
                            </div>
                            <span class="text_info"> 已收货订单</span>
                            <span class="flatBluec counter" data-to="{orderinfo.num4}"></span>
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
                    <span class="badge info-number bell"><?php echo $num2; ?></span>
                </a>
                <ul class="dropdown-menu dropdown-piluku-menu  animated fadeInUp wow message_drop neat_drop dropdown-right" data-wow-duration="1500ms" role="menu">
                    <li>
                        <a href="#">
                            <div class="avatar_left"><img src="__STATIC__/admin/images/avatar/{val.avatar}" alt=""></div>
                            <div class="info_right">
                                <span class="text_head pull-left">{val.username}</span>
                                <span class="time_info pull-right">{date('Y-m-d H:i:s',val['time'])} <i class="online ion-record"></i></span>
                                <div class="text_info"> {val.title}</div>
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="piluku-dropdown dropdown">
                <!-- @todo Change design here, its bit of odd or not upto usable -->

                <a href="#" class="dropdown-toggle avatar_width" data-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="avatar-holder"><img src="__STATIC__/admin/images/avatar/<?php echo $info['avatar']; ?>" alt=""></span>
                    <span class="avatar_info"><?php echo $info['username']; ?></span>
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
                    <i class="ion-power"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>

            
	<!-- main content -->
	<div class="main-content">
		<div class="row">
			<div class="col-md-12">
				<!-- panel -->
				<div class="panel panel-piluku panel-users">
                    <div class="manage_buttons" style="margin: 0!important;margin-right: 0!important;">
                        <div class="row">
                            <div class="col-md-3 search">
                                <form action="<?php echo url('Order/index'); ?>" method="get">
                                    <input type="text" name="keywords" value="<?php echo !empty($keywrods)?$keywords:''; ?>" id="search" class="form-control" placeholder="Search User">
                                </form>
                            </div>
                            <div class="col-md-9">
                                <div class="buttons-list">
                                    <div class="pull-right-btn">
                                        <a href="#" id="export" class="btn btn-primary">EXECL导出</a>
                                        <div class="piluku-dropdown dropdown">
                                            <button type="button" class="btn btn-more dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <i class="ion-android-more-horizontal"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-regular-menu animated fadeInUp wow language-drop neat_drop" data-wow-duration="1500ms" role="menu">
                                                <li><a href="#">Link One</a></li>
                                                <li><a href="#">Link One</a></li>
                                                <li><a href="#">Link One</a></li>
                                                <li><a href="#">Link One</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="panel-heading">
						<h3 class="panel-title">
							订单列表
							<span class="panel-options">
								<a href="#" class="panel-refresh">
									<i class="icon ti-reload"></i> 
								</a>
								<a href="#" class="panel-minimize">
									<i class="icon ti-angle-up"></i> 
								</a>
								<a href="#" class="panel-close">
									<i class="icon ti-close"></i> 
								</a>
							</span>
						</h3>
					</div>
					<div class="panel-body nopadding">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th class="text-center">编号</th>
										<th class="text-center">订单号</th>
										<th class="text-center">用户名</th>
                                        <th class="text-center">价格</th>
                                        <th class="text-center">生成时间</th>
                                        <th class="text-center">订单状态</th>
                                        <th class="text-center">订单详情</th>
										<th class="text-center">操作</th>
									</tr>
								</thead>
								<tbody>
                                    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($k % 2 );++$k;?>
                                        <tr class="table-row">
                                            <td class="text-center"><?php echo $k+$firstRow; ?></td>
											<td class="text-center"><?php echo $val['orderno']; ?></td>
											<td class="text-center"><?php echo $val['users']['username']; ?></td>
                                            <td class="text-center"><?php echo $val['price']; ?></td>
                                            <td class="text-center"><?php echo date('Y-m-d H:i:s',$val['createtime']); ?></td>
                                            <td class="text-center"><?php echo $val['orderStatus']['statusname']; ?></td>
                                            <td class="text-center"><a href="<?php echo url('Order/detail',['id'=>$val['id']]); ?>">查看详情</a></td>
                                            <td class="text-center">
                                                <a href="#" id="<?php echo $val['id']; ?>" class="btn btn-orange"><i class="icon-bell"></i></a>
                                                <a href="<?php echo url('Order/edit',['id'=>$val['id']]); ?>" class="btn btn-green"><i class="ion ion-edit"></i></a>
                                                <a href="#" id="<?php echo $val['id']; ?> " class="btn btn-red"><i class="ion ion-ios-trash-outline"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
								</tbody>
							</table>
                            <?php echo $pages; ?>
						</div>
					</div>
				</div>
				<!-- /panel -->
			</div>
		</div>
	</div>
	<!-- /main content -->
    <script type="text/javascript">
        $(function () {
            $('#export').click(function () {
                var a=$('#search').val();
                location="<?php echo url('Order/export'); ?>?search="+a;
            })
        })
    </script>

        </div>
    </div>
</body>
</html>