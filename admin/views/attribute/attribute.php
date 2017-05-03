<?php
use yii\grid\GridView;
use yii\helpers\Url;
use app\ext\HtmlExt;

$this->title = $modelName.'模型 字段列表';
?>
<?= HtmlExt::a('新增',Url::to(['attribute/create','model_id'=>$model->id]),['class'=>'btn btn-info']) ?>

<div class="content" style="margin-top: 20px;">

    <?=
        GridView::widget([
            'dataProvider'  => $dataProvider,
            'columns'=>[
                'name',
                'note',
                'type',
                [
                    'attribute'   => 'create_time',
                    'value' => function($data){
                        return date('Y-m-d H:i:s',$data->create_time);
                    }
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=>'操作',
                    'template'=> '{update} {delete}',
                    'buttons'=>[
                        'update'  => function($url,$model,$key){
                            $url = Url::to(['attribute/update','id'=>$model->id]);
                            return HtmlExt::a('<i class="fa fa-edit"></i> 编辑',$url,['class'=>'btn btn-info btn-xs']);
                        },

                        'delete'  => function($url,$model,$key){
                            $url = Url::to(['attribute/delete','id'=>$model->id]);
                            return HtmlExt::a('<i class="fa fa-trash-o"></i> 删除',$url,['class'=>'btn btn-danger btn-xs','data'=>['confirm'=>'确定要删除这个字段吗?','method'=>'post']]);
                        }
                    ]
                ]
            ],
        ]);
    ?>
</div>
