<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AdminAsset;

/* @var $this yii\web\View */
/* @var $model app\admin\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="smart-widget-body row">

    <div class="col-md-7">
        <?php $form = ActiveForm::begin(); ?>
            <div class="form-group">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'parent')->dropDownList($parent) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'order')->input('number') ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'status')->dropDownList($status) ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? '新增' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="col-md-5">
        <div class="alert alert-info">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <i class="glyphicon glyphicon-bell"></i>
            温馨提示：<br/>
            菜单名称以及上级菜单为必填项
        </div>
    </div>

</div>

<?php
?>

