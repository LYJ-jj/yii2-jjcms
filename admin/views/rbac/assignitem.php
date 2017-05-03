<?php
use yii\helpers\Html;

$this->title = '权限分配';
$this->params['breadcrumbs'][] = ['label' => '角色列表','url' => ['/admin/rbac/roles']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2 class="header-text"><?= Html::encode($this->title) ?></h2>

<div class="smart-widget m-top-lg widget-dark-blue">
    <div class="smart-widget-header"><?= $this->title ?></div>
    <div class="smart-widget-inner">
        <div class="smart-widget-body row">

            <div class="col-md-7">
                <?= Html::beginForm(['rbac/assign-item'],'post',['class' => 'form-horizontal no-margin']) ?>
                <div class="form-group">
                    <label class="control-label col-lg-2">角色名称</label>
                    <div class="col-lg-10">
                        <?= Html::input('text','name',$parent,['class' => 'form-control','readonly' => true]) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">角色子节点</label>
                    <div class="col-lg-10">
                        <?= Html::checkboxList('children',$children['roles'],$roles,['class' => 'checkbox']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">权限子节点</label>
                    <div class="col-lg-10">
                        <?= Html::checkboxList('children',$children['permissions'],$permissions,['class' => 'checkbox']) ?>
                    </div>
                </div>

                <div class="m-top-md col-lg-offset-1">
                    <?= Html::submitButton('分配',['class' => 'btn btn-info']) ?>&nbsp;
                    <?= Html::resetButton('重置',['class' => 'btn btn-warning']) ?>
                </div>
                <?= Html::endForm(); ?>
            </div>

            <div class="col-md-5">
                <div class="alert alert-info">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <i class="glyphicon glyphicon-bell"></i>
                    温馨提示：<br/>
                        您既可以分配角色给 <?= $parent ?> 角色，也可以单独的为它分配一些路由节点。
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


