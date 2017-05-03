<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use app\assets\AdminAsset;
use app\core\functions;
AdminAsset::register($this);
AdminAsset::addScript($this,Yii::$app->params['__static__adminJs__'].'/jquery.popupoverlay.min.js');
AdminAsset::addScript($this,Yii::$app->params['__static__adminJs__'].'/modernizr.min.js');
$this->title = $name;
$this->context->layout = false;
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= Html::encode($this->title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php $this->head(); ?>
</head>

<?php $this->beginBody() ?>
<body class="overflow-hidden light-background">
<div class="wrapper no-navigation preload">
    <div class="error-wrapper">
        <div class="error-inner">
            <div class="error-type animated"><?= functions::getDomByStr($this->title,'number') ?></div>
            <h1><?= nl2br(Html::encode($message)) ?></h1>
            <p>啊哦┗|｀O′|┛，网页开小差了，请稍后重试！</p>
            <div class="m-top-md">
                <!--<a href="index.html" class="btn btn-default btn-lg text-upper">Back to Home</a>-->
            </div>
        </div><!-- ./error-inner -->
    </div><!-- ./error-wrapper -->
</div><!-- /wrapper -->
</body>
<?php $this->endBody(); ?>
</html>
<?php $this->endPage() ?>

