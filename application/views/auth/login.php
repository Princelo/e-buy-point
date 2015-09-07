<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <!-- Custom Theme files -->
    <link href="<?=CSS_URL?>login_style.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- Custom Theme files -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="M平台" />
    <title>M平台积分平台 - 登录</title>
    <!--<link href="includes/css/style_login.css" rel="stylesheet" type="text/css"/>-->
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
        if("<?=$csrf['hash']?>" != getCookie('<?=$csrf['cookie_name']?>'))
            location.reload();
        var checkSubmit = function() {
            if(document.getElementById('username').value == '') {
                alert('用户名不能为空');
            } else if( document.getElementById('password').value == '' ) {
                alert('密码不能为空');
            } else {
                document.getElementById('frm').submit();
            }
        }
    </script>
    <script type="text/javascript" src="http://libs.baidu.com/jquery.1.8.0.min.js"></script>
    <!--
    <script type="text/javascript" src="http://202.155.230.91:4280/includes/js/jquery-ui-1.10.2/ui/jquery-ui.js"></script>
    <link type="text/css" rel="stylesheet" href="http://202.155.230.91:4280/includes/js/jquery-ui-1.10.2/themes/base/jquery.ui.all.css" />

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script language="javascript">google.load("jquery", "1.7.1"); </script>
    -->
</head>
<body>
<!--header start here-->
<div class="login">
    <div class="login-main">
        <div class="login-top">
            <form action="<?=site_url('auth/login')?>" method="post">
                <ul style="margin-top: 0">
                    <!--<li><a class="fa" href="#"> </a></li>
                    <li><a class="tw" href="#"> </a></li>
                    <li><a class="g" href="#"> </a></li>-->
                    <li><a class="logo-change"></a></li>
                </ul>
            <h1><span class="anc-color">欢迎登录</span> M平台 <span class="anc-color">商家管理系统</span> </h1>
                <img src="<?=IMAGES_URL?>house.png" alt=""/>
            <h3 style="margin-top:16px;">&nbsp;登录&nbsp;</h3>
            <input type="text" name="user_name" placeholder="登入帐号" required="">
            <input type="password" name="user_pwd" placeholder="密码" required="">
            <div class="login-bottom">
                <div class="login-check">
                    <label class="checkbox"><input type="checkbox" name="checkbox" checked><i> </i> 记住登录状态</label>
                </div>
                <div class="login-para" style="display: none;">
                    <p><a href="#"> 忘记密码？ </a></p>
                </div>
                <div class="clear"> </div>
            </div>
            <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
            <input type="submit" value="登录" />
            <h4 style="display: none;">还没有帐号？ <a href="#"> 立即注册 </a></h4>
            </form>
        </div>
    </div>
</div>
<div class="copyright">
    <p> Copyright 几何营销策划公司 2015 </p>
</div>
<!--header end here-->
</body>
</html>
