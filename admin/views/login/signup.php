<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AdminAsset;
$this->title = '欢迎注册使用';

AdminAsset::addScript($this,\Yii::$app->params['__static__adminJs__'].'/jquery.popupoverlay.min.js');
AdminAsset::addScript($this,\Yii::$app->params['__static__adminJs__'].'/modernizr.min.js');
?>

<div class="wrapper no-navigation preload">
    <div class="sign-in-wrapper">
        <div class="sign-in-inner">
            <div class="login-brand text-center">
                jj <strong class="text-skin">CMS</strong>
            </div>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']) ?>
                <div class="form-group m-bottom-md">
                    <?= $form->field($model,'username',['inputOptions' =>['class'=>'form-control','placeholder' => 'Your name']])  ?>
                </div>

                <div class="form-group m-bottom-md">
                    <?= $form->field($model,'email',['inputOptions' => ['class' => 'form-control','placeholder' => 'Your email']])     ?>
                </div>

                <div class="form-group">
                    <?= $form->field($model,'password',['inputOptions' => ['class' => 'form-control','placeholder' => 'Your password']])->passwordInput()  ?>
                </div>

                <div class="form-group">
                    <?= $form->field($model,'password_repeat',['inputOptions' => ['class' => 'form-control','placeholder' => 'Confirm password']])->passwordInput() ?>
                </div>

                <div class="form-group">
                    <?= $form->field($model,'verifyCode',['inputOptions' => ['class' => 'form-control','placeholder' => 'captcha']])  ?>
                </div>

                <div class="form-group">
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
                    <?= Html::submitButton('注册',['class' => 'btn btn-success block','style' => 'width:100%']) ?>
                </div>

                <div class="m-top-md p-top-sm">
                    <div class="font-12 text-center m-bottom-xs">已有账号?</div>
                    <?= Html::a('登录',\yii\helpers\Url::to(['login/login']),['class' => 'btn btn-default block']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div><!-- ./sign-in-inner -->
    </div><!-- ./sign-in-wrapper -->
</div><!-- /wrapper -->
