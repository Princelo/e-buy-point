<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
            <h1 class="page-header">本月会员消费纪录</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-edit fa-fw"></i> 本月会员消费纪录
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
                    <?if(count($list)==0){?>
                        <div class="alert alert-warning">
                            当前没有纪录
                        </div>
                    <?}?>
                    <table class="table table-striped table-bordered table-hover dataTable no-footer" <?if(count($list)==0){?>style="display:none;"<?}?>>
                        <thead>
                        <tr>
                            <th>消费录入日期</th>
                            <th>消费项目</th>
                            <th>备注</th>
                            <th>会员帐号</th>
                            <th>消费金额</th>
                            <th>会员积分</th>
                            <th>消费店舖</th>
                            <th>所属商家</th>
                            <th>消费商家积分</th>
                            <th>所属商家积分</th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($list as $l) { ?>
                            <tr>
                                <td><?=$l->time?></td>
                                <td><?=$l->title?></td>
                                <td><?=$l->remark?></td>
                                <td><?=$l->consumer_name?></td>
                                <td>￥<?=$l->volume?>元</td>
                                <td><?=$l->uscore?>分</td>
                                <td><?=$l->name?></td>
                                <td><?=$l->pname?></td>
                                <td><?=$l->lscore?>分</td>
                                <td><?=$l->pscore?>分</td>
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