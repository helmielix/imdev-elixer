<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
use yii\web\UploadedFile;
use yii\bootstrap\Alert;
use yii\filters\VerbFilter;
use kartik\select2\Select2;
use yii\web\JsExpression;
use kartik\money\MaskMoney;

?>

<div class="govrel-par-bbfeed-permit-form">

  <?php $isReadOnly = (\Yii::$app->controller->action->id != 'create' && \Yii::$app->controller->action->id != 'update'); ?>

     <?php $form = ActiveForm::begin([
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

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'status_par')->radiolist([27 => 'Active', 18 => 'Non Active']) ?>

    <div class="form-group">
		<label class='control-label col-sm-4'> </label>
               <div class = 'row'>
		<div class='col-sm-4'>
			<?php switch ($this->context->action->id) {
				case 'create':
					$actionText = 'Create';
					break;
				case 'update':
					$actionText = 'Update';
					break;
			} ?>
			<?php if($isReadOnly){echo Html::button('Revisi', ['class' => 'btn btn-warning' ,'name' => 'btnRevisi']) ;}?>
			<?= Html::button($actionText, ['id'=>'createButton','class' => 'btn btn-success']) ?>
            <?= Html::button('Submitting...', ['id'=>'loadingButton','class' => 'btn btn-secondary', 'style'=>'display:none']) ?>
		</div>
                <div class='col-sm-6'>

                </div
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
				  url: '<?php echo Url::to(['/govrel-par-bbfeed-permit/'.$this->context->action->id, 'id' => $model->id]) ;?>',
				  type: 'post',
				  data: form.serialize(),
				  success: function (response) {
						if(response == 'success') {
							$('#modal').modal('hide');
							setPopupAlert('Data has been saved.');
							//window.location.reload();
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
</script>
