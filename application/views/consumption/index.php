<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
    if("<?=$csrf['hash']?>" != getCookie('<?=$csrf_cookie_name?>'))
        location.reload();
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">消费录入</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-edit fa-fw"></i> 消费录入
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
                <form role="form" method="post" action="<?=$consumption_form_url?>" data-toggle="validator" id="consumption_form">
                    <div class="form-group">
                        <label>消费项目</label>
                        <input class="form-control" name="title" data-error="无效名称" required>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block with-errors"></span>
                        <span><?=form_error('title')?></span>
                        <p class="help-block">例：100元烟酒零售</p>
                    </div>
                    <div class="form-group">
                        <label>消费者会员手机号</label>
                        <input class="form-control" name="mobile" data-remote="<?=$consumer_validate_url?>" data-error="无效会员名或不存在该会员" required>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block with-errors"></span>
                        <span><?=form_error('mobile')?></span>
                        <p class="help-block">例：13477776677</p>
                    </div>
                    <div class="form-group" style="display: none;">
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
                        <label>交易类型</label>
                        <select name="exchange_type" class="form-control">
                            <option value="0" selected>现金交易</option>
                            <option value="1">扣除积分</option>
                        </select>
                        <div class="alert alert-warning" id="exchange_type_tip" style="display: none;">
                            注意：100积分等价于1元人民币
                        </div>
                        <script>
                            $('select[name="exchange_type"]').change(function(){
                                if($(this).val() == '1') {
                                    $('#exchange_type_tip').show();
                                    $('#exchange_cny').hide();
                                    $('#exchange_score').show();
                                }else{
                                    $('#exchange_type_tip').hide();
                                    $('#exchange_score').hide();
                                    $('#exchange_cny').show();
                                }
                            });
                        </script>
                    </div>
                    <div class="form-group" id="exchange_cny">
                        <label>消费金额</label>
                        <div class="input-group">
                            <span class="input-group-addon">￥</span>
                            <input type="text" class="form-control" name="volume" data-error="无效金额" pattern="(?=.)^\$?(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)?(\.[0-9]{1,2})?$" maxlength="15" required>
                            <span class="input-group-addon">元</span>
                        </div>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block with-errors"></span>
                        <span><?=form_error('volume')?></span>
                        <p class="help-block">例：97.8</p>
                    </div>
                    <div class="form-group" id="exchange_score" style="display: none;">
                        <label>消费积分</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="score" data-score="积分不足" data-error="积分格式错误或积分不足"  maxlength="15" required>
                            <span class="input-group-addon">分</span>
                        </div>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block with-errors"></span>
                        <span><?=form_error('score')?></span>
                        <p class="help-block">例：9780</p>
                    </div>
                    <div class="form-group">
                        <label>备注</label>
                        <textarea class="form-control" rows="3" name="remark" maxlength="63"></textarea>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>
                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    <input type="hidden" name="render_url" value="consumption/index" />
                    <button type="submit" class="btn btn-primary">提交</button>
                    <button type="reset" class="btn btn-danger" onclick="reset_event()">重新输入</button>
                    <script>
                        var reset_event = function() {
                            $('#exchange_type_tip').hide();
                            $('#exchange_score').hide();
                            $('#exchange_cny').show();
                        }
                    </script>
                </form>
                <script>
                    $('#consumption_form').validator();
                </script>
                <style>#consumption_form .has-success {position:relative;}</style>
                <style>#consumption_form .has-error {position:relative;}</style>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
        <!-- /.panel -->
    </div>
</div>
    </div>