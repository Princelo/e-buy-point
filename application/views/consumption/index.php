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
                        <label>消费名称</label>
                        <input class="form-control" name="title" data-error="无效名称" required>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block with-errors"></span>
                        <span><?=form_error('title')?></span>
                        <p class="help-block">例：100元烟酒零售</p>
                    </div>
                    <div class="form-group">
                        <label>消费者会员名</label>
                        <input class="form-control" name="consumer_name" data-remote="<?=$consumer_validate_url?>" data-error="无效会员名或不存在该会员" required>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block with-errors"></span>
                        <span><?=form_error('consumer_name')?></span>
                        <p class="help-block">例：小魚魚要減肥</p>
                    </div>
                    <div class="form-group">
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
                    <div class="form-group">
                        <label>备注</label>
                        <textarea class="form-control" rows="3" name="remark" maxlength="63"></textarea>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>
                    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    <input type="hidden" name="render_url" value="welcome/index" />
                    <button type="submit" class="btn btn-primary">提交</button>
                    <button type="reset" class="btn btn-danger">重新输入</button>
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