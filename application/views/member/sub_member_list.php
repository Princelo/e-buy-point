<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
    if("<?=$csrf['hash']?>" != getCookie('<?=$csrf_cookie_name?>'))
        location.reload();
</script>
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
            <h1 class="page-header">我的会员</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-edit fa-fw"></i> 我的会员
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
                            当前您没有会员
                        </div>
                    <?}?>
                    <table class="table table-striped table-bordered table-hover dataTable no-footer" <?if(count($list)==0){?>style="display:none;"<?}?>>
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>会员帐号</th>
                            <th>注册时间</th>
                            <th>电子邮箱</th>
                            <th>手机号码</th>
                            <th>出生日期</th>
                            <th>性别</th>
                            <th>积分</th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($list as $i => $l) { ?>
                            <tr>
                                <td><?=$i?></td>
                                <td><?=$l->user_name?></td>
                                <td><?=date('Y-m-d H:i:s', $l->create_time)?></td>
                                <td><?=$l->email?></td>
                                <td><?=$l->mobile?></td>
                                <td><?=$l->byear?>年<?=$l->bmonth?>月<?=$l->bday?>日</td>
                                <td><?=$l->sex === '-1'?'未知':($l->sex==='0'?'女':'男')?></td>
                                <td><?=$l->score?></td>
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