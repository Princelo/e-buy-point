<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>乐时网积分平台 - 登录</title>
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
    <style>
        body{font-size:14px;}
        .center{width: 274px; padding:40px;}
        .center{background-color: #f7f7f7;
            border-radius: 2px;
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);}
        .title{font-weight:bold; font-size:20px; height:83px; line-height:83px;}
        .type-button{padding-top:30px;}
        .type-button input{box-sizing: border-box;
            display: block;
            margin-bottom: 10px;
            position: relative;
            width: 100%;
            z-index: 1;
            font-family: Arial,sans-serif;
            font-size: 13px;
            background-color: #4d90fe;
            background-image: -moz-linear-gradient(center top , #4d90fe, #4787ed);
            border: 1px solid #3079ed;
            color: #fff;
            text-shadow: 0 1px rgba(0, 0, 0, 0.1);
            font-size:16px;
        }
        .center tr{height:25px;}
        fieldset{width:247px;}
        .textfield{width:234px;}
        .choose div{float:left; margin:0 auto; width:88px; margin-right:2px; background:#ddd; height:30px; line-height:30px;}
        .choose div:hover{background:#444; color:#fff; cursor:pointer;}
        .choose .selected{background:#444; color:#fff;}
        .choose{float:left;}
        .choose-block{width:270px; margin:0 auto; margin-bottom:50px}
        .info_msg{color:#f00;}
        body{font-family: "Microsoft Yahei" !important;}
        .google_textfield{
            -webkit-appearance: none;
            appearance: none;
            display: inline-block;
            height: 36px;
            padding: 0 8px;
            margin: 0;
            background: #fff;
            border: 1px solid #d9d9d9;
            border-top: 1px solid #c0c0c0;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            -moz-border-radius: 1px;
            -webkit-border-radius: 1px;
            border-radius: 1px;
            font-size: 15px;
            color: #404040;
            width: 100%;
            display: block;
            margin-bottom: 10px;
            z-index: 1;
            position: relative;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            direction: ltr;
            height: 44px;
            font-size: 16px;
            width:274px;
        }
        .google_email{
            margin-bottom:0;
        }
        .yform{
            width:274px;
        }
        .captcha{width:110px; display:inline-block;}
        .div-captcha img{float:right;}
        .type-button{padding-top: 0;}
        table{border-spacing: 0;}
        h1{color:#555; font-family: "Microsoft Yahei"; margin-bottom:15px; font-weight: normal !important; font-size: 38px !important;}
        h2{color:#555; font-family: "Microsoft Yahei"; margin-bottom:15px; font-weight: normal !important; font-size: 18px !important;}
    </style>
</head>
<body>

<script type="text/javascript" charset="utf-8">
</script>
<div class="page_margins">
    <div class="page">


        <!-- begin: main content area #main -->
        <div id="main">

            <!-- begin: #col5 static column -->
            <div id="col5" role="main" class="one_column">
                <div id="col5_content" class="clearfix"  align="center">


                    <!--<div style="background:url('includes/images/login_interface.jpg'); width:500px; height:300px;border:6px solid #fff">-->
                    <div>
                        <h1 class="title">欢迎来到乐时网积分平台</h1>
                        <h2 class="">使用您的帐号登陆</h2>
                        <p style="width:100%; text-align:center; color:#f00;">
                        </p>


                        <!-- begin: Login Form -->
                        <!--<div class="center" style="width:400px;padding-top:80px;">-->
                        <div class="center">



                            <div align="left">
                                <form action="<?=site_url('auth/login')?>" method="post" class="yform columnar" id="frm">


                                    <div style="width:113px; margin:0 auto; margin-bottom: 10px;">
                                        <img src="http://rege100.com/bundles/acmefrontend/css/images/photo.png" style="width:113px; margin:0 auto"/>
                                    </div>
                                    <input type="text" name="user_name" value="" id="username" class="google_textfield google_email" placeholder="登入帐号 "  />
                                    <input type="password" name="user_pwd" value="" id="password" class="google_textfield google_email" placeholder="密码 "  />

                                    <div class="info_msg" style="display:block; width:100%; height:20px;">
                                    </div>

                                    <div class="type-button" align="right">

                                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                                        <input type="button" name="btnSubmit" value="登入 "  onclick="checkSubmit()"/>										<input type="reset" value="重设 " class="reset" id="btnReset" name="btnReset" />
                                        <input type="hidden" value="" id="system" name="system" />
                                    </div>

                                </form>								</div>
                            <div align="" style="color:red;font-weight:bold">
                            </div>
                        </div>
                    </div>
                    <!-- end: Login Form -->



                </div>


            </div>
            <!-- IE Column Clearing -->
            <div id="ie_clearing">&nbsp;</div>
        </div>
        <!-- end: #col5 -->

    </div>
    <!-- end: #main -->
</div>
</div>
</body>
</html>
