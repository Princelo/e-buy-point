<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=isset($title)?$title:"M平台商家管理系统"?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=ASSETS_BOWER?>bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?=ASSETS_BOWER?>metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?=ASSETS_DIST?>css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=ASSETS_DIST?>css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?=ASSETS_BOWER?>morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=ASSETS_BOWER?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?=JS_URL?>html5shiv.js"></script>
    <script src="<?=JS_URL?>respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="<?=ASSETS_BOWER?>jquery/dist/jquery.min.js"></script>
    <script src="http://apps.bdimg.com/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="http://apps.bdimg.com/libs/jqueryui/1.9.2/themes/vader/jquery-ui.css">
    <script src="<?=JS_URL?>validator.js"></script>
    <script>
        function getCookie(c_name) {
            if (document.cookie.length > 0) {
                c_start = document.cookie.indexOf(c_name + "=");
                if (c_start != -1) {
                    c_start = c_start + c_name.length + 1;
                    c_end = document.cookie.indexOf(";", c_start);
                    if (c_end == -1) {
                        c_end = document.cookie.length;
                    }
                    return unescape(document.cookie.substring(c_start, c_end));
                }
            }
            return "";
        }
        <?php if (!empty($this->session->flashdata('flash_data')['message'])) : ?>
        alert('<?=$this->session->flashdata('flash_data')['message'];?>')
        <?php endif ?>

    </script>
</head>

<body>
<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html">欢迎来到M平台商家管理系统</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li style="display: none;"><a href="#"><i class="fa fa-user fa-fw"></i> 用户信息</a>
                    </li>
                    <li style="display: none;"><a href="<?=site_url('setting/change_password')?>"><i class="fa fa-gear fa-fw"></i> 设置</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="<?=site_url('auth/logout')?>"><i class="fa fa-sign-out fa-fw"></i> 退出登录</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search" style="display: none;">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <!-- /input-group -->
                    </li>
                    <li>
                        <a href="/"><i class="fa fa-dashboard fa-fw"></i> 系统首页</a>
                    </li>
                    <li>
                        <a href="<?=site_url('admin/store_index')?>"><i class="fa fa-bar-chart-o fa-fw"></i> 报表统计<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?=site_url('report/admin')?>">本月消费纪录</a>
                            </li>
                            <li>
                                <a href="<?=site_url('report/admin')?>">本月门店新增走势</a>
                            </li>
                            <li>
                                <a href="<?=site_url('report/admin')?>">本月会员新增走势</a>
                            </li>
                            <li>
                                <a href="<?=site_url('report/admin')?>">本月M平台收入走势</a>
                            </li>
                            <li>
                                <a href="<?=site_url('report/admin')?>">详细报表</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?=site_url('admin/store_index')?>"><i class="fa fa-table fa-fw"></i> 商家管理</a>
                    </li>
                    <li>
                        <a href="<?=site_url('admin/member_index')?>"><i class="fa fa-table fa-fw"></i> 会员管理</a>
                    </li>
                    <li>
                        <a href="<?=site_url('consumption/index')?>"><i class="fa fa-edit fa-fw"></i> 结算<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">结算操作</a>
                            </li>
                            <li>
                                <a href="#">结算纪录</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-wrench fa-fw"></i> 我的设置<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?=site_url('auth/logout')?>">退出登录</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

