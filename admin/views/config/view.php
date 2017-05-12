<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\admin\models\Config */

$this->title = $model->title;
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
            'name',
            'title',
            [
                'attribute' => 'groups',
                'value'     => function($data){
                    return \app\admin\controllers\ConfigController::$group[$data->groups];
                }
            ],

            'value',
            'remark',
            'sort',
            [
                'attribute' => 'created_time',
                'value'     => function($data){
                    return date('Y-m-d H:i',$data->created_time);
                }
            ],

            [
                'attribute' => 'updated_time',
                'value'     => function($data){
                    return date('Y-m-d H:i',$data->updated_time);
                }
            ],
            [
                'attribute' => 'status',
                'value'     => function($data){
                    return $data->status ? '正常' : '停用';
                }
            ],
        ],
    ]) ?>

</div>
