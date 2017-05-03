<?php
use yii\helpers\Html;

$this->title = '添加角色';
$this->params['breadcrumbs'][] = ['label' => '角色列表','url' => ['/admin/rbac/roles']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2 class="header-text"><?= Html::encode($this->title) ?></h2>

<div class="smart-widget m-top-lg widget-dark-blue">
    <div class="smart-widget-header">请填写以下内容：</div>
    <div class="smart-widget-inner">
        <div class="smart-widget-body row">

            <div class="col-md-7">
                <?= Html::beginForm(['rbac/create-role'],'post',['class' => 'form-horizontal no-margin']) ?>
                <div class="form-group">
                    <label class="control-label col-lg-2">名称</label>
                    <div class="col-lg-10">
                        <?= Html::input('text','name','',['class' => 'form-control']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">说明</label>
                    <div class="col-lg-10">
                        <?= Html::input('text','description','',['class' => 'form-control']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">规则</label>
                    <div class="col-lg-10">
                        <?= Html::input('text','rule_name','',['class' => 'form-control']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">数据</label>
                    <div class="col-lg-10">
                        <?= Html::textarea('data','',['class' => 'form-control','rows' => '5']) ?>
                    </div>
                </div>

                <div class="m-top-md col-lg-offset-1">
                    <?= Html::submitButton('添加',['class' => 'btn btn-info']) ?>&nbsp;
                    <?= Html::resetButton('重置',['class' => 'btn btn-warning']) ?>
                </div>
                <?= Html::endForm(); ?>
            </div>

            <div class="col-md-5">
                <div class="alert alert-info">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <i class="glyphicon glyphicon-bell"></i>
                    温馨提示：<br/>
                        "名称" => 该角色的英文名称名称,"说明" => 描述信息
                </div>
            </div>

        </div>
    </div>
</div>