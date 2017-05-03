<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\admin\models\Config */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="config-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'web_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'web_alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'web_describe')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'web_keyword')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'web_record')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'web_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'admin_is_allow_register')->dropDownList($regis_array) ?>

    <?= $form->field($model, 'app_is_allow_register')->dropDownList($regis_array) ?>

    <?= $form->field($model, 'default_rows')->input('number') ?>

    <?= $form->field($model, 'default_cache_expire')->input('number') ?>

    <?= $form->field($model, 'is_show_help')->dropDownList($regis_array) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
