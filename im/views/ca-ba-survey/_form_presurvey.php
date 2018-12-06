<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\CaIomAndCity;
use app\models\CaReference;
use yii\bootstrap\ActiveForm;
use kartik\depdrop\DepDrop;
use dosamigos\datepicker\DatePicker;
?>
<style>
	.col-sm-6{
		max-height: 146px;
		overflow-y: auto;
	}
</style>
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
			'requiredCssClass' => 'requiredField'
		]); ?>


		<?php
			$isDisabled = false;
			if (Yii::$app->controller->action->id == 'create_presurvey'){
				$isDisabled = false;
			}
			else if (Yii::$app->controller->action->id == 'update_presurvey'){
				$isDisabled = true;
			}
		?>

		    <?php
				$query = CaIomAndCity::find()
					->joinWith(['idCity.idRegion'],false)
					->joinWith(['idCaIomAreaExpansion'],false)
					->where(['ca_iom_area_expansion.status'=> 5])
					->select('region.id, region.name')
					;
				if (Yii::$app->controller->action->id == 'create_presurvey'){
					echo $form->field($modelRegion, 'name')->dropDownList(
						ArrayHelper::map($query->asArray()->all(),'id','name'),
						['id'=>'region-id','prompt'=>'Select Region'])->label('Region');
				} else if (Yii::$app->controller->action->id == 'update_presurvey'){
					echo $form->field($modelRegion, 'name')->textInput(['disabled'=>$isDisabled])->label('Region');
				}
			?>


			<?php
				if (Yii::$app->controller->action->id == 'create_presurvey'){
					echo $form->field($modelCity, 'name')->widget(DepDrop::classname(), [
					'options'=>['id'=>'city-id'],
						'pluginOptions'=>[
							'depends'=>['region-id'],
							'placeholder'=>'Select City',
							'url'=>Url::to(['/site/getcityapproved'])
						]
					]);
				} else if (Yii::$app->controller->action->id == 'update_presurvey'){
					echo $form->field($modelCity, 'name')->textInput(['disabled'=>$isDisabled]);
				}
			?>

			<?php
				if (Yii::$app->controller->action->id == 'create_presurvey'){
					echo $form->field($modelIom, 'no_iom_area_exp')->widget(DepDrop::classname(), [
					'options'=>['id'=>'iom-id'],
						'pluginOptions'=>[
							'depends'=>['city-id'],
							'placeholder'=>'Select IOM',
							'url'=>Url::to(['/site/getiombycity'])
						]
					]);
				} else if (Yii::$app->controller->action->id == 'update_presurvey'){
					echo $form->field($model, 'no_iom')->textInput(['disabled'=>$isDisabled]);
				}
			?>

			<?php
				if (Yii::$app->controller->action->id == 'create_presurvey'){
						echo $form->field($modelDistrict, 'name')->widget(DepDrop::classname(), [
						'options'=>['id'=>'district-id'],
							'pluginOptions'=>[
								'depends'=>['iom-id'],
								'placeholder'=>'Select District',
								'url'=>Url::to(['/site/getdistrictbyiom'])
							]
						]);
				} else if (Yii::$app->controller->action->id == 'update_presurvey'){
					echo $form->field($modelDistrict, 'name')->textInput(['disabled'=>$isDisabled]);
				}
			?>

			<?php
				if (Yii::$app->controller->action->id == 'create_presurvey'){
					echo $form->field($modelArea, 'id_subdistrict')->widget(DepDrop::classname(), [
						'options'=>['id'=>'subdistrict-id'],
							'pluginOptions'=>[
								'depends'=>['district-id'],
								'placeholder'=>'Select Subdistrict',
								'url'=>Url::to(['/site/getsubdistrict']),
								
							]
					]);
				} else if (Yii::$app->controller->action->id == 'update_presurvey'){
					echo $form->field($model->idArea->idSubdistrict, 'name')->textInput(['disabled'=>$isDisabled, 'data-value'=>$model->idArea->idSubdistrict->id]);
				}
			?>
			
			<?php
				if (Yii::$app->controller->action->id == 'create_presurvey'){
					echo $form->field($model, 'survey_date')->widget(
									DatePicker::className(), [
										'clientOptions' => [
											'autoclose' => true,
											'format' => 'yyyy/mm/dd'
										]
								]);
				} else if (Yii::$app->controller->action->id == 'update_presurvey'){
					echo $form->field($model, 'survey_date')->textInput(['disabled'=>$isDisabled]);
				}
			?>
			
			

			<?= $form->field($model, 'rw')->textInput(['maxlength' => true])->label('RW')?>

			<?php if (Yii::$app->controller->action->id == 'update_presurvey') {
				$area = explode('/',$model->id_area);
				$model->owner = $area[3];
				$model->rw = $area[4];
			} ?>
            <?= $form->field($model, 'owner')->dropDownList(['RW' => 'RW', 'KL' => 'Kepling', 'KB'=>'Klian Banjar', 'DV'=>'Developer'],['prompt'=>'Please select Owner']) ?>

			<?php
				echo $form->field($model, 'estimasi_homepass')->textInput();
			?>

			<?= $form->field($model, 'id_area')->textInput([ 'disabled'=>true],['id'=>'area-id']) ?>

            <?= $form->field($model, 'location_description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
		<label class='control-label col-sm-4'> </label>
		<div class='col-sm-6'>
			<?php 
				
				switch ($this->context->action->id) {
					case 'create_presurvey':
						$actionText = 'Create';
						break;
					case 'update_presurvey':
						$actionText = 'Update';
						break;
				} 
			?>
			<?= Html::button($actionText, ['id'=>'createButton','class'=>'btn btn-success']) ?>
			<?= Html::button('Submitting', ['id'=>'loadingButton','class'=>'btn btn-info','style'=>'display:none']) ?>
		</div>
	</div>


    <?php ActiveForm::end(); ?>

</div>

<script>
	var id_area ='';
	
	<?php 
		if (Yii::$app->controller->action->id == 'update_presurvey'){
	?>
		$('#cabasurvey-rw,#cabasurvey-owner').change(function(){
			console.log($('#cabasurvey-rw').val());
			console.log($('#subdistrict-name').attr('data-value'));
			if($('#subdistrict-name').attr('data-value') != null && $('#cabasurvey-rw').val() !='' && $('#cabasurvey-owner').val() !='') {
				owner = '';
				switch($('#cabasurvey-owner').val()) {
					case 'RW':
						owner = 'RW'; break;
					case 'KL':
						owner = 'KL'; break;
					case 'KB':
						owner = 'KB'; break;
					case 'DV':
						owner = 'DV'; break;
				}
				id_area = $('#subdistrict-name').attr('data-value').substring(0,2)+'/'+$('#subdistrict-name').attr('data-value').substring(2,5)+'/'+$('#subdistrict-name').attr('data-value').substring(5,10)+'/'+owner+'/'+$('#cabasurvey-rw').val();
				$('#cabasurvey-id_area').val(id_area);

			}
		});
	<?php 
		} else {
	?>
		$('#subdistrict-id,#cabasurvey-rw,#cabasurvey-owner').change(function(){
		if($('#subdistrict-id').val() != null && $('#cabasurvey-rw').val() !='' && $('#cabasurvey-owner').val() !='') {
			owner = '';
			switch($('#cabasurvey-owner').val()) {
				case 'RW':
					owner = 'RW'; break;
				case 'KL':
					owner = 'KL'; break;
				case 'KB':
					owner = 'KB'; break;
				case 'DV':
					owner = 'DV'; break;
			}
			id_area = $('#subdistrict-id').val().substring(0,2)+'/'+$('#subdistrict-id').val().substring(2,5)+'/'+$('#subdistrict-id').val().substring(5,10)+'/'+owner+'/'+$('#cabasurvey-rw').val();
			$('#cabasurvey-id_area').val(id_area);

		}
	});
	<?php
		}
	?>
	tempArr = [];

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
			data.append( 'CaBaSurvey[id_area]', $( '#cabasurvey-id_area' ).val() );
			data.append( 'CaBaSurvey[location_description]', $( '#cabasurvey-location_description' ).val() );
			data.append( 'CaBaSurvey[owner]', $( '#cabasurvey-owner' ).val() );
			data.append( 'CaBaSurvey[rw]', $( '#cabasurvey-rw' ).val());
			data.append( 'CaBaSurvey[survey_date]', $( '#cabasurvey-survey_date' ).val());
			data.append( 'CaBaSurvey[estimasi_homepass]', $( '#cabasurvey-estimasi_homepass' ).val());
			<?php 
				if (Yii::$app->controller->action->id == 'update_presurvey'){
			?>
				data.append( 'Area[id_subdistrict]', $('#subdistrict-name').attr('data-value'));
			<?php
				}else{
			?>
				data.append( 'Area[id_subdistrict]', $( '#subdistrict-id' ).val() );
			<?php
				}
			?>
			
			data.append( 'CaIomAreaExpansion[no_iom_area_exp]', $( '#iom-id option:selected' ).text() );
			 $.ajax({
				   url: '<?php echo Url::to(['/ca-ba-survey/'.$this->context->action->id, 'id' => $model->id]) ;?>',
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
