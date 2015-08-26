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
    <script src="<?=JS_URL?>jquery.dataTables.min.js"></script>
    <link href="<?=CSS_URL?>jquery.dataTables.min.css" rel="stylesheet">
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
    <script>
        $(document).ready(function() {
            $('.dataTable').DataTable( {
                "language": {
                    "lengthMenu": "每页显示 _MENU_ 条纪录",
                    "zeroRecords": "没有数据",
                    "info": "当前 第 _PAGE_ 页，共 _PAGES_ 页",
                    "infoEmpty": "没有数据",
                    "infoFiltered": "(过滤总数为 _MAX_ 纪录)",
                    "paginate": {
                        "first":      "首页",
                        "last":       "尾页",
                        "next":       "下一页",
                        "previous":   "上一页"
                    },
                    "search": "搜索："
                }
            } );
        } );
    </script>
</head>

<body>
<div id="wrapper">


