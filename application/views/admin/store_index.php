<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">商家列表</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-edit fa-fw"></i> 商家列表
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
                    <?if(count($store_list)==0){?>
                        <div class="alert alert-warning">
                            当前没有商家
                        </div>
                    <?}?>
                    <table class="table table-striped table-bordered table-hover dataTable no-footer" <?if(count($store_list)==0){?>style="display:none;"<?}?>>
                        <thead>
                        <tr>
                            <th>商家</th>
                            <th>管理帐号</th>
                            <th>佣金</th>
                            <th>下级数</th>
                            <th>消费纪录</th>
                            <th>下级消费纪录</th>
                            <th>佣金比</th>
                            <th>结算</th>
                            <th>结算日志</th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($store_list as $l) { ?>
                            <tr>
                                <td><?=$l->name?></td>
                                <td><?=$l->account?></td>
                                <td><?=bcdiv($l->return_profit, 100, 0)?></td>
                                <td><?=$l->sub_count?></td>
                                <td><a href="#">查看</a></td>
                                <td><a href="#">查看</a></td>
                                <td><?=$l->consumption_ratio?>%</td>
                                <td><a href="#">结算</a></td>
                                <td><a href="#">查看</a></td>
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