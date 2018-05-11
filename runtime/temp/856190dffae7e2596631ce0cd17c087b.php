<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:91:"F:\phpStudy-2018\PHPTutorial\WWW\TP_5.0.5\public/../application/admin\view\index\index.html";i:1504315535;s:92:"F:\phpStudy-2018\PHPTutorial\WWW\TP_5.0.5\public/../application/admin\view\layout\index.html";i:1504315535;s:91:"F:\phpStudy-2018\PHPTutorial\WWW\TP_5.0.5\public/../application/admin\view\public\left.html";i:1504315535;s:90:"F:\phpStudy-2018\PHPTutorial\WWW\TP_5.0.5\public/../application/admin\view\public\top.html";i:1504315535;}*/ ?>
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

            
<div class="main-content">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12 nopad-right">
            <div class="dashboard-stats">
                <div class="left">
                    <h3 class="flatBluec counter" data-to="7684" data-speed="4000">7684</h3>
                    <h4>Monthly User</h4>
                </div>
                <div class="right flatBlue">
                    <i class="ion ion-ios-heart-outline"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 nopad-right">
            <div class="dashboard-stats">
                <div class="left">
                    <h3 class="flatGreenc counter" data-to="6433" data-speed="4000">6433</h3>
                    <h4>peoples in circles</h4>
                </div>
                <div class="right flatGreen">
                    <i class="ion ion-ios-color-filter-outline"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 nopad-right">
            <div class="dashboard-stats">
                <div class="left">
                    <h3 class="flatRedc counter" data-to="4532" data-speed="4000">4532</h3>
                    <h4>monthly notifications</h4>
                </div>
                <div class="right flatRed">
                    <i class="ion ion-ios-alarm-outline"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12 nopad-right">
            <div class="dashboard-stats">
                <div class="left">
                    <h3 class="flatOrangec counter" data-to="345" data-speed="8000">345</h3>
                    <h4>monthly targets</h4>
                </div>
                <div class="right flatOrange">
                    <i class="ion ion-ios-analytics-outline"></i>
                </div>
            </div>
        </div>

        <div class="col-md-6 nopad-right">
            <!-- panel -->
            <div class="panel panel-piluku">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Monthly Earnings
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
                <div class="panel-body">
                    <div class="row main-chart-parent">
                        <div class="ct-chart ct-golden-section  chart-height" id="main_chart"></div>
                    </div>
                    <!-- /row -->
                </div>
            </div>
            <!-- /panel -->
        </div>
        <!-- col-md-6 -->

        <div class="col-md-6 nopad-right">
            <!-- panel -->
            <div class="panel panel-piluku">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Mail widget
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
                <div class="panel-body mail_widget">
                    <ul class="tabs">
                        <li class="tab col-md-3"><a href="#test12" class="active">Inbox</a>
                        </li>
                        <li class="tab col-md-3"><a href="#test13">Sent</a>
                        </li>
                        <li class="tab col-md-3"><a href="#test14">Important</a>
                        </li>
                        <li class="tab col-md-3"><a href="#test15">Personal</a>
                        </li>
                    </ul>
                    <div class="content-holder">
                        <div id="test12" class="col-md-12 no_padding">
                            <div class="mail_list">
                                <ul class="list-unstyled mails_holder">
                                    <li>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/two.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">Henry richards</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatRedc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Research have been going on the project will report the results asap in a few days.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/one.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">Hola fan</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatGreenc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Searching for the best cafe around ?? come to meet at given location.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/seven.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">Nemo</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatGreenc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Searching for the best cafe around ?? come to meet at given location.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/eight.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">Tupakula Vijay</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatGreenc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Searching for the best cafe around ?? come to meet at given location.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/nine.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">lucky</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatGreenc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Searching for the best cafe around ?? come to meet at given location.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/one.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">venky</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatGreenc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Searching for the best cafe around ?? come to meet at given location.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="test13" class="col-md-12 no_padding">
                            <div class="mail_list">
                                <ul class="list-unstyled mails_holder">
                                    <li>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/two.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">Mila kunis</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatRedc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Research have been going on the project will report the results asap in a few days.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/one.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">rescort</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatGreenc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Searching for the best cafe around ?? come to meet at given location.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/three.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">deal buzz</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatGreenc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Searching for the best cafe around ?? come to meet at given location.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/four.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">carlson</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatGreenc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Searching for the best cafe around ?? come to meet at given location.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/five.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">richie rich</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatGreenc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Searching for the best cafe around ?? come to meet at given location.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/one.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">Tupakula Vijay</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatGreenc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Searching for the best cafe around ?? come to meet at given location.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="test14" class="col-md-12 no_padding">
                            <div class="mail_list">
                                <ul class="list-unstyled mails_holder">
                                    <li>
                                        <a href="#">
                                            <div class="message_list_block starred">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/two.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">Henry richards</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatRedc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Research have been going on the project will report the results asap in a few days.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block starred">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/ten.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">Romeo roadie</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatRedc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>waiting for your approval, many pending verifications!!</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block starred">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/eight.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">Jonny</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatRedc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Help me urgent.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block starred">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/six.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">pretty</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatRedc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>login have been going on the project will report the results asap in a few days.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block starred">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/two.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">Henry richards</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatRedc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Research have been going on the project will report the results asap in a few days.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- mail_list -->
                        </div>
                        <div id="test15" class="col-md-12 no_padding">
                            <div class="mail_list">
                                <ul class="list-unstyled mails_holder">
                                    <li>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/two.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">Henry richards</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatRedc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Research have been going on the project will report the results asap in a few days.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/one.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">Hola fan</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatGreenc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Searching for the best cafe around ?? come to meet at given location.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/seven.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">Nemo</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatGreenc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Searching for the best cafe around ?? come to meet at given location.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/eight.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">Tupakula Vijay</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatGreenc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Searching for the best cafe around ?? come to meet at given location.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/nine.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">lucky</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatGreenc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Searching for the best cafe around ?? come to meet at given location.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="message_list_block">
                                                <div class="left">
                                                    <div class="avatar_holder">
                                                        <img src="__STATIC__/admin/images/avatar/one.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <span class="name">venky</span>
                                                    <div class="pull-right right_details">
                                                        <ul class="list-unstyled list-inline">
                                                            <li>12:30</li>
                                                            <li><i class="ion ion-record flatGreenc status"></i>
                                                            </li>
                                                            <li><i class="ion-android-attach"></i>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4>Searching for the best cafe around ?? come to meet at given location.</h4>
                                                </div>
                                                <!-- right -->
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- mail-list -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /panel -->
        </div>
        <!-- col-md-6 -->


        <div class="col-md-4 nopad-right">
            <div class="piluku-panel no-pad panel">
                <div class="sparkline-widget">
                    <div class="heading-info flatRed">
                        <p class="pull-left">Company development
                            <br>
                        </p>
                        <p class="pull-right right">4% <i class="ion-android-arrow-dropup flatGreenc"></i>
                        </p>
                    </div>
                    <div class="svg-holder flatRed">
                        <div class="line"></div>
                        <svg id="chart1" class="sparkline"></svg>
                    </div>
                    <div class="info-bottom">
                        <div class="col-md-6 left">
                            Monthly
                            <p class="flatRedc">4 percent</p>
                        </div>
                        <div class="col-md-6 right">
                            Profit
                            <p class="flatRedc">40%</p>
                        </div>
                    </div>
                </div>
                <!-- sparkline-widget -->
            </div>
            <!-- panel -->
        </div>
        <!-- col-md-6 -->

        <div class="col-md-4 nopad-right">
            <div class="piluku-panel no-pad panel">
                <div class="sparkline-widget">
                    <div class="heading-info flatGreen">
                        <p class="pull-left">Revenue Generation
                            <br>
                        </p>
                        <p class="pull-right right">4% <i class="ion-android-arrow-dropdown flatRedc"></i>
                        </p>
                    </div>
                    <div class="svg-holder flatGreen">
                        <div class="line"></div>
                        <svg id="chart2" class="sparkline"></svg>
                    </div>
                    <div class="info-bottom">
                        <div class="col-md-6 left">
                            Monthly
                            <p class="flatGreenc">5 sales</p>
                        </div>
                        <div class="col-md-6 right">
                            Profit
                            <p class="flatGreenc">80%</p>
                        </div>
                    </div>
                </div>
                <!-- sparkline-widget -->
            </div>
            <!-- panel -->
        </div>
        <!-- col-md-6 -->

        <div class="col-md-4 nopad-right">
            <div class="piluku-panel no-pad panel">
                <div class="sparkline-widget">
                    <div class="heading-info flatOrange">
                        <p class="pull-left">Tasks Management
                            <br>
                        </p>
                        <p class="pull-right right">9% <i class="ion-android-arrow-dropup flatGreenc"></i>
                        </p>
                    </div>
                    <div class="svg-holder flatOrange">
                        <div class="line"></div>
                        <svg id="chart3" class="sparkline"></svg>
                    </div>
                    <div class="info-bottom">
                        <div class="col-md-6 left">
                            Monthly
                            <p class="flatOrangec">80 Tasks</p>
                        </div>
                        <div class="col-md-6 right">
                            Status
                            <p class="flatOrangec">1245</p>
                        </div>
                    </div>
                </div>
                <!-- sparkline-widget -->
            </div>
            <!-- panel -->
        </div>
        <!-- col-md-6 -->

        <div class="col-md-4 nopad-right">
            <div class="piluku-panel no-pad panel">
                <div class="ios-profile-widget">
                    <div class="header_cover">
                        <div class="more"><a href="#"><i class="ion-more"></i></a>
                        </div>
                        <img src="__STATIC__/admin/images/avatar/one.png" alt="">
                        <h3>Henry Richards</h3>
                        <i class="ion ion-social-twitter"> @Richardloves</i>
                    </div>
                    <!-- cover -->
                    <ul class="list-inline interactive_btn">
                        <li>
                            <a href="#" class=""><i class="ion-ios-personadd-outline"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="ion-ios-heart-outline"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="ion-ios-chatboxes-outline"></i></a>
                        </li>
                    </ul>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="badge">200+</span>
                            Friends
                        </li>
                        <li class="list-group-item">
                            <span class="badge">1,400+</span>
                            Followers
                        </li>
                        <li class="list-group-item">
                            <span class="badge">3,700</span>
                            Posts
                        </li>
                        <li class="list-group-item">
                            <span class="badge">14</span>
                            Pokes
                        </li>
                    </ul>

                </div>
                <!-- ios-profile -->
            </div>
            <!-- panel -->
        </div>
        <!-- col-md-6 -->

        <div class="col-md-4 col-xs-12 nopad-right">
            <!-- panel -->
            <div class="panel panel-piluku">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Login
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
                <div class="panel-body no-padding">
                    <div class="piluku-login">
                        <div class="form-section">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" placeholder="Username">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-success btn-block"><strong>Log in</strong>
                            </button>
                        </div>
                        <p>Not a member ? <a href="">Signup now</a>
                        </p>
                        <div class="header">
                            <ul class="">
                                <li><a href="#" class="btn btn-radius facebook"><i class="fa fa-facebook"></i></a>
                                </li>
                                <li><a href="#" class="btn btn-radius twitter"><i class="fa fa-twitter"></i></a>
                                </li>
                                <li><a href="#" class="btn btn-radius google"><i class="fa fa-google-plus"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /panel -->
        </div>
        <!-- col-md-3 -->

        <div class="col-md-4 col-sm-6 col-xs-12 nopad-right">
            <!-- panel -->
            <div class="panel panel-piluku">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Monthly Earnings
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
                <div class="panel-body">
                    <div class="row small-bar-chart">
                        <div class="ct-chart ct-minor-seventh chart-height monthly-earning-chart" id="small_bar_chart"></div>
                        <ul class="list-unstyled  info_section list-inline">
                            <li>
                                <div class="circle flatBluec"></div>mobiles
                            </li>
                            <li>
                                <div class="circle flatBluec2"></div>Tabs
                            </li>
                            <li>
                                <div class="circle flatBluec3"></div>Laptops
                            </li>
                        </ul>
                        <ul class="market_info_holder list-unstyled">
                            <li>
                                <div class="col-md-4 market_info">
                                    <h2>Apple inc</h2>
                                    <div class="status flatRedc">101$ <i class="ion-arrow-down-b"></i>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="col-md-4 market_info">
                                    <h2>Sony inc</h2>
                                    <div class="status flatGreenc">306$ <i class="ion-arrow-up-b"></i>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="col-md-4 market_info">
                                    <h2>Htc inc</h2>
                                    <div class="status flatRedc">112$ <i class="ion-arrow-down-b"></i>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- /row -->
                </div>
            </div>
            <!-- /panel -->
        </div>
        <!-- col-md-3 -->

        <div class="col-md-4 col-sm-6 col-xs-12 nopad-right">
            <!-- panel -->
            <div class="panel panel-piluku">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Website visitors
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
                <div class="panel-body">
                    <div class="row small_pie_chart">
                        <ul class="tabs light-tab">
                            <li class="tab col-md-4"><a href="#market1" class="active">Graphical</a>
                            </li>
                            <li class="tab col-md-4"><a href="#market2">Progress</a>
                            </li>
                            <li class="tab col-md-4"><a href="#market3">Quote</a>
                            </li>
                        </ul>
                        <div class="content-holder">
                            <div id="market1" class="col-md-12 no_padding">
                                <div class="ct-chart ct-golden-section chart-height website-visits" id="small_pie_chart"></div>
                                <ul class="list-unstyled  info_section list-inline">
                                    <li>
                                        <i class="ion ion-record flatOrangec"></i> Motorola
                                    </li>
                                    <li>
                                        <i class="ion ion-record flatRedc"></i> Keen labs
                                    </li>
                                    <li>
                                        <i class="ion ion-record flatBluec"></i> Facebook
                                    </li>
                                </ul>
                            </div>
                            <div id="market2" class="col-md-12 no_padding">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">January Result
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 70%;">Feb Result
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">March Result
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">April Result
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 70%;">May Result
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 90%;">Present Result
                                    </div>
                                </div>
                            </div>
                            <div id="market3" class="col-md-12 no_padding">
                                <h4>Documented</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tempora at, aliquid porro, voluptate maiores fugiat? Tempore adipisci excepturi dolores provident doloremque, eum quis placeat, cupiditate laudantium ipsam atque repellendus, error.</p>
                            </div>
                        </div>
                    </div>
                    <!-- /row -->
                </div>
            </div>
            <!-- /panel -->
        </div>
        <!-- col-md-3 -->

        <div class="col-md-4 col-sm-6 col-xs-12 nopad-right">
            <div class="piluku-panel no-pad todo_widget panel">
                <div class="todo_heading">
                    <div class="left-icon">
                        <div class="ms-hover">
                            <input type="checkbox" class="mark-all" id="todo">
                            <label for="todo"><span></span></label>
                        </div>
                    </div>
                    Todo
                    <a href="#" class="right-icon">
                        <i class="ion-ios-bell"></i>
                    </a>
                </div>
                <ul class="list-group list-todo">
                    <li class="list-group-item">
                        <div class="ms-hover">
                            <input type="checkbox" class="mark-complete" id="todo1">
                            <label for="todo1"><span></span>Call Head branch</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="ms-hover">
                            <input type="checkbox" class="mark-complete" id="todo2">
                            <label for="todo2"><span></span>check the postings</label>
                        </div>
                        <div class="notification">
                            <i class="ion-ios-bell-outline"></i>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="ms-hover">
                            <input type="checkbox" class="mark-complete" id="todo3">
                            <label for="todo3"><span></span>Recharge the Battery</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="ms-hover">
                            <input type="checkbox" class="mark-complete" id="todo4">
                            <label for="todo4"><span></span>Jog for 30 minutes</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="ms-hover">
                            <input type="checkbox" class="mark-complete" id="todo5">
                            <label for="todo5"><span></span>Check for updates</label>
                        </div>
                        <div class="notification">
                            <i class="ion-ios-bell-outline"></i>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="ms-hover">
                            <input type="checkbox" class="mark-complete" id="todo6">
                            <label for="todo6"><span></span>call for tim</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="ms-hover">
                            <input type="checkbox" class="mark-complete" id="todo7">
                            <label for="todo7"><span></span>Fix bugs</label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="ms-hover">
                            <input type="checkbox" class="mark-complete" id="todo8">
                            <label for="todo8"><span></span>Send mail</label>
                        </div>
                    </li>
                    <li class="list-group-item add-to-input">
                        <input type="text" class="form-control" name="add_todo" id="add_todo" placeholder="Add new task here...">
                    </li>
                </ul>
            </div>
            <!-- panel -->
        </div>
        <!-- col-md-6 -->

        <div class="col-md-4 col-sm-6 col-xs-12 nopad-right">
            <div class="piluku-panel no-pad panel">
                <div class="piluku-music-player">
                    <div class="track-info">
                        <a href="#"><i class="fa fa-volume-up"></i></a>
                        <a href="#"><i class="fa fa-music pull-right"></i></a>
                        <h3>FAST &amp; FURIOUS</h3>
                        <p class="text-center">WE OWN IT</p>
                        <div class="track-time">
                            <p class="start-time">2:18</p>
                            <p class="end-time pull-right">4:16</p>
                        </div>
                    </div>
                    <div class="seek-bar">
                        <div class="progress">
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                            </div>
                        </div>
                    </div>
                    <div class="audio-controls">
                        <div class="control-buttons">
                            <ul>
                                <li><a href="#"><i class="ion ion-ios-rewind-outline"></i></a>
                                </li>
                                <li><a href="#"><i class="ion-ios-refresh-empty"></i></a>
                                </li>
                                <li><a href="#"><i class="ion ion-ios-play"></i></a>
                                </li>
                                <li><a href="#"><i class="ion-stop"></i></a>
                                </li>
                                <li><a href="#"><i class="ion ion-ios-fastforward-outline"></i></a>
                                </li>
                            </ul>
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="badge bg-danger">2:60</span>
                                Far from the sea
                            </li>
                            <li class="list-group-item">
                                <span class="badge bg-danger">3:12</span>
                                Let it be
                            </li>
                            <li class="list-group-item">
                                <span class="badge bg-danger">6:42</span>
                                See the shining lights
                            </li>
                            <li class="list-group-item">
                                <span class="badge bg-danger">1:00</span>
                                Act like you know
                            </li>
                            <li class="list-group-item">
                                <span class="badge bg-danger">2:06</span>
                                Happy angels dont be rude
                            </li>

                        </ul>
                    </div>
                </div>
                <!-- end of music player -->
            </div>
            <!-- panel -->
        </div>
        <!-- col-md-6 -->

    </div>
    <!-- row -->
</div>



        </div>
    </div>
</body>
</html>