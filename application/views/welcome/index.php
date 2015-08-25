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
                <h1 class="page-header">系统首页</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <!--<div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">26</div>
                                <div>New Comments!</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>-->
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="">消费录入</div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <a href="<?=site_url('consumption/index')?>">
                        <div class="panel-footer">
                            <span class="pull-left">进入</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="">注册下级会员</div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <a href="<?=site_url('member/index')?>">
                        <div class="panel-footer">
                            <span class="pull-left">进入</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" style="display: none;">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-shopping-cart fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">124</div>
                                <div>New Orders!</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-support fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="">本店消费纪录</div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    <a href="<?=site_url('report/local_consume_log')?>">
                        <div class="panel-footer">
                            <span class="pull-left">进入</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row" style="display: block;">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        我的信息
                        <div class="pull-right" style="display: ;">
                            <div class="btn-group">
                                <a href="<?=site_url('setting/index')?>">修改信息</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <h4>
                            <?=$auth_data->name?>
                        </h4>
                        <h4>联系信息</h4>
                        <address>
                            <?=$auth_data->address?>
                            <br>
                            <abbr title="Phone">电话:</abbr><?=$auth_data->tel?>
                        </address>
                        <address>
                            <strong><?=$auth_data->contact?></strong>
                        </address>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-edit fa-fw"></i> 下级最近消费纪录
                        <div class="pull-right" style="display: ;">
                            <div class="btn-group">
                                <a href="<?=site_url('report/sub_member_action')?>">查看更多</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <?if(count($action_logs)==0){?>
                            <div class="alert alert-warning">
                                当前您的下级会员没有消费纪录
                            </div>
                        <?}?>
                        <table class="table table-striped table-bordered table-hover dataTable no-footer" <?if(count($action_logs)==0){?>style="display:none;"<?}?>>
                            <thead>
                            <tr>
                                <th>消费录入日期</th>
                                <th>消费事件</th>
                                <th>备注</th>
                                <th>会员</th>
                                <th>金额</th>
                                <th>本店所得佣金</th>
                                <th>消费店舖</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? foreach ($action_logs as $l) { ?>
                                <tr>
                                    <td><?=$l->time?></td>
                                    <td><?=$l->title?></td>
                                    <td><?=$l->remark?></td>
                                    <td><?=$l->consumer_name?></td>
                                    <td>￥<?=$l->volume?>元</td>
                                    <td>￥<?=bcmul(bcmul($l->volume, $l->ratio, 4), 0.002, 2)?>元</td>
                                    <td><?=$l->name?></td>
                                </tr>
                            <?}?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
                <!-- /.panel -->
            </div>
        <div class="row" style="display: none;">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-edit fa-fw"></i> 消费录入 - 快捷功能
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
        <!-- /.row -->
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
