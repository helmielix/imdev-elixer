<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Labor */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
	.col-sm-6{
		max-height: 146px;
		overflow-y: auto;
	}
</style>

<div class="labor-form">

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
		])?>

    <?= $form->field($model, 'file')->fileInput()->label('File Excel')?>
	
	<div class="form-group">
		<label class='control-label col-sm-4'> </label>
		<div class='col-sm-6'>
			<?= Html::button('Upload', ['id'=>'createButton','class'=>'btn btn-success']) ?>
			<?= Html::button('Submitting', ['id'=>'loadingButton','class'=>'btn btn-info','style'=>'display:none']) ?>
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
			$('#createButton').hide(0);
			$('#loadingButton').show(0);
			data = new FormData();
			data.append( 'file', $( '#labor-file' )[0].files[0]);
			
			$.ajax({
				   url: '<?php echo Url::to(['/labor/create']) ;?>',
				  type: 'post',
				  data: data,
				  processData: false,
				  contentType: false,
				  success: function (response) {
						if(response == 'success') {
							$('#modal').modal('hide');
							setPopupAlert('Data has been saved.');
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
						$('#createButton').show(0);
						$('#loadingButton').hide(0);
					},
			 });
		 };
	});
</script>