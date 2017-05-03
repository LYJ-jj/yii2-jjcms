<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\admin\models\Config */

$this->title = $model->web_name;
$this->params['breadcrumbs'][] = ['label' => 'Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= \app\ext\HtmlExt::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'web_name',
            'web_alias',
            'web_describe',
            'web_keyword',
            'web_record',
            'web_email:email',
            'admin_is_allow_register',
            'app_is_allow_register',
            'default_rows',
            'default_cache_expire',
            'is_show_help',
        ],
    ]) ?>

</div>
