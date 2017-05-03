<?php
use app\ext\HtmlExt;
use yii\helpers\Html;
use yii\grid\GridView;
$this->title = '角色列表';
$this->params['breadcrumbs'][] = $this->title;

?>

<h2 class="header-text"><?= Html::encode($this->title) ?></h2>

<p>
    <?= HtmlExt::a('新增角色',['rbac/create-role'],['class' => 'btn btn-success']) ?>
</p>

<?=
    GridView::widget([
        'dataProvider'  => $dataProvider,
        'columns'        => [
            [
                'class' => 'yii\grid\SerialColumn'
            ],
            'name:text:名称',
            'description:text:描述',
            'rule_name:text:规则',
            [
                'attribute' => 'created_at',
                'label'     => '创建时间',
                'value'     => function($data){
                    return date('Y-m-d H:i:s',$data['created_at']);
                }
            ],

            [
                'attribute' => 'updated_at',
                'label'     => '更新时间',
                'value'     => function($data){
                    return date('Y-m-d H:i:s',$data['updated_at']);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> '操作',
                'template' => '{assign} {update} {delete}',
                'buttons'  => [
                    'assign'  => function($url,$model,$key){
                        return HtmlExt::a('分配权限',['assign-item','name' => $model['name']],['class' => 'btn btn-xs btn-primary']);
                    },
                    'update'  => function($url,$model,$key){
                        return HtmlExt::a('更新',['update-role','name' => $model['name']],['class' => 'btn btn-xs btn-info']);
                    },
                    'delete'  => function($url,$model,$key){
                        return HtmlExt::a('删除',['delete-role','name' => $model['name']],['class' => 'btn btn-xs btn-danger']);
                    }
                ]
            ]
        ],
    ]);
?>


