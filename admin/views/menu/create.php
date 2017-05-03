<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\admin\models\Menu */

$this->title = '新增菜单';
$this->params['breadcrumbs'][] = ['label' => '菜单列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">

    <h2 class="header-text"><?= Html::encode($this->title) ?></h2>

    <div class="smart-widget m-top-lg widget-dark-blue">
        <div class="smart-widget-header">请填写以下内容：</div>
        <div class="smart-widget-inner">
            <?= $this->render('_form', [
                'model' => $model,
                'parent'=> $parent,
                'status'=> $status
            ]) ?>
        </div>
    </div>
</div>
