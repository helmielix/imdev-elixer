<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;
use kartik\select2\Select2;
use common\models\Reference;
use common\models\MasterItemIm;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\InstructionWhTransfer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="instruction-wh-transfer-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'id' => 'updateForm',
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

	<?= $form->field($model->idOrafinCode, 'item_code')->textInput(['disabled' => true]) ?>
	<?= $form->field($model, 'qty_request')->textInput(['maxlength' => true]) ?>
	
	
	<div class="form-group">
        <label class='control-label col-sm-4'> </label>
        <div class='col-sm-6'>
            <?= Html::button('Update', ['id'=>'updateButton','class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
$('#updateButton').click(function () {
    var form = $('#updateForm');
    data = form.data("yiiActiveForm");
    $.each(data.attributes, function() {
      this.status = 3;
    });
    form.yiiActiveForm("validate");
    if (!form.find('.has-error').length) {
        data = new FormData(form[0]);
        
        var button = $(this);
        button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

		$.ajax({
			url: '<?php echo Url::to([$this->context->id.'/'.$this->context->action->id, 'idDetail' => $model->id]) ;?>',
			type: 'post',
			data: data,
			processData: false,
			contentType: false,
			success: function (response) {
				if(response == 'success') {					
					$('#modal').modal('show')
						.find('#modalContent')
						.load('<?php echo Url::to([$this->context->id.'/view', 'id' => Yii::$app->session->get('idInstWhTr')]) ;?>');
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
