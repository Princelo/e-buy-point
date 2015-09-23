<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
    if("<?=$csrf['hash']?>" != getCookie('<?=$csrf_cookie_name?>'))
        location.reload();
</script>
<div id="page-wrapper">
    <? if(!empty($this->session->flashdata('flash_data')['message'])):?>
    <div class="row">
    </div>
    <div class="row" style="margin-top: 20px;">
        <div class="alert <?=$this->session->flashdata('flash_data')['type']=='error'?"alert-danger":""?><?=$this->session->flashdata('flash_data')['type']=='success'?"alert-success":""?>">
            <?=$this->session->flashdata('flash_data')['message'];?>
        </div>
    </div>
    <? endif ?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">新增商家</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-edit fa-fw"></i> 新增商家
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
                    <form role="form" method="post" action="<?=$form_url?>" data-toggle="validator" id="biz_form">
                        <div class="form-group">
                            <label>商家名称</label>
                            <input class="form-control" name="name"  data-remote="<?=$bizname_validate_url?>" data-error="商家名称不正确或已存在" type="text" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('name')?></span>
                            <p class="help-block">例：金城广场苹果销售</p>
                        </div>
                        <div class="form-group">
                            <label>行业类型</label>
                            <select name="biz_type" class="form-control">
                                <?php foreach($biz_type_list as $v) {?>
                                    <option value="<?=$v->id?>"><?=$v->name?></option>
                                <?php } ?>
                            </select>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('biz_type')?></span>
                            <p class="help-block">请选择行业类型</p>
                        </div>
                        <div class="form-group">
                            <label>商家固话</label>
                            <input class="form-control" name="tel"  data-error="" type="text" data-maxlength="20" maxlength="20" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('tel')?></span>
                            <p class="help-block">例：020-80008000</p>
                        </div>
                        <div class="form-group">
                            <label>门店地址</label>
                            <input class="form-control" name="address"  data-error="" type="text" data-maxlength="100" maxlength="100" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('address')?></span>
                            <p class="help-block">例：新华街建设北路与秀全路交汇处</p>
                        </div>
                        <div class="form-group">
                            <label>返点率</label>
                            <div class="input-group">
                                <input class="form-control" name="consumption_ratio" data-error="无效返点率，取值为5%到100%，且为半角数字" type="number" min="5" max="100" required>
                                <span class="input-group-addon">%</span>
                            </div>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('consumption_ratio')?></span>
                            <p class="help-block">例：10</p>
                        </div>
                        <div class="form-group">
                            <label>联系人</label>
                            <input class="form-control" name="contact"  data-error="" type="text" maxlength="10" data-maxlength="10" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('contact')?></span>
                            <p class="help-block">例：何小姐</p>
                        </div>
                        <div class="form-group">
                            <label>电子邮箱</label>
                            <input class="form-control" name="email"  data-remote="<?=$email_validate_url?>" data-error="电子邮箱不正确或已存在" type="email" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('email')?></span>
                            <p class="help-block">例：foo@bar.com</p>
                        </div>
                        <div class="form-group">
                            <label>管理员用户名</label>
                            <input class="form-control" name="user_name" data-remote="<?=$username_validate_url?>" data-error="无效帐号名或已存在该帐号" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('user_name')?></span>
                            <p class="help-block">例：Example001</p>
                        </div>
                        <div class="form-group">
                            <label>管理员密码</label>
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
                            <input class="form-control" name="mobile" data-remote="<?=$mobile_validate_url?>" pattern="^1[0-9]{10}$" data-error="手机号码不正确或已存在" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('mobile')?></span>
                            <p class="help-block">例：13926262626</p>
                        </div>
                        <div class="form-group" style="display: none;">
                            <label>手机验证码</label>
                            <input class="form-control" name="verify_code" data-error="请填写手机验证码" required/>
                            <input class="btn btn-default" value="发送验证码" id="sms_sent_btn" onclick="sms_sent();" />
                        </div>
                        <div class="form-group">
                            <label>备注</label>
                            <input class="form-control" name="remark" data-error="" maxlength="50" />
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('remark')?></span>
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
                        $('#biz_form').validator({
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
                    <style>#biz_form .has-success {position:relative;}</style>
                    <style>#biz_form .has-error {position:relative;}</style>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
            <!-- /.panel -->
        </div>
    </div>
</div>