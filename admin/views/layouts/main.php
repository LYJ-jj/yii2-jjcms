<?php
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
\app\assets\AdminAsset::register($this);
$config = \app\admin\models\Config::getConfig();
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $config['web_name'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $this->registerMetaTag(['name' => 'keyword','content' => $config['web_keyword']]) ?>
    <?php $this->registerMetaTag(['name' => 'description','content' => $config['web_describe']]) ?>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>
<body class="overflow-hidden">
    <div class="wrapper preload">
        <?=
            $this->render(
                'header.php'
            );
        ?>

        <?=
            $this->render(
                'left.php'
            );
        ?>

        <div class="main-container">
            <!--<?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>-->
            <?php
                $mess = Yii::$app->session->getFlash('msg');
                if($mess){
                    $str = '<div class="alert alert-'.$mess['status'].' alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">
                                &times;
                            </button>
                            '.$mess['mes'].'
                            </div>';
                    echo $str;
                }
            ?>
            <div class="padding-md">
                <?= $content ?>
            </div>
        </div>

        <?=
            $this->render(
               'footer.php'
            );
        ?>
    </div>

</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
