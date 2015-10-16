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
            <h1 class="page-header">业务员列表</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-edit fa-fw"></i> 业务员列表
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
                            当前没有业务员
                        </div>
                    <?}?>
                    <table class="table table-striped table-bordered table-hover dataTable no-footer" <?if(count($seller_list)==0){?>style="display:none;"<?}?>>
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>业务员姓名</th>
                            <th>业务员帐号</th>
                            <th>积分</th>
                            <th>商家数</th>
                            <th>结算</th>
                            <th>结算日志</th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($seller_list as $i => $l) { ?>
                            <tr>
                                <td><?=$i?></td>
                                <td><?=$l->name?></td>
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
            <div class="row" style="">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-edit fa-fw"></i> 新增业务员
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
                            <form role="form" method="post" action="<?=$form_url?>" data-toggle="validator" id="consumption_form">
                                <div class="form-group">
                                    <label>业务员姓名</label>
                                    <input class="form-control" name="name" data-error="无效姓名" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="help-block with-errors"></span>
                                    <span><?=form_error('name')?></span>
                                    <p class="help-block">例：罗喜良</p>
                                </div>
                                <div class="form-group">
                                    <label>业务员用户名</label>
                                    <input class="form-control" name="user_name" data-remote="<?=$username_validate_url?>" data-error="无效用户名或已被佔用" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="help-block with-errors"></span>
                                    <span><?=form_error('user_name')?></span>
                                    <p class="help-block">例：Localy2008</p>
                                </div>
                                <div class="form-group">
                                    <label>业务员密码</label>
                                    <input class="form-control" name="user_pwd" type="password" data-error="无效密码" id="inputPassword" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="help-block with-errors"></span>
                                    <span><?=form_error('user_pwd')?></span>
                                </div>
                                <div class="form-group">
                                    <label>确认密码</label>
                                    <input class="form-control" type="password" data-match="#inputPassword" name="user_pwd_confirm" data-error="两次密码输入不相同" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="help-block with-errors"></span>
                                    <span><?=form_error('user_pwd_confirm')?></span>
                                </div>
                                <div class="form-group">
                                    <label>手机号码</label>
                                    <input class="form-control" name="mobile" data-remote="<?=$mobile_validate_url?>" pattern="^1[0-9]{10}$" data-error="手机号码不正确或已存在" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="help-block with-errors"></span>
                                    <span><?=form_error('mobile')?></span>
                                    <p class="help-block">例：13926262626</p>
                                </div>
                                <div class="form-group">
                                    <label>身份证号码</label>
                                    <input class="form-control" name="citizen_id"  data-error="身份证号码不正确" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="help-block with-errors"></span>
                                    <span><?=form_error('citizen_id')?></span>
                                    <p class="help-block">例：440101199912292255</p>
                                </div>
                                <div class="form-group">
                                    <label>电子邮箱</label>
                                    <input class="form-control" name="email"  data-remote="<?=$email_validate_url?>" data-error="电子邮箱不正确或已存在" type="email" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    <span class="help-block with-errors"></span>
                                    <span><?=form_error('email')?></span>
                                    <p class="help-block">例：foo@bar.com</p>
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
    </div>
</div>