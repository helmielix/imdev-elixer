<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;
use kartik\select2\Select2;
use common\models\Reference;
use common\models\Region;
use common\models\Division;
use common\models\Labor;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\InstructionWhTransfer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="instruction-grf-form">

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
    
    <?= $form->field($model, 'grf_number')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'wo_number')->textInput(['disabled' => true]) ?>


    <?= $form->field($model, 'grf_type')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Reference::find()->andWhere(['table_relation' => ['grf_type']])->all(), 'id','description'),
        'language' => 'en',
        // form-control select2-hidden-accessible
        'options' => ['placeholder' => 'Select '.$model->getAttributeLabel('grf_type'), 'class' => 'input-sm'],
        'pluginOptions' => [
        'disabled' => true],
        ]) ?>

    <?= $form->field($model, 'requestor')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Reference::find()->andWhere(['table_relation' => ['requestor']])->all(), 'id','description'),
        'language' => 'en',
        // form-control select2-hidden-accessible
        'options' => ['placeholder' => 'Select '.$model->getAttributeLabel('requestor'), 'class' => 'input-sm'],
        'pluginOptions' => [
        'disabled' => true],
        ]) ?>

     <?= $form->field($model, 'id_division')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Division::find()->all(), 'id','nama'),
        'language' => 'en',
        // form-control select2-hidden-accessible
        'options' => ['placeholder' => 'Select '.$model->getAttributeLabel('id_division'), 'class' => 'input-sm'],
        'pluginOptions' => [
        'disabled' => true],
        ]) ?>

    <?= $form->field($model, 'id_region')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Region::find()->all(), 'id','name'),
        'language' => 'en',
        // form-control select2-hidden-accessible
        'options' => ['placeholder' => 'Select '.$model->getAttributeLabel('id_region'), 'class' => 'input-sm'],
        'pluginOptions' => [
        'disabled' => true],
        ]) ?>

    <?= $form->field($model, 'pic')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Labor::find()->all(), 'nik','nama'),
        'language' => 'en',
        // form-control select2-hidden-accessible
        'options' => ['placeholder' => 'Select '.$model->getAttributeLabel('id_region'), 'class' => 'input-sm'],
        'pluginOptions' => [
        'disabled' => true],
        ]) ?>
    

    <div class="form-group">
        <label class='control-label col-sm-4'>File Attachment 1 </label>
        <div class='col-sm-6'>
            <?php if (Yii::$app->controller->action->id == 'create') {
                echo Html::a(basename($model->file_attachment_1), ['downloadfile','id' => $model->id], $options = ['target'=>'_blank', 'data' => [
                        'method' => 'post',
                        'params' => [
                            'data' => 'file_attachment_1',
                        ]
                    ]]);
            } ?>
        </div>
    </div>

    <div class="form-group">
        <label class='control-label col-sm-4'>File Attachment 2 </label>
        <div class='col-sm-6'>
            <?php if (Yii::$app->controller->action->id == 'create') {
                echo Html::a(basename($model->file_attachment_2), ['downloadfile','id' => $model->id], $options = ['target'=>'_blank', 'data' => [
                        'method' => 'post',
                        'params' => [
                            'data' => 'file_attachment_2',
                        ]
                    ]]);
            } ?>
        </div>
    </div>

    <div class="form-group">
        <label class='control-label col-sm-4' >File Attachment 3 </label>
        <div class='col-sm-6'>
            <?php if (Yii::$app->controller->action->id == 'create') {
                echo Html::a(basename($model->file_attachment_3), ['downloadfile','id' => $model->id], $options = ['target'=>'_blank', 'data' => [
                        'method' => 'post',
                        'params' => [
                            'data' => 'file_attachment_3',
                        ]
                    ]]);
            } ?>
        </div>
    </div>

    <?= $form->field($model, 'purpose')->textArea(['disabled' => true]) ?>

    <?= $form->field($model, 'date_of_return')->textInput([ 'disabled' => true]) ?>

     <?= $form->field($model, 'incoming_date')->widget(
        DatePicker::className(),
        [ 'inline' => false,
            'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'endDate' => date('Y-m-d'),
        ]
    ]) ?>

    <?= $form->field($model, 'note')->textArea() ?>
    
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
    data = form.data("yiiActiveForm");
    $.each(data.attributes, function() {
      this.status = 3;
    });
    form.yiiActiveForm("validate");
    if (!form.find('.has-error').length) {
        data = new FormData(form[0]);
        
        // data.append( 'file1', $( '#grf-file1' )[0].files[0] );
        // data.append( 'file2', $( '#grf-file2' )[0].files[0] );
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
                        .load('<?php 
                        $goto = ($model->isNewRecord) ? '/indexdetail' : '/view';
                        echo Url::to([$this->context->id.$goto, 'id' => $model->id]) ;?>');
                    $('#modalHeader').html('<h3>Detail Intruction Grf</h3>');
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
