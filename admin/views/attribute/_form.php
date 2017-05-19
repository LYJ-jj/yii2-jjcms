<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="table-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['readonly'=>true]) ?>

    <?= $form->field($model, 'model_id')->textInput(['readonly'=>true,'value'=>$model_id]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(['0'=>'请选择...','char'=>'单字符','string'=>'字符串','integer'=>'数字','longint' => '长整型','float'=>'浮点数','text'=>'文本框'],['id'=>'type']) ?>

    <?= $form->field($model, 'field')->textInput(['maxlength' => true,'id'=>'field']) ?>

    <?= $form->field($model, 'default_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '确定' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    <?php $this->beginBlock('attri') ?>
        $('form').submit(function(e){
            if($('#type').val()=='0'){
                alert('请选择数据类型!');
                e.preventDefault();
                return false;
            }
        });

        $('#type').bind('change',function(){
            var val = $(this).val();
            var field = $('#field');
            switch(val){
                case 'string':
                    var txt = "VARCHAR(255) NOT NULL";
                    field.val(txt);
                    break;

                case 'longint':
                    var txt = "BIGINT(20) UNSIGNED NOT NULL";

                case 'char':
                    var txt = "CHAR(1) NOT NULL";
                    field.val(txt);
                    break;

                case 'integer':
                    var txt = "INT(10) UNSIGNED NOT NULL";
                    field.val(txt);
                    break;

                case 'float':
                    var txt = "FLOAT UNSIGNED NOT NULL";
                    field.val(txt);
                    break;

                case 'text':
                    var txt = "TEXT NOT NULL";
                    field.val(txt);
                    break;
            }
        });
    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['attri'],\yii\web\View::POS_LOAD); ?>
