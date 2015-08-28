<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">业务列表</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-edit fa-fw"></i> 业务列表
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
                    <?if(count($seller_list)==0){?>
                        <div class="alert alert-warning">
                            当前没有业务
                        </div>
                    <?}?>
                    <table class="table table-striped table-bordered table-hover dataTable no-footer" <?if(count($seller_list)==0){?>style="display:none;"<?}?>>
                        <thead>
                        <tr>
                            <th>业务</th>
                            <th>积分</th>
                            <th>商家数</th>
                            <th>结算</th>
                            <th>结算日志</th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($seller_list as $l) { ?>
                            <tr>
                                <td><?=$l->user_name?></td>
                                <td><?=$l->return_profit?>分</td>
                                <td><?=$l->count?></td>
                                <td><a href="<?=site_url('admin/settle_seller_simple')?>?id=<?=$l->id?>" class="fancybox">结算</a></td>
                                <td><a href="<?=site_url('admin/settle_seller_log_simple')?>?id=<?=$l->id?>" class="fancybox">查看</a></td>
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
    </div>
</div>