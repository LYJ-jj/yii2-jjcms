<?php

use yii\helpers\Html;
use app\ext\HtmlExt;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\admin\models\TableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '数据表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="table-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= HtmlExt::a('新增模型', ['create'], ['class' => 'btn btn-success']) ?> &nbsp;
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'title',
            //'need_pk',
            'engine_type',
            [
                'attribute' => 'create_time',
                'value' => function($data){
                    return date('Y-m-d H:i:d',$data->create_time);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> '操作',
                'template'=> '{view} {update} {delete} {attribute}',
                'buttons' => [
                    'view'      => function($url,$model,$key){
                        return HtmlExt::a('<span class="glyphicon glyphicon-eye-open"></span> 详情',$url,['class'=>'btn btn-primary btn-xs']);
                    },
                    'update'      => function($url,$model,$key){
                        return HtmlExt::a('<span class="glyphicon glyphicon-pencil"></span> 编辑',$url,['class'=>'btn btn-info btn-xs']);
                    },
                    'delete'      => function($url,$model,$key){
                        return HtmlExt::a('<span class="glyphicon glyphicon-trash"></span> 删除',$url,[
                                'class' => 'btn btn-danger btn-xs',
                                'data'  => [
                                    'confirm'   => '确实要删除 '.$model->name.' 表？',
                                    'method'    => 'post'
                                ]
                        ]);
                    },
                    'attribute' => function($url,$model,$key){
                        return HtmlExt::a('<i class="fa fa-edit"></i> 字段管理',$url,['class'=>'btn btn-info btn-xs']);
                    }
                ],
            ],
        ],
    ]); ?>
</div>
