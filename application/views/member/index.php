<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
    if("<?=$csrf['hash']?>" != getCookie('<?=$csrf_cookie_name?>'))
        location.reload();
</script>
<style>
    select{
        display: inline-block;
        height: 20px;
        padding: 4px 6px;
        margin-bottom: 10px;
        font-size: 12px;
        line-height: 20px;
        color: #555555;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
        vertical-align: middle;
    }
    select, input[type="file"] {
        height: 30px;
        line-height: 30px;
    }
</style>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">新增会员</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-edit fa-fw"></i> 新增会员
                    <div class="pull-right" style="display: none;">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                Actions
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="#">Action</a>
                                </li>
                                <li><a href="#">Another action</a>
                                </li>
                                <li><a href="#">Something else here</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form role="form" method="post" action="<?=$member_form_url?>" data-toggle="validator" id="member_form">
                        <div class="form-group">
                            <label>电子邮箱</label>
                            <input class="form-control" name="email"  data-remote="<?=$member_email_validate_url?>" data-error="电子邮箱不正确或已存在" type="email" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('email')?></span>
                            <p class="help-block">例：foo@bar.com</p>
                        </div>
                        <div class="form-group">
                            <label>会员帐号</label>
                            <input class="form-control" name="user_name" data-remote="<?=$member_username_validate_url?>" data-error="无效会员名或已存在该会员" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('user_name')?></span>
                            <p class="help-block">例：Example001</p>
                        </div>
                        <div class="form-group">
                            <label>密码</label>
                            <input class="form-control" id="inputPassword" type="password" data-minlength="8" name="user_pwd" data-error="密码格式错误" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('user_pwd')?></span>
                            <p class="help-block">密码长度大于或等于8位</p>
                        </div>
                        <div class="form-group">
                            <label>确认密码</label>
                            <input class="form-control" type="password" data-match="#inputPassword" name="user_pwd_confirm" data-error="两次密码输入不相同" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('user_pwd_confirm')?></span>
                        </div>
                        <div class="form-group">
                            <label>手机号码</label>
                            <input class="form-control" name="mobile" data-remote="<?=$member_mobile_validate_url?>" pattern="^1[0-9]{10}$" data-error="手机号码不正确或已存在" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('mobile')?></span>
                            <p class="help-block">例：13926262626</p>
                        </div>
                        <div class="form-group">
                            <label>手机验证码</label>
                            <input class="form-control" name="verify_code" data-error="请填写手机验证码" required/>
                            <input class="btn btn-default" value="发送验证码" id="sms_sent_btn" onclick="sms_sent();" />
                        </div>
                        <script>
                            var sms_sent = function () {
                                var sms_url = "<?=$sms_url?>";
                                $('#sms_sent_btn').attr('disabled', 'disabled');
                                $.ajax({
                                    url: sms_url,
                                    type: "post",
                                    data: {
                                        "mobile": $("input[name='mobile']").val(),
                                        "<?=$csrf['name']?>": getCookie('<?=$csrf_cookie_name?>')
                                    },
                                    success: function (json) {
                                        json = eval("("+json+")");
                                        if (json.state == "error") {
                                            alert('短信息发送错误，请稍侯再试');
                                            console.log(json.message);
                                            $('#sms_sent_btn').removeAttr('disabled');
                                        }
                                        if (json.state == "success") {
                                            $('#sms_sent_btn').attr('disabled', 'disabled');
                                            countdown();
                                        }

                                    }
                                    });
                            }
                            var countdown = function () {
                                var timer = 60;
                                setInterval(function () {
                                    if (timer > 0) {
                                        $('#sms_sent_btn').val(timer+"秒后再次发送");
                                        timer --;
                                    } else {
                                        $('#sms_sent_btn').val("发送验证码");
                                        $('#sms_sent_btn').removeAttr('disabled');
                                    }
                                }, 1000);
                            }
                        </script>
                        <div class="form-group">
                            <label>性别</label>
                            <select class="form-control" name="gender">
                                <option value="1">男</option>
                                <option value="0">女</option>
                            </select>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('gender')?></span>
                        </div>
                        <div class="form-group">
                            <label>出生日期</label>
                            <div id="birthdayPicker"></div>
                            <!--<input class="form-control" name="bdate" data-date="出生日期不正确" data-error="出生日期不正确" required>-->
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('bdate')?></span>
                            <p class="help-block">例：1990-01-01</p>
                        </div>
                        <script>$("input[name='bdate']").datepicker({
                                'dateFormat': 'yy-m-d',
                                'changeYear' : true
                            });
                        </script>
                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                        <input type="hidden" name="render_url" value="welcome/index" />
                        <button type="submit" class="btn btn-primary">提交</button>
                        <button type="reset" class="btn btn-danger">重新输入</button>
                    </form>
                    <script>
                        $('#member_form').validator({
                            custom: {
                                date: function (input) {
                                    split = input.val().split('-');
                                    if (split.length !== 3)
                                        return false;
                                    y = split[0];
                                    m = split[1];
                                    d = split[2];
                                    //  discuss at: http://phpjs.org/functions/checkdate/
                                    // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
                                    // improved by: Pyerre
                                    // improved by: Theriault
                                    //   example 1: checkdate(12, 31, 2000);
                                    //   returns 1: true
                                    //   example 2: checkdate(2, 29, 2001);
                                    //   returns 2: false
                                    //   example 3: checkdate(3, 31, 2008);
                                    //   returns 3: true
                                    //   example 4: checkdate(1, 390, 2000);
                                    //   returns 4: false

                                    return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0))
                                            .getDate();

                                }
                            },
                            errors: {
                                date: "日期格式无效"
                            }
                        });
                    </script>
                    <style>#member_form .has-success {position:relative;}</style>
                    <style>#member_form .has-error {position:relative;}</style>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
            <!-- /.panel -->
        </div>
    </div>
</div>