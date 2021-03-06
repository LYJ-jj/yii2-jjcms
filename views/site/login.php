<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '欢迎登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>请填写下列信息进行登录:</p>

    <?php $form = ActiveForm::begin([
        'id'            => 'login-form',
        'fieldConfig'   => [
            'template' => "<div class='form-group'>{label}{input}{error}</div>",
            'labelOptions' => ['class' => 'control-label'],
        ]
    ]) ?>

        <?= $form->field($model,'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model,'password')->passwordInput() ?>

        <?= $form->field($model, 'verifyCode',['inputOptions' => ['class' => 'form-control']]) ?>
        <?= \yii\captcha\Captcha::widget([
            'name'  => 'verifyCode',
            'model' => $model,
            'captchaAction' => 'site/captcha',
            'template' => "{image}",
            'attribute'=> 'verifyCode',
            'imageOptions' => [
                'title' => '换一个',
                'alt'   => '换一个',
                'style' => 'cursor:pointer'
            ]
        ])  ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>

    <p>没有账号？<a class="btn btn-info btn-xs" href="<?= \yii\helpers\Url::to(['site/register']) ?>">去注册</a> </p>

</div>
