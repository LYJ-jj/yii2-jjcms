<?php
use app\ext\HtmlExt;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\admin\models\Table */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="table-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= HtmlExt::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= HtmlExt::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '你确定删除这个表吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            'title',
            [
                'label' => '是否需要自增主键',
                'value' => $model->need_pk==1? '需要' : '不需要'
            ],
            'engine_type',
            [
                'label' => '创建时间',
                'value' => date('Y-m-d H:i:s',$model->create_time)
            ],
            [
                'label' => '更新时间',
                'value' => date('Y-m-d H:i:s',$model->update_time)
            ],
        ],
    ]) ?>

</div>
