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

	<?= $form->field($model->idMasterItemImDetail->idMasterItemIm, 'im_code')->textInput(['disabled' => true]) ?>
	<?= $form->field($model->idMasterItemImDetail->idMasterItemIm, 'name')->textInput(['disabled' => true]) ?>
	<?= $form->field($model->idMasterItemImDetail->idMasterItemIm, 'brand')->textInput(['disabled' => true]) ?>
	<?= $form->field($model->idMasterItemImDetail->idMasterItemIm, 'warna')->textInput(['disabled' => true]) ?>
	<?= $form->field($model->idMasterItemImDetail->idMasterItemIm->referenceSn, 'description')->textInput(['disabled' => true])->label('SN Type') ?>
	<?= $form->field($model, 'req_good')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'rem_good')->textInput(['disabled' => true]) ?>
	<?= $form->field($model, 'req_not_good')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'rem_not_good')->textInput(['disabled' => true]) ?>
	<?= $form->field($model, 'req_reject')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'rem_reject')->textInput(['disabled' => true]) ?>
	<?= $form->field($model, 'req_good_dismantle')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'rem_good_dismantle')->textInput(['disabled' => true]) ?>
	<?= $form->field($model, 'req_not_good_dismantle')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'rem_not_good_dismantle')->textInput(['disabled' => true]) ?>
	
	<div class="form-group">
        <label class='control-label col-sm-4'> </label>
        <div class='col-sm-6'>
			<?= Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-success']);  ?>
            <?= Html::button('Update', ['id'=>'updateButton','class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
$('#previousButton').click(function () {
	$('#modal').modal('show')
		.find('#modalContent')
		.load('<?php echo Url::to([$this->context->id.'/indexdetail','id'=>$model->id_instruction_wh]) ;?>');
	$('#modalHeader').html('<h3> Detail Instruksi Warehouse Transfer </h3>');
});
	
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
			dataType: 'json',
			success: function (response) {
				if(response.pesan == 'success') {
					$('#modal').modal('show')
						.find('#modalContent')
						.load('<?php echo Url::to([$this->context->id.'/indexdetail', 'id' => Yii::$app->session->get('idInstWhTr')]) ;?>');
					$('#modalHeader').html('<h3>Detail Instruksi Warehouse Transfer</h3>');
				} else {
					$('#instructionwhtransferdetail-rem_good').val(response.rem_good);
					$('#instructionwhtransferdetail-rem_not_good').val(response.rem_not_good);
					$('#instructionwhtransferdetail-rem_reject').val(response.rem_reject);
					$('#instructionwhtransferdetail-rem_good_dismantle').val(response.rem_good_dismantle);
					$('#instructionwhtransferdetail-rem_not_good_dismantle').val(response.rem_not_good_dismantle);
					alert('error with message: ' + response.pesan);
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
