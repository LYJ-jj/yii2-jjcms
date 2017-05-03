<?php
use kartik\file\FileInput;
use yii\helpers\Html;
use app\assets\AdminAsset;
    $this->title = '更换头像';
?>
<?php if( isset($alerts) ){echo $alerts;} ?>

<h2 class="header-text"><?= Html::encode($this->title) ?></h2>

<div class="smart-widget m-top-lg widget-dark-blue">
    <div class="smart-widget-header">上传头像</div>
    <div class="smart-widget-inner">
        <div class="smart-widget-body row">

            <div class="col-md-7">
                <?= Html::beginForm(['site/face'],'post',['enctype'=>'multipart/form-data','class' => 'form-horizontal no-margin','id' => 'form-face']) ?>
                <?=
                FileInput::widget([
                    'name'      => 'face',
                    'pluginOptions' => [
                        'showPreview' => true,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showUpload' => true,
                        'uploadLabel'=>'上传',
                        'browseLabel' => '选择',
                        'removeLabel' => '删除',
                    ],
                    //'options'   => ['multiple'=>true]
                ]);
                ?>
                <?= Html::endForm(); ?>
            </div>

            <div class="col-md-5">
                <div class="alert alert-info">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <i class="glyphicon glyphicon-bell"></i>
                    温馨提示：<br/>
                    图片格式为 jpeg,jpg,png，大小不超过500K
                </div>
            </div>
        </div>
    </div>
</div>

