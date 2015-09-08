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
                            <div class="">新增商家</div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <a href="<?=site_url('biz/index')?>">
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
                            <div class="">我的商家</div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <a href="<?=site_url('biz/sub_biz_list')?>">
                    <div class="panel-footer">
                        <span class="pull-left">进入</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    我的信息
                    <div class="pull-right" style="display: none;">
                        <div class="btn-group">
                            <a href="<?=site_url('setting/index')?>">修改信息</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <h2>
                        当前积分：<label style="color: #aa3e05;"><?=$auth_data->return_profit?> (<?=bcmul($auth_data->return_profit, 0.01, 2)?>元)</label>
                    </h2>
                    <h4>
                        <?=$auth_data->name?>
                    </h4>
                    <h4>帐号信息</h4>
                    <address>
                        <?=$auth_data->email?>
                        <br>
                        <abbr title="Phone">电话:</abbr><?=$auth_data->mobile?>
                    </address>
                    <label>注册日期: <?=$auth_data->create_time?></label>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
    <div class="row" style="display: block;">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-edit fa-fw"></i> 最近消费纪录
                    <div class="pull-right" style="display: ;">
                        <div class="btn-group" style="display: none;">
                            <a href="<?=site_url('report/member_action')?>">查看更多</a>
                        </div>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <?if(count($action_logs)==0){?>
                        <div class="alert alert-warning">
                            没有消费纪录
                        </div>
                    <?}?>
                    <table class="table table-striped table-bordered table-hover no-footer" <?if(count($action_logs)==0){?>style="display:none;"<?}?>>
                        <thead>
                        <tr>
                            <th>消费录入日期</th>
                            <th>消费项目</th>
                            <th>备注</th>
                            <th>会员帐号</th>
                            <th>消费金额</th>
                            <th>业务员积分</th>
                            <th>会员积分</th>
                            <th>消费店舖</th>
                            <th>所属商家</th>
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
                                <td><?=$l->sscore?>分</td>
                                <td><?=$l->uscore?>分</td>
                                <td><?=$l->name?></td>
                                <td><?=$l->invited?></td>
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
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
