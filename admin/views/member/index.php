<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\ext\HtmlExt;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\admin\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '后台用户';
$this->params['breadcrumbs'][] = $this->title;
$config = \app\admin\models\Config::getConfig();
?>
<div class="admin-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if($config['admin_is_allow_register']): ?>
            <?= HtmlExt::a('注册用户', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            // 'face',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
             'email:email',
             [
                 'attribute' => 'last_login_time',
                 'value'     => function($data){
                    return date('Y-m-d H:i:s',$data->last_login_time);
                 }
             ],
             'last_login_ip',
            [
                'attribute' => 'created_time',
                'value'     => function($data){
                    return date('Y-m-d H:i:s',$data->created_time);
                }
            ],
            [
                'attribute' => 'updated_time',
                'value'     => function($data){
                    return date('Y-m-d H:i:s',$data->updated_time);
                }
            ],
             'status',

            [
                'class'   => 'yii\grid\ActionColumn',
                'header'  => '操作',
                'template'=> '{authorize} {update} {delete}',
                'buttons' => [
                    'authorize' => function($url,$model,$key){
                        return HtmlExt::a('授权',Url::toRoute(['member/authorize','admin_id' => $model->id]),['class' => 'btn btn-xs btn-primary']);
                    },
                    'update'    => function($url,$model,$key){
                        return HtmlExt::a('编辑',Url::toRoute(['member/update','id' => $model->id]),['class' => 'btn btn-xs btn-info']);
                    },
                    'delete'    => function($url,$model,$key){
                        if( $model->id != Yii::$app->admin->getId() ){
                            return HtmlExt::a('删除',Url::toRoute(['member/delete','id' => $model->id]),['class' => 'btn btn-xs btn-danger','data' =>[
                                'method'    => 'post',
                                'confirm'   => '确定要删除此用户吗?'
                            ]]);
                        }else{
                            return '';
                        }
                    }
                ]
            ],
        ],
    ]); ?>
</div>
