<?php
use app\core\functions;
use app\ext\HtmlExt;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '网站配置';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= HtmlExt::a('新增', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'web_name',
            [
                'attribute' => 'web_alias',
                'value'     => function($data){
                    return functions::msubstr($data->web_alias,0,10,false);
                }
            ],
            [
                'attribute' => 'web_describe',
                'value'     => function($data){
                    return functions::msubstr($data->web_describe,0,10);
                }
            ],
            'web_keyword',
            'web_record',
             'web_email:email',
             //'admin_is_allow_register',
             //'app_is_allow_register',
            'default_rows',
             'default_cache_expire',
            'is_show_help',

            [
                'class'     => 'yii\grid\ActionColumn',
                'header'    => '操作',
                'template'  => '{view} {update}',
                'buttons'   => [
                    'view'  => function($url,$model){
                        return HtmlExt::a('<i class="glyphicon glyphicon-eye-open"></i> 详情',$url);
                    },
                    'update'=> function($url,$model){
                        return HtmlExt::a('<i class="glyphicon glyphicon-pencil"></i> 编辑',$url);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
