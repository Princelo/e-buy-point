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
            <h1 class="page-header">我的商家</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-edit fa-fw"></i> 我的商家
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
                            当前您没有任何商家
                        </div>
                    <?}?>
                    <table class="table table-striped table-bordered table-hover dataTable no-footer" <?if(count($list)==0){?>style="display:none;"<?}?>>
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>商家名称</th>
                            <th>行业类型</th>
                            <th>门店地址</th>
                            <th>返点率</th>
                            <th>商家电话</th>
                            <th>商家联系人</th>
                            <th>管理员用户名</th>
                            <th>管理员手机</th>
                            <th>管理员邮箱</th>
                            <th>备注</th>
                        <tbody>
                        <? foreach ($list as $i => $l) { ?>
                            <tr>
                                <td><?=$i?></td>
                                <td><?=$l->name?></td>
                                <td><?=$l->deal_cate_match_row?></td>
                                <td><?=$l->address?></td>
                                <td><?=$l->ratio?>%</td>
                                <td><?=$l->tel?></td>
                                <td><?=$l->contact?></td>
                                <td><?=$l->account?></td>
                                <td><?=$l->mobile?></td>
                                <td><?=$l->email?></td>
                                <td><?=$l->remark?></td>
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