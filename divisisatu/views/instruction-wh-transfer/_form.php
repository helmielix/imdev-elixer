<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;
use kartik\select2\Select2;
use common\models\Reference;
use common\models\Warehouse;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\InstructionWhTransfer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="instruction-wh-transfer-form">

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

	<?= $form->field($model, 'instruction_number')->textInput(['disabled' => true]) ?>
	
    <?= $form->field($model, 'grf_number')->textInput(['maxlength' => true]) ?>
    
	<?= $form->field($model, 'delivery_target_date')->widget(
        DatePicker::className(),
        [ 'inline' => false,
            'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
			'endDate' => date('Y-m-d'),
		]
    ]) ?>
	
	<?php 
		$dataWarehouse = Warehouse::find()->all();
	?>
    <?= $form->field($model, 'wh_origin')->widget(Select2::classname(), [
		'data' => ArrayHelper::map($dataWarehouse, 'id','nama_warehouse'),
		// 'data' => $dataWarehouse,
		'language' => 'en',
		'options' => ['placeholder' => 'Select '.$model->getAttributeLabel('wh_origin')],
		'pluginOptions' => [
		'allowClear' => true],
		]) ?>
    <?= $form->field($model, 'wh_destination')->widget(Select2::classname(), [
		'data' => ArrayHelper::map($dataWarehouse, 'id','nama_warehouse'),
		// 'data' => $dataWarehouse,
		'language' => 'en',
		'options' => ['placeholder' => 'Select '.$model->getAttributeLabel('wh_destination')],
		'pluginOptions' => [
		'allowClear' => true],
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
        
        data.append( 'file', $( '#instructionwhtransfer-file' )[0].files[0] );
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
						echo Url::to([$this->context->id.$goto, 'id' => Yii::$app->session->get('idInstWhTr')]) ;?>');
					$('#modalHeader').html('<h3>Detail Instruksi Warehouse Transfer</h3>');
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
