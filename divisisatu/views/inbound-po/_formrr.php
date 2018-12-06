<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use dosamigos\datepicker\DatePicker;

use common\models\MkmMasterItem;
use common\models\InboundPo;
use common\models\OrafinViewMkmPrToPay;

/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */
/* @var $form yii\widgets\ActiveForm */
// $this->registerJsFile('@common/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="inbound-po-form">

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
	
	
			<?= $form->field($model, 'po_number')->widget(Select2::classname(), [
				'data' => ArrayHelper :: map ( OrafinViewMkmPrToPay::find()->select(['po_num','po_num'])->where(['is not','rcv_no',null])->distinct()->all(), 'po_num','po_num'),
				'language' => 'en',
				'options' => ['placeholder' => 'Select PO Number ...','id'=>'po_number-id'],
				'pluginOptions' => [
					'allowClear' => true
				],
			]);?>
			
			<?php
				$depdropUnit = [
					'options'=>['id'=>'rr_number-id'],
					'type' => 2,
					'pluginOptions'=>[
						'depends'=>['po_number-id'],
						
						'placeholder'=>'Select Item',
						'url'=>Url::to(['/inbound-po/getrr']),
						'loadingText' => 'Loading ...',
					]
				];
				if (Yii::$app->controller->action->id == 'update') {
					
					$out = InboundPo::find()->where(['id'=>$model->id])->select('id as id,rr_number as name')->asArray()->all();
					$depdropUnit['data'] = ArrayHelper::map($out, 'id', 'name');
				}
				echo $form->field($model, 'rr_number')->widget(DepDrop::classname(), $depdropUnit);
				?>
			
			<?php
				if (Yii::$app->controller->action->id == 'update') {
					echo $form->field($modelOrafin, 'pr_num')->textInput(['disabled'=>true, 'id'=>'pr_number-id']);
					echo $form->field($modelOrafin, 'po_supplier')->textInput(['disabled'=>true, 'id'=>'supplier-id']);
					echo $form->field($modelOrafin, 'rcv_date')->textInput(['disabled'=>true, 'id'=>'rr_date-id']);
				}else{
					echo $form->field($model, 'pr_number')->textInput(['disabled'=>true, 'id'=>'pr_number-id']);
					echo $form->field($model, 'supplier')->textInput(['disabled'=>true, 'id'=>'supplier-id']);
					echo $form->field($model, 'rr_date')->textInput(['disabled'=>true, 'id'=>'rr_date-id']);
				}
			?>
			
			<?= $form->field($model, 'tgl_sj')->widget(
				DatePicker::className(),
				[ 'inline' => false,
					// 'addon' => false,
					'options' => ['id'=>'tgl_sj-id'],
					'clientOptions' => [
						'autoclose' => true,
						'format' => 'yyyy-mm-dd' ,
						// 'startDate' => $startdate,
					],
				]) ?>
				
			<?= $form->field($model, 'no_sj')->textInput([ 'id'=>'no_sj-id']);?>
			
			<?= $form->field($model, 'waranty')->textInput(['readOnly'=>true, 'id'=>'waranty-id']);?>
			
			
		

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
		
            <?= Html::button('Submitting...', ['id'=>'loadingButton','class' => 'btn btn-secondary', 'style'=>'display:none']) ?>
            
        </div>

    </div>
	
	
    <?php ActiveForm::end(); ?>
	

</div>
<script>
	$('#createButton').click(function (event) {
		// event.stopPropagation();
		var form = $('#createForm');
		data = form.data("yiiActiveForm");
		$.each(data.attributes, function() {
			this.status = 3;
		});
		form.yiiActiveForm("validate");
		if (!form.find('.has-error').length) {
            var button = $(this);
            button.prop('disabled', true);
            button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
            $.ajax({
                url: '<?php echo Url::to(['/inbound-po/'.$this->context->action->id, 'idInboundPo' => $model->id]) ;?>',
                type: 'post',
                data: form.serialize(),
                success: function (response) {
					if(response == 'success') {

						$('#modal').modal('show')
							.find('#modalContent')
							.load('<?php echo Url::to(['/inbound-po/indexdetail']) ;?>');
						$('#modalHeader').html('<h3>Inbound PO</h3>');
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

    $('#modal').removeAttr('tabindex');
	
	$('#rr_number-id').change(function() {
		console.log($('#rr_number-id :selected').val());
		$.ajax({
                url: 'getpr?rrNumber='+$('#rr_number-id :selected').val(),
                type: 'post',
                dataType: 'json',
				contentType: "application/json",
                success: function (response) {
					console.log(response['pr_number']);
					$('#pr_number-id').val(response['pr_number']);
					$('#supplier-id').val(response['supplier']);
					$('#rr_date-id').val(response['rr_date']);
				}
            });
	});
	
	$('#tgl_sj-id').change(function() {
		var startDate = $('#tgl_sj-id').val();
		myDate = new Date($('#tgl_sj-id').val());
		myDate.setFullYear(myDate.getFullYear() + 1);
		
		day = ''+myDate.getDate();
		month = ''+(myDate.getMonth()+1);
		year = myDate.getFullYear();
		
		if (month.length < 2) month = '0' + month;
		if (day.length < 2) day = '0' + day;

		var endDate = year + '-'+ month + '-'+ day;
		
		$('#waranty-id').val(startDate+' - '+endDate);
	});
	
	
</script>
