<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\AREA;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\BASURVEY */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="basurvey-form">

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
		]); ?>


	<?= $form->field($model, 'file_iom')->fileInput() ?>
	
	<div class="form-group">
		<label class='control-label col-sm-4'> </label>
		<div class='col-sm-6'>
			<?php if ($model->file_iom_rollout != null) {
				echo Html::a(basename($model->file_iom_rollout), ['downloadfile', 'id' => $model->id], $options = ['target'=>'_blank', 'data' => [
						'method' => 'post',
						'params' => [
							'data' => 'file_iom_rollout',
							// 'path' => 'true'
						],
                    ]]);
			} ?>
		</div>
	</div>

	



	<div class="form-group">
		<label class='control-label col-sm-4'> </label>
		<div class='col-sm-6'>
			<?php switch ($this->context->action->id) {
				case 'create_iom':
					$actionText = 'Create';
					break;
				case 'update_iom':
					$actionText = 'Update';
					break;
			} ?>
			<?= Html::button('Submit', ['id'=>'createButton','class' => 'btn btn-primary']) ?>
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

			data = new FormData();
			data.append( 'file_iom', $( '#cabasurvey-file_iom' )[0].files[0]);
			<?php if (Yii::$app->controller->action->id == 'create_iom') :?>
				data.append( 'file_iom_terisi', '<?= $model->file_iom_rollout ?>');
			<?php endif; ?>
            var button = $(this);
            button.prop('disabled', true);
			 $.ajax({
				   url: '<?php echo Url::to(['/ca-ba-survey/'.$this->context->action->id, 'id' => $model->id]) ;?>',
				  type: 'post',
				  data: data,
				  processData: false,
				  contentType: false,
				  success: function (response) {
						if(response == 'success') {
							$('#modal').modal('hide');
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
                    },
			 });
		 };
	});


</script>
