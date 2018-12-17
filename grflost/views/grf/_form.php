<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;
use kartik\select2\Select2;
use common\models\Reference;
use common\models\Vendor;
use common\models\Region;
use common\models\Labor;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\InstructionWhTransfer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grf-form">

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
    ]);  ?>
	
    <?php $form->field($model, 'grf_number')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'wo_number')->textInput(['maxlength' => true]) ?>

    <?php
        $depdropUnit = [
             'options' => ['placeholder' => 'Select '.$model->getAttributeLabel('grf_type'), 'class' => 'input-sm'],
            'type' => 2,
            'pluginOptions'=>[
                'depends'=>['grf-requestor'],
                'url'=>Url::to(['/grf/type'])
            ]
        ];
            $out = Reference::find()->select('id as id,description as name')->asArray()->andWhere(['table_relation' => ['grf_type']])->all();
            $depdropUnit['data'] = ArrayHelper::map($out, 'id', 'name');
        echo $form->field($model, 'grf_type')->widget(DepDrop::classname(), $depdropUnit);
    ?>

	<?= $form->field($model, 'requestor')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Reference::find()->andWhere(['table_relation' => ['requestor']])->all(), 'id','description'),
        'language' => 'en',
        // form-control select2-hidden-accessible
        'options' => ['placeholder' => 'Select '.$model->getAttributeLabel('requestor'), 'class' => 'input-sm' ,'id' => 'requestor_id'],
        'pluginOptions' => [
        'allowClear' => true],
        ]) ?>
    <div class="vendor">
        <?= $form->field($model, 'id_vendor')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Vendor::find()->all(), 'id','name'),
            'language' => 'en',
            // form-control select2-hidden-accessible
            'options' => ['placeholder' => 'Select Vendor', 'class' => 'input-sm', 'id'=>'vendor_id'],
            'pluginOptions' => [
            'allowClear' => true],
            ]) ?>

        <?= $form->field($model, 'team_name')->textInput(['id'=>'team_name_vendor_id']) ?>

        <?= $form->field($model, 'pic_vendor')->textInput() ?>
    </div>
    

    <?= $form->field($model->idDivision, 'nama')->textInput(['disabled'=>true]) ?>

    <?= $form->field($model, 'id_region')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Region::find()->all(), 'id','name'),
        'language' => 'en',
        // form-control select2-hidden-accessible
        'options' => ['placeholder' => 'Select '.$model->getAttributeLabel('id_region'), 'class' => 'input-sm'],
        'pluginOptions' => [
        'allowClear' => true],
        ]) ?>


    

    
    <div class="closeVendor">
        <?= $form->field($model, 'team_leader')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Labor::find()->all(), 'nik','nama'),
            'language' => 'en',
            // form-control select2-hidden-accessible
            'options' => ['placeholder' => 'Select Leader', 'class' => 'input-sm'],
            'pluginOptions' => [
            'allowClear' => true],
            ]) ?>
            
        <?= $form->field($model, 'team_name')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Reference::find()->where(['table_relation'=>'team_name'])->all(), 'description','description'),
            'language' => 'en',
            // form-control select2-hidden-accessible
            'options' => ['placeholder' => 'Select Team', 'class' => 'input-sm', 'id'=>'team_name_id'],
            'pluginOptions' => [
            'allowClear' => true],
            ]) ?>

    </div>
	
    <?= $form->field($model, 'file1')->fileInput() ?>

	<div class="form-group">
        <label class='control-label col-sm-4'> </label>
        <div class='col-sm-6'>
            <?php if (Yii::$app->controller->action->id == 'update') {
                echo Html::a(basename($model->file_attachment_1), ['downloadfile','id' => $model->id], $options = ['target'=>'_blank', 'data' => [
                        'method' => 'post',
                        'params' => [
                            'data' => 'file_attachment_1',
                        ]
                    ]]);
            } ?>
        </div>
    </div>
    <?= $form->field($model, 'file2')->fileInput() ?>
    <div class="form-group">
        <label class='control-label col-sm-4'> </label>
        <div class='col-sm-6'>
            <?php if (Yii::$app->controller->action->id == 'update') {
                echo Html::a(basename($model->file_attachment_2), ['downloadfile','id' => $model->id], $options = ['target'=>'_blank', 'data' => [
                        'method' => 'post',
                        'params' => [
                            'data' => 'file_attachment_2',
                        ]
                    ]]);
            } ?>
        </div>
    </div>
        <?= $form->field($model, 'file3')->fileInput() ?>
    <div class="form-group">
        <label class='control-label col-sm-4'> </label>
        <div class='col-sm-6'>
            <?php if (Yii::$app->controller->action->id == 'update') {
                echo Html::a(basename($model->file_attachment_3), ['downloadfile','id' => $model->id], $options = ['target'=>'_blank', 'data' => [
                        'method' => 'post',
                        'params' => [
                            'data' => 'file_attachment_3',
                        ]
                    ]]);
            } ?>
        </div>
    </div>

    <?= $form->field($model, 'purpose')->textArea() ?>
	
	<div class="form-group">
        <label class='control-label col-sm-4'> </label>
        <div class='col-sm-6'>
            <?php switch ($this->context->action->id) {
                case 'create':
                    $actionText = 'Create';
                    break;
                case 'createothers':
                    $actionText = 'Create';
                    break;
                case 'update':
                    $actionText = 'Update';
                    break;
                case 'updateothers':
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
        
        data.append( 'file1', $( '#grf-file1' )[0].files[0] );
        data.append( 'file2', $( '#grf-file2' )[0].files[0] );
        data.append( 'file3', $( '#grf-file3' )[0].files[0] );
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
                        $goto = '/indexdetail';
                        echo Url::to([$this->context->id.$goto, 'id' => $model->id]) ;?>');
                    $('#modalHeader').html('<h3>List Detail Barang</h3>');
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



$(document).ready(function () {
    val = $('#vendor_id').val();
    if(val != ''){
        $('.vendor').show();
        $('.closeVendor').hide();
    }else{
        $('.vendor').hide();
        $('.closeVendor').show();
    }
    $(document.body).on('change', '#requestor_id', function () {
        val = $('#requestor_id').val();
        if(val == 22 || val == 23 ) {
          $('.vendor').show();
          $('.closeVendor').hide();
        } else {
          $('.vendor').hide();
          $('.closeVendor').show();
        }
    });

});

$('#vendor_id').change(function() {
    var text = $('#vendor_id :selected').text();
    
    $('.vendor').show();
    $('#team_name_vendor_id').val(text);
});
</script>
