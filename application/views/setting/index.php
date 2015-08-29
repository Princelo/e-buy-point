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
            <h1 class="page-header">修改资料</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-edit fa-fw"></i> 修改资料
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
                    <form role="form" method="post" action="<?=$form_url?>" data-toggle="validator" id="form">
                        <div class="form-group">
                            <label>商家店舖名称</label>
                            <input class="form-control" name="" data-error="无效名称" value="<?=$data->name?>" disabled>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group">
                            <label>店舖地址</label>
                            <input class="form-control" name="address" data-error="无效地址" maxlength="50" value="<?=$data->address?>" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('address')?></span>
                            <p class="help-block">例：广州市花都区龙珠路74号田美商业广场大润发5楼53号商铺</p>
                        </div>
                        <div class="form-group">
                            <label>固定电话</label>
                            <input class="form-control" name="tel" data-error="" maxlength="20" value="<?=$data->tel?>">
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('tel')?></span>
                            <p class="help-block">例：020-86888888</p>
                        </div>
                        <div class="form-group">
                            <label>联系人</label>
                            <input class="form-control" name="contact" data-error="" maxlength="15" value="<?=$data->contact?>">
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span class="help-block with-errors"></span>
                            <span><?=form_error('contact')?></span>
                            <p class="help-block">例：杨小姐</p>
                        </div>
                        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                        <button type="submit" class="btn btn-primary">提交</button>
                        <button type="reset" class="btn btn-danger">重新输入</button>
                    </form>
                    <script>
                        $('#form').validator();
                    </script>
                    <style>#form .has-success {position:relative;}</style>
                    <style>#form .has-error {position:relative;}</style>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
            <!-- /.panel -->
        </div>
    </div>
</div>