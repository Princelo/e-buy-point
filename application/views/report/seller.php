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
            <h1 class="page-header">业务报表查询</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-edit fa-fw"></i> 业务报表查询
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
                    <form role="form" method="post" action="" data-toggle="validator" id="report_form">
                        <div class="form-group">
                            <label>报表类型</label>
                            <select class="form-control" name="type" id="type">
                                <option value="income_report">业务收入报表</option>
                                <option value="biz_report">邀请商家收入报表</option>
                                <option value="invite_report">邀请量走势</option>
                            </select>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('type')?></span>
                        </div>
                        <script>
                            $("#type").change(function(){
                               if($(this).val() == 'biz_report')
                                   $('#biz_filter').show();
                                else
                                   $('#biz_filter').hide();
                            });
                        </script>
                        <div class="form-group" style="display: none;" id="biz_filter">
                            <label>选择商家</label>
                            <select class="form-control" name="biz" id="biz" <? if(count($biz_list) == 0){echo "style=\"display:none;\"";} ?>>
                                <? foreach($biz_list as $v) {?>
                                    <option value="<?=$v->id?>"><?=$v->name?></option>
                                <? } ?>
                            </select>
                            <? if(count($biz_list) == 0){?>
                                <div class="alert alert-warning">
                                    目前您没有邀请任何商家
                                </div>
                            <? } ?>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('type')?></span>
                        </div>
                        <div class="form-group">
                            <label>起始年月</label>
                            <div class="form-group input-group">
                                <select class="form-control">
                                    <? for($i = 2015; $i <= intval(date('Y')); $i ++) { ?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                    <? } ?>
                                </select>
                                <span class="input-group-addon">年</span>
                            </div>
                            <div class="form-group input-group">
                                <select class="form-control">
                                    <? for($i = 1; $i <= 12; $i ++) { ?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                    <? } ?>
                                </select>
                                <span class="input-group-addon">月</span>
                            </div>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label>终止年月</label>
                            <div class="form-group input-group">
                                <select class="form-control">
                                    <? for($i = 2015; $i <= intval(date('Y')); $i ++) { ?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                    <? } ?>
                                </select>
                                <span class="input-group-addon">年</span>
                            </div>
                            <div class="form-group input-group">
                                <select class="form-control">
                                    <? for($i = 1; $i <= 12; $i ++) { ?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                    <? } ?>
                                </select>
                                <span class="input-group-addon">月</span>
                            </div>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                        </div>
                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                        <button type="button" class="btn btn-primary">提交</button>
                        <button type="reset" class="btn btn-danger">重新输入</button>
                    </form>
                    <script>
                        $('#report_form').validator({
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
                    <style>#report_form .has-success {position:relative;}</style>
                    <style>#report_form .has-error {position:relative;}</style>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
            <!-- /.panel -->
        </div>
    </div>
</div>