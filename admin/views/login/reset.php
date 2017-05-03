<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = '重置密码';
?>

<div class="wrapper no-navigation preload">
    <div class="sign-in-wrapper">
        <div class="sign-in-inner">
            <?php if( isset($alerts) ){echo $alerts;} ?>

            <div class="login-brand text-center">
                <?= $this->title; ?>
            </div>
            <?php $form = ActiveForm::begin(['id' => 'form-login']) ?>
            <div class="form-group m-bottom-md">
                <?= $form->field($model, 'username',['inputOptions' => ['class' => 'form-control']]) ?>
            </div>

            <div class="form-group m-bottom-md">
                <?= $form->field($model, 'email',['inputOptions' => ['class' => 'form-control']]) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'verifyCode',['inputOptions' => ['class' => 'form-control']]) ?>
                <?= \yii\captcha\Captcha::widget([
                    'name'  =>'verifyCode',
                    'model' => $model,
                    'captchaAction' => '/admin/login/captcha',
                    'template'=>'{image}',
                    'attribute'=>'verifyCode',
                    'imageOptions'=>
                        [
                            'title'=>'换一个',
                            'alt'=>'换一个',
                            'style'=>'cursor:pointer;'
                        ]])
                ?>
            </div>

            <div class="m-top-md p-top-sm">
                <?= Html::submitButton('提交',['class' => 'btn btn-success block','style'=>'width:100%;']) ?>
            </div>

            <div class="m-top-md p-top-sm">
                <?= Html::a('返回登录',\yii\helpers\Url::to(['login/login']),['class' => 'btn btn-default block']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div><!-- ./sign-in-inner -->
    </div><!-- ./sign-in-wrapper -->
</div><!-- /wrapper -->
