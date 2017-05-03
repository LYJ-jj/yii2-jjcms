<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Table */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="table-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'need_pk')->dropDownList(['1'=>'需要','0'=>'不需要']) ?>

    <?= $form->field($model, 'pk_type')->dropDownList(['1'=>'自增(int)','2'=>'不自增(bigint)']) ?>

    <?= $form->field($model, 'engine_type')->dropDownList(['InnoDB'=>'InnoDB','MyISAM'=>'MyISAM','MEMORY'=>'MEMORY']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '确定' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    <?php $this->beginBlock('tb_form'); ?>
        $('#table-need_pk').bind('change',function(){
            var sel_val = $(this).val();
            if(sel_val == '1'){
                $('#table-pk_type').attr({disabled : false});
            }

            if(sel_val == '0'){
                $('#table-pk_type').attr({disabled : true});
            }
        });
    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['tb_form'],\yii\web\View::POS_LOAD); ?>
