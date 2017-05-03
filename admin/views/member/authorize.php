<?php
use yii\helpers\Html;

$this->title = '用户授权';
$this->params['breadcrumbs'][] = ['label' => '用户列表','url' => ['member/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2 class="header-text"><?= Html::encode($this->title) ?></h2>

<div class="smart-widget m-top-lg widget-dark-blue">
    <div class="smart-widget-header"><?= $this->title ?></div>
    <div class="smart-widget-inner">
        <div class="smart-widget-body row">

            <div class="col-md-7">
                <?= Html::beginForm(['member/authorize'],'post',['class' => 'form-horizontal no-margin']) ?>
                <?= Html::input('hidden','admin_id',$admin->id) ?>
                <div class="form-group">
                    <label class="control-label col-lg-2">用户名</label>
                    <div class="col-lg-10">
                        <?= Html::input('text','name',$admin->username,['class' => 'form-control','readonly' => true]) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">角色</label>
                    <div class="col-lg-10">
                        <?= Html::checkboxList('children',$children['roles'],$roles,['class' => 'checkbox']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">权限</label>
                    <div class="col-lg-10">
                        <?= Html::checkboxList('children',$children['permissions'],$permissions,['class' => 'checkbox']) ?>
                    </div>
                </div>

                <div class="m-top-md col-lg-offset-1">
                    <?= Html::submitButton('授权',['class' => 'btn btn-info']) ?>&nbsp;
                    <?= Html::resetButton('重置',['class' => 'btn btn-warning']) ?>
                </div>
                <?= Html::endForm(); ?>
            </div>

            <div class="col-md-5">
                <div class="alert alert-info">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <i class="glyphicon glyphicon-bell"></i>
                    温馨提示：<br/>
                        您既可以分配角色给 <?= $admin->username ?> 用户，也可以单独的为它分配一些路由节点。
                </div>
            </div>

        </div>
    </div>
</div>

<?php
 $css = <<<CSS
.checkbox label{
    font-size: 14px;
    margin-left: 10px;
}
CSS;
$this->registerCss($css);
?>


