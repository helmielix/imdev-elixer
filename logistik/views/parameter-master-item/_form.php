<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;
use kartik\select2\Select2;
use common\models\Reference;
use common\models\MasterItemIm;
use kartik\depdrop\DepDrop;
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
    
    <?php 
        $dataItem = MasterItemIm::find()->select('distinct(name)')->all();
    ?>

   
	<?php
        if (Yii::$app->controller->action->id == 'create'){
			echo $form->field($model, 'item_name')->dropDownList(
				ArrayHelper::map($dataItem, 'name','name'),
				['id'=>'item_name-id','prompt'=>'Select..'])->label('Nama Barang');
		} else if (Yii::$app->controller->action->id == 'update'){
			echo $form->field($model, 'item_name')->textInput(['disabled'=>$isDisabled])->label('Nama Barang');
		}
	?>

	
     <?php
		if (Yii::$app->controller->action->id == 'create'){
			echo $form->field($model, 'item_orafin')->widget(DepDrop::classname(), [
			'options'=>['id'=>'item_orafin-id'],
				'pluginOptions'=>[
					'depends'=>['item_name-id'],
					'placeholder'=>'Select..',
					'url'=>Url::to(['/parameter-master-item/getorafin'])
				]
			])->label('Orafin Code');
		} else if (Yii::$app->controller->action->id == 'update'){
			echo $form->field($model, 'item_orafin')->textInput(['disabled'=>$isDisabled]);
		}
	?>
    
    <?php
		if (Yii::$app->controller->action->id == 'create'){
			echo $form->field($model, 'id_item')->widget(DepDrop::classname(), [
			'options'=>['id'=>'item-id'],
				'pluginOptions'=>[
					'depends'=>['item_orafin-id'],
					'placeholder'=>'Select..',
					'url'=>Url::to(['/parameter-master-item/getim'])
				]
			])->label('IM Code');
		} else if (Yii::$app->controller->action->id == 'update'){
			echo $form->field($model, 'id_item')->textInput(['disabled'=>$isDisabled]);
		}
	?>
    
	<?= $form->field($model, 'grouping')->textInput(['readOnly'=>true, 'id'=>'grouping-id']);?>

	<?= $form->field($model, 'brand')->textInput(['readOnly'=>true, 'id'=>'brand-id']);?>
	<?= $form->field($model, 'type')->textInput(['readOnly'=>true, 'id'=>'type-id']);?>
	<?= $form->field($model, 'warna')->textInput(['readOnly'=>true, 'id'=>'warna-id']);?>
	<?= $form->field($model, 'uom')->textInput(['readOnly'=>true, 'id'=>'uom-id']);?>
	<?= $form->field($model, 'sn')->textInput(['readOnly'=>true, 'id'=>'sn-id']);?>
    
	
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
$('#item-id').change(function() {
		console.log($('#rr_number-id :selected').val());
		$.ajax({
                url: 'getitemdetail?id='+$('#item-id :selected').val(),
                type: 'post',
                dataType: 'json',
				contentType: "application/json",
                success: function (response) {
					console.log(response['im_code']);
					$('#grouping-id').val(response['grouping']);
					$('#brand-id').val(response['brand']);
					$('#type-id').val(response['type']);
					$('#warna-id').val(response['warna']);
					$('#uom-id').val(response['uom']);
					$('#sn-id').val(response['sn']);
				}
            });
	});

$('#createButton').click(function () {
    var form = $('#createForm');
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
						// $goto = ($model->isNewRecord) ? '/indexdetail' : '/view';
						$goto = '/indexdetail';
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
