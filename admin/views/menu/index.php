<?php

use yii\helpers\Html;
use app\ext\HtmlExt;
use yii\grid\GridView;
use app\ext\DataExt;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '菜单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= HtmlExt::a('添加菜单', ['menu/create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'alias',
            [
                'attribute' => 'parent',
                'value'     => function($data){
                    if( $data->parent == 0 ){
                        return '顶级分类';
                    }
                    $menu = DataExt::getData(new \app\admin\models\Menu(),['cacheName' => 'menu_data']);
                    return $menu[$data->parent]['name'];
                }
            ],
            'route',
             [
                 'attribute'    => 'icon',
                 'format'       => 'raw',
                 'value'        => function($data){
                    return '<i class="'.$data->icon.'"></i>';
                 }
             ],
             'order',
             [
                 'attribute'    => 'status',
                 'value'        => function($data){
                    return $data->status ? '正常' : '停用';
                 }
             ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> '操作',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function($url,$model,$key){
                        return HtmlExt::a('<i class="glyphicon glyphicon-eye-open"></i> 详情',$url,['class' => 'btn btn-primary btn-xs']);
                    },
                    'update' => function($url,$model,$key){
                        return HtmlExt::a('<i class="glyphicon glyphicon-pencil"></i> 编辑',$url,['class' => 'btn btn-info btn-xs']);
                    },
                    'delete' => function($url,$model,$key){
                        return HtmlExt::a('<i class="glyphicon glyphicon-trash"></i> 删除',$url,['class' => 'btn btn-danger btn-xs']);
                    },
                ]
            ],
        ],
    ]); ?>
</div>
