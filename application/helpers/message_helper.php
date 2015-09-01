<?php
/**
 * Created by PhpStorm.
 * User: Princelo
 * Date: 8/27/15
 * Time: 04:41
 */
function showSuccess($message)
{
    echo "
    <div class=\"alert alert-success\">
                                {$message}
</div>
    ";
}

function showError($message)
{
    echo "
    <div class=\"alert alert-success\">
                                {$message}
</div>
    ";
}

function showErr($message, $jump)
{
    $str = <<<HTML
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="renderer" content="webkit">
    <!-- Force latest IE rendering engine or ChromeFrame if installed -->
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" charset="utf-8"><![endif]-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="refresh" content="3;URL={$jump}" />

    <title>M平台业务员管理系统</title>

    <!-- Bootstrap Core CSS -->
    <link href="/assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/assets/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="/assets/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/assets/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/assets/bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/assets/js/html5shiv.js"></script>
    <script src="/assets/js/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="/assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="http://apps.bdimg.com/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="http://apps.bdimg.com/libs/jqueryui/1.9.2/themes/vader/jquery-ui.css">
    <script src="/assets/js/validator.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <link href="/assets/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="/assets/js/jquery.browser.js"></script>
    <script src="/assets/js/jquery.fancybox.js"></script>
    <link href="/assets/css/jquery.fancybox.css" rel="stylesheet">
    <script src="/assets/js/jquery-birthday-picker.js"></script>
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
            $(".fancybox").fancybox({
                'width': '75%',
                'height'	: '75%',
                'autoScale'  : false,
                'transitionIn'  : 'none',
                'transitionOut'  : 'none',
                'type'  : 'iframe'
            });
            $("#birthdayPicker").birthdayPicker();
            $("input[name=bdate]").keydown(false);
        } );
    </script>
    <style>
    .success_box{  background: none repeat scroll 0 0 #fffce0;
  border: 1px solid #f9f0a2;
  padding: 55px;
  margin:10px;
  font-size:14px; }
.success_box h2{ font-size:16px; display:block; width:190px; height:55px; line-height:55px; margin:0px auto;}

.error_box{  background: none repeat scroll 0 0 #fffce0;
  border: 1px solid #f9f0a2;
  padding: 55px;
  margin:10px;
  font-size:14px; }
.error_box h2{ font-size:16px; display:block; width:190px; height:55px; line-height:55px; margin:0px auto;}

.msg_box span.tip{ display:inline-block; float:left; margin-left:10px;}
.msg_box .icon{ width:55px; height:55px; overflow:hidden; display:inline-block; position:relative; float:left;}
.msg_box .icon i{ background:url(/assets/images/op_icon.png) no-repeat; width:55px; height:110px; display:inline-block;
_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='../images/op_icon.png', sizingMethod='scale');
_background-image:none; position:absolute;}
.success_box i{ top:-55px; left:0px; }
.error_box i{ top:0px; left:0px; }
.msg_box{ padding:10px; text-align:center; }
.msg_box .notice{ text-align:center; display:block; font-size:14px; padding:20px; line-height:30px;}
.msg_box .notice a{ color:#4780c0; }
.msg_box .notice a:hover{ color:#f60; }
.msg_box a,.msg_box a:hover{ text-decoration:none;}
.msg_box span.tip{ display:inline-block; float:left; margin-left:10px;}
.msg_box .icon{ width:55px; height:55px; overflow:hidden; display:inline-block; position:relative; float:left;}
.msg_box .icon i{ background:url(/assets/images/op_icon.png) no-repeat; width:55px; height:110px; display:inline-block;
_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='../images/op_icon.png', sizingMethod='scale');
_background-image:none; position:absolute;}
.success_box i{ top:-55px; left:0px; }
.error_box i{ top:0px; left:0px; }
.msg_box span.tip{ display:inline-block; float:left; margin-left:10px;}
.msg_box .icon{ width:55px; height:55px; overflow:hidden; display:inline-block; position:relative; float:left;}
.msg_box .icon i{ background:url(/assets/images/op_icon.png) no-repeat; width:55px; height:110px; display:inline-block;
_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='../images/op_icon.png', sizingMethod='scale');
_background-image:none; position:absolute;}
.success_box i{ top:-55px; left:0px; }
.error_box i{ top:0px; left:0px; }
</style>
</head>

<body>
<div id="wrapper">
<div class="msg_box error_box">
							<h2>
								<div class="icon"><i></i></div>
							</h2>

							<div class="notice">
								<p>
								{$message}
								</p>
								<p>
								    如果页面没有跳转，点击此处<a href="{$jump}">链接</a>
								</p>
							</div>

</div>
</div>
HTML;
    echo $str;
    exit;

}
