<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = '欢迎登录';
?>
<div class="wrapper no-navigation preload">
    <div class="sign-in-wrapper">
        <div class="sign-in-inner">

            <div class="login-brand text-center">
                jj <strong class="text-skin">CMS</strong>
            </div>

            <?php $form = ActiveForm::begin(['id' => 'form-login']) ?>
                <div class="form-group m-bottom-md">
                   <?= $form->field($model, 'username',['inputOptions' => ['class' => 'form-control']]) ?>
                </div>

                <div class="form-group">
                    <?= $form->field($model, 'password',['inputOptions' => ['class' => 'form-control']])->passwordInput() ?>
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

                <div class="form-group">
                    <?= $form->field($model,'remember',['inputOptions' => ['id' => 'chkAccept']])->checkbox()  ?>
                </div>

                <div class="m-top-md p-top-sm">
                    <?= Html::submitButton('登录',['class' => 'btn btn-success block','style'=>'width:100%;']) ?>
                </div>

                <div class="m-top-md p-top-sm">
                    <div class="font-12 text-center m-bottom-xs">
                        <a href="<?= \yii\helpers\Url::to(['login/reset']) ?>" class="font-12">忘记密码 ?</a>
                    </div>
                    <?php if($is_allow_SignUp): ?>
                    <div class="font-12 text-center m-bottom-xs">没有账号?</div>
                        <?= Html::a('创建新账号',\yii\helpers\Url::to(['login/signup']),['class' => 'btn btn-default block']) ?>
                    <?php endif; ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div><!-- ./sign-in-inner -->
    </div><!-- ./sign-in-wrapper -->
</div><!-- /wrapper -->

<a href="" id="scroll-to-top" class="hidden-print"><i class="icon-chevron-up"></i></a>