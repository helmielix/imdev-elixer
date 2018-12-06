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
$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="inbound-wh-transfer-form">

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
	
			
			<?= $form->field($model, 'arrival_date')->widget(
				DatePicker::className(),
				[ 'inline' => false,
					// 'addon' => false,
					'options' => ['id'=>'arrival_date-id'],
					'clientOptions' => [
						'autoclose' => true,
						'format' => 'yyyy-mm-dd' ,
						// 'startDate' => $startdate,
					],
				]) ?>
				
			
			
		

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
	$('#createButton').click(function () {
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
                url: '<?php echo Url::to(['/inbound-wh-transfer/'.$this->context->action->id, 'idOutboundWh' => $model->id_outbound_wh]) ;?>',
                type: 'post',
                data: form.serialize(),
                success: function (response) {
					if(response == 'success') {
						$('#modal').modal('show')
							.find('#modalContent')
							.load('<?php echo Url::to(['/inbound-wh-transfer/'.Yii::$app->session->get('action')]) ;?>');
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

    // $('#modal').removeAttr('tabindex');
	
	
	
</script>
