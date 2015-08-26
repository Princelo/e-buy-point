<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">会员列表</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-edit fa-fw"></i> 会员列表
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
                    <?if(count($member_list)==0){?>
                        <div class="alert alert-warning">
                            当前没有会员
                        </div>
                    <?}?>
                    <table class="table table-striped table-bordered table-hover dataTable no-footer" <?if(count($member_list)==0){?>style="display:none;"<?}?>>
                        <thead>
                        <tr>
                            <th>会员</th>
                            <th>积分</th>
                            <th>上级</th>
                            <th>消费纪录</th>
                            <th>修改密码</th>
                            <!--<th>添加积分</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($member_list as $l) { ?>
                            <tr>
                                <td><?=$l->user_name?></td>
                                <td><?=$l->score?></td>
                                <td><?=$l->name?></td>
                                <td><a href="<?=site_url('report/member_consumption_simple')?>?id=<?=$l->id?>" class="fancybox">查看</a></td>
                                <td><a href="#" class="fancybox">修改</a></td>
                                <!--<td><div class="form-group"><input class="form-control" style="width:50%; margin-right: 6px;display:inline-block"/><a href="#" class="btn btn-default">添加</a></div></td>-->
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