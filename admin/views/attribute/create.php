<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Attribute */

$this->title = '新增字段';
$this->params['breadcrumbs'][] = ['label' => 'Tables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="table-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model_id'=>$model_id,
        'model' => $model,
    ]) ?>

</div>
