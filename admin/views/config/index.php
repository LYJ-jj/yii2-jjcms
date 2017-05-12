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
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'title',
            [
                'attribute' => 'groups',
                'filter'    => $gp_filter,
                'value'     => function($data){
                    return \app\admin\controllers\ConfigController::$group[$data->groups];
                }
            ],

            'value',
            [
                'attribute' => 'created_time',
                'value'     => function($data){
                    return date('Y-m-d H:i',$data->created_time);
                }
            ],

            [
                'attribute' => 'status',
                'filter'    => ['0' => '停用','1'=> '正常'],
                'value'     => function($data){
                    return $data->status ? '正常' : '停用';
                }
            ],

            [
                'class'     => 'yii\grid\ActionColumn',
                'header'    => '操作',
                'template'  => '{view} {update} {delete}',
                'buttons'   => [
                    'view'  => function($url,$model){
                        return HtmlExt::a('<i class="glyphicon glyphicon-eye-open"></i> 详情',$url);
                    },
                    'update'=> function($url,$model){
                        return HtmlExt::a('<i class="glyphicon glyphicon-pencil"></i> 编辑',$url);
                    },
                    'delete'=> function($url,$model){
                        return HtmlExt::a('<i class="fa fa-trash-o"></i> 删除',$url,['data' => [
                                'confirm' => '您确定要删除此配置吗？',
                                'method'  => 'post'
                        ]]);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
