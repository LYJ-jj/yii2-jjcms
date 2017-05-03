<?php
use yii\helpers\Html;
\app\assets\AdminAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= Html::encode($this->title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php $this->head() ?>
    <!--<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="css/font-awesome.min.css" rel="stylesheet">

    <link href="css/ionicons.min.css" rel="stylesheet">

    <link href="css/simplify.min.css" rel="stylesheet">-->

</head>

<body class="overflow-hidden light-background">

    <?php $this->beginBody(); ?>

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
    <?= $content; ?>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

