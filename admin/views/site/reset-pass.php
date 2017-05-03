<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
$this->title = '修改密码';
?>

<?php
 $css = <<<CSS
    .text-green{
        color:green;
    }
CSS;
$this->registerCss($css);
?>

<h2 class="header-text"><?= Html::encode($this->title) ?></h2>

<div class="smart-widget m-top-lg widget-dark-blue">
    <div class="smart-widget-header">请填写以下内容：</div>
    <div class="smart-widget-inner">
        <div class="smart-widget-body row">

            <div class="col-md-7">
                <?= Html::beginForm(['site/reset-pass'],'post',['class'=>'form-horizontal','id'=>'form1']); ?>
                <div class="form-group">
                    <label class="control-label col-lg-2">旧密码</label>
                    <div class="col-lg-10">
                        <?= Html::passwordInput('old_pwd','',['class'=>'form-control']) ?>
                    </div>

                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">新密码</label>
                    <div class="col-lg-10">
                        <?= Html::passwordInput('new_pwd','',['class'=>'form-control']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-lg-2">再次输入</label>
                    <div class="col-lg-10">
                        <?= Html::passwordInput('new_pwd2','',['class'=>'form-control']) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-3">
                        <label id="msg-info" class="control-label text-green">
                            <i class="fa fa-check"></i>密码修改成功
                        </label>
                    </div>
                    <?= Html::button('修改密码',['class'=>'btn btn-info','id'=>'sub-btn']) ?>
                </div>

                <?= Html::endForm(); ?>

            </div>

            <div class="col-md-5">
                <div class="alert alert-info">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <i class="glyphicon glyphicon-bell"></i>
                    温馨提示：<br/>
                    须先验证原密码，方能修改新的密码。
                </div>
            </div>

        </div>
    </div>
</div>


<script>
    <?php $this->beginBlock('js') ?>

        $('#msg-info').hide();
        //1.ajax提交表单
        $('#sub-btn').click(function(){
            var form_data = $('#form1').serialize();
            $.ajax({
                type    :   "post",
                dataType:   "json",
                url     :   "<?= Url::toRoute('site/reset-pass') ?>",
                data    :   form_data,
                success : function(value){
                    if(value.status==0){
                        $("input[name='"+value.name+"']").attr({
                            'data-toggle' : 'popover',
                            'data-placement' : 'bottom',
                            'data-content'   : value.content
                        }).addClass('popover-show').popover('show');
                    }else{
                        $('#msg-info').show();
                    }
                }
            });
        });


    <?php $this->endBlock(); ?>
</script>
<?php $this->registerJs($this->blocks['js'],\yii\web\View::POS_LOAD); ?>
