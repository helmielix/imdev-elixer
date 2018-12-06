<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Reference;
use common\models\Modul;
use common\models\StatusReference;
use common\models\Warehouse;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\InstructionDisposal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="instruction-disposal-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'id' => 'createForm',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-4',
                'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-6',
                'error' => '',
                'hint' => '',
            ],
        ],
        'requiredCssClass' => 'requiredField'
    ]); ?>
    <?= $form->field($model, 'buyer')->dropDownList(
        ArrayHelper::map(Reference::find()->where(['in','id',[1,2]])->all(),'id','description'),
        ['prompt'=>'Select...']
        );?>

    <?= $form->field($model, 'warehouse')->dropDownList(
        ArrayHelper::map(Warehouse::find()->where(['in','id',[1]])->all(),'id','nama_warehouse'),
        ['prompt'=>'Select...']
        );?>
<!-- 
    <?= $form->field($model, 'no_iom')->textInput() ?> -->


    <?= $form->field($model, 'date_iom')->widget(
                     DatePicker::className(),
                        [ 'inline' => false,
                            'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                            // 'startDate' => $model->idCdmPnl->pnl_date
                            ]
                        ]) ?>

    <?= $form->field($model, 'estimasi_disposal')->widget(
                     DatePicker::className(),
                        [ 'inline' => false,
                            'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                            // 'startDate' => $model->idCdmPnl->pnl_date
                            ]
                        ]) ?>

    <?= $form->field($model, 'file')->fileInput() ?>
    <div class="form-group">
        <label class='control-label col-sm-4'> </label>
        <div class='col-sm-6'>
            <?php if (Yii::$app->controller->action->id == 'update') {
                echo Html::a(basename($model->file_attachment), ['downloadfile','id' => $model->id], $options = ['target'=>'_blank', 'data' => [
                        'method' => 'post',
                        'params' => [
                            'data' => 'file_attachment',
                        ]
                    ]]);
            } ?>
        </div>
    </div>

    <?= $form->field($model, 'revision_remark')->textarea(['rows' => 6]) ?> 

<!--     <?= $form->field($model, 'id_modul')->textInput() ?> -->


    <div class="form-group">
        <label class='control-label col-sm-4'> </label>
        <div class='col-sm-6'>
            <?php switch ($this->context->action->id) {
                case 'create':
                    $actionText = 'Create';
                    break;
                case 'update':
                    $actionText = 'Update';
                    break;
            } ?>
            <?= Html::button($actionText, ['id'=>'createButton','class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
$('#createButton').click(function () {
    var form = $('#createForm');
    alert(form);
    console.log(form);
    data = form.data("yiiActiveForm");
    $.each(data.attributes, function() {
      this.status = 3;
    });
    form.yiiActiveForm("validate");
    if (!form.find('.has-error').length) {
        data = new FormData(form[0]);
        
        data.append( 'file', $( '#instructiondisposal-file' )[0].files[0] );
        var button = $(this);
        button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

        $.ajax({
            url: '<?php echo Url::to([$this->context->id.'/'.$this->context->action->id, 'id' => $model->id]) ;?>',
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                if(response == 'success') {                 
                    $('#modal').modal('show')
                        .find('#modalContent')
                        .load('<?php echo Url::to([$this->context->id.'/indexdetail']) ;?>');
                    $('#modalHeader').html('<h3>Detail Instruksi Disposal</h3>');
                } else {
                    alert('error with message: ' + response);
                }
            },
            error: function (xhr, getError) {
                if (typeof getError === "object" && getError !== null) {
                    error = $.parseJSON(getError.responseText);
                    getError = error.message;
                }
                if (xhr.status != 302) {
                    alert("System recieve error with code: "+xhr.status);
                }
            },
            complete: function () {
                button.prop('disabled', false);
                $('#spinRefresh').remove();
            },
        });
    };
});
</script>
