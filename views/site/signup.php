<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '欢迎注册使用';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>请填写下列信息进行注册:</p>

    <?php $form = ActiveForm::begin([
        'id'            => 'reg-form',
        'fieldConfig'   => [
            'template' => "<div class='form-group'>{label}{input}{error}</div>",
            'labelOptions' => ['class' => 'control-label'],
        ]
    ]) ?>

        <?= $form->field($model,'username')->textInput(['autofocus' => true])->label('用户名') ?>

        <?= $form->field($model,'email')->input('email') ?>

        <?= $form->field($model,'password')->passwordInput() ?>

        <?= $form->field($model,'repassword')->passwordInput() ?>

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
        <div class="form-group"></div>
        <div class="form-group">
            <?= Html::submitButton('注册', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>

    <p>已有账号？<a class="btn btn-info btn-xs" href="<?= \yii\helpers\Url::to(['site/login']) ?>">去登录</a> </p>

</div>
