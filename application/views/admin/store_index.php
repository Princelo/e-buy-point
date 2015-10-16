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
            <h1 class="page-header">商家列表</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
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
                            <th>序号</th>
                            <th>商家名称</th>
                            <th>行业类型</th>
                            <th>管理帐号</th>
                            <th>所属业务员</th>
                            <th>当前积分</th>
                            <th>会员数</th>
                            <th>消费录入纪录(当月)</th>
                            <th>商家会员消费纪录(当月)</th>
                            <th>返点比率</th>
                            <th>备注</th>
                            <th>结算</th>
                            <th>结算日志</th>
                            <th>审核</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($store_list as $i => $l) { ?>
                            <tr>
                                <td><?=$i?></td>
                                <td><?=$l->name?></td>
                                <td><?=$l->deal_cate_match_row?></td>
                                <td><?=$l->account?></td>
                                <td><?=$l->seller_name?></td>
                                <td><?=$l->return_profit?>分</td>
                                <td><?=$l->sub_count?></td>
                                <td><a href="<?=site_url('report/biz_consumption_simple')?>?id=<?=$l->id?>" class="fancybox">查看</a></td>
                                <td><a href="<?=site_url('report/biz_sub_consumption_simple')?>?id=<?=$l->id?>" class="fancybox">查看</a></td>
                                <td><?=$l->consumption_ratio?>%</td>
                                <td><?=$l->remark?></td>
                                <td><a href="<?=site_url('admin/settle_simple')?>?id=<?=$l->id?>" class="fancybox">结算</a></td>
                                <td><a href="<?=site_url('admin/settle_biz_log_simple')?>?id=<?=$l->id?>" class="fancybox">查看</a></td>
                                <td id="state<?=$l->id?>" style="color:#<?=$l->is_m_access == '1'?'41cc4a':'cc2a24'?>"><?=$l->is_m_access == '1'?'通过':'未通过'?></td>
                                <td><a href="javascript:void(0);" onclick="toggle_biz_access(<?=$l->id?>)" id="link<?=$l->id?>"><?=$l->is_m_access == '0'?'生效':'禁用'?></a></td>
                            </tr>
                        <?}?>
                        </tbody>
                    </table>
                    <script>
                        var toggle_biz_access = function (id) {
                            $.ajax({
                                url: "<?=site_url('admin/toggle_biz_access')?>?id="+id,
                                success: function ( text ) {
                                    json = eval("(" + text + ")");
                                    if (json.state != 'success') {
                                        alert(json.message);
                                    } else {
                                        if (json.is_m_access == '1') {
                                            $('#link'+id).html('禁用');
                                            $('#state'+id).html('通过');
                                            $('#state'+id).css('color', '#41cc4a');
                                        } else {
                                            $('#link'+id).html('生效');
                                            $('#state'+id).html('未通过');
                                            $('#state'+id).css('color', '#cc2a24');
                                        }
                                    }

                                }
                            });
                        }
                    </script>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
            <!-- /.panel -->
        </div>
    </div>
</div>