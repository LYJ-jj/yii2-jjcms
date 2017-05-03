<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Table */

$this->title = '修改模型: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tables', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="table-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_updform', [
        'model' => $model,
    ]) ?>

</div>
