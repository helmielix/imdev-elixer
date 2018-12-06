<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\CaIomAndCity;
use app\models\CaReference;
use app\models\CaBaSurveyReference;
use yii\bootstrap\ActiveForm;
use kartik\depdrop\DepDrop;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use app\models\Labor;
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
			if (Yii::$app->controller->action->id == 'create'){
				$isDisabled = false;
			}
			else if (Yii::$app->controller->action->id == 'update'){
				$isDisabled = true;
			}
		?>

		    <?php
				$query = CaIomAndCity::find()
					->joinWith(['idCity.idRegion'],false)
					->joinWith(['idIom.id_iom'],false)
					->where(['ca_iom_area_expansion.status'=> 5])
					->select('region.id, region.name')
					;
				if (Yii::$app->controller->action->id == 'create'){
					echo $form->field($modelRegion, 'name')->dropDownList(
						ArrayHelper::map($query->asArray()->all(),'id','name'),
						['id'=>'region-id','prompt'=>'Select Region'])->label('Region');
				} else if (Yii::$app->controller->action->id == 'update'){
					echo $form->field($modelRegion, 'name')->textInput(['disabled'=>$isDisabled])->label('Region');
				}
			?>


			<?php
				if (Yii::$app->controller->action->id == 'create'){
					echo $form->field($modelCity, 'name')->widget(DepDrop::classname(), [
					'options'=>['id'=>'city-id'],
						'pluginOptions'=>[
							'depends'=>['region-id'],
							'placeholder'=>'Select City',
							'url'=>Url::to(['/site/getcityapproved'])
						]
					]);
				} else if (Yii::$app->controller->action->id == 'update'){
					echo $form->field($modelCity, 'name')->textInput(['disabled'=>$isDisabled]);
				}
			?>

			<?php
				if (Yii::$app->controller->action->id == 'create'){
					echo $form->field($modelIom, 'no_iom_area_exp')->widget(DepDrop::classname(), [
					'options'=>['id'=>'iom-id'],
						'pluginOptions'=>[
							'depends'=>['city-id'],
							'placeholder'=>'Select IOM',
							'url'=>Url::to(['/site/getiombycity'])
						]
					]);
				} else if (Yii::$app->controller->action->id == 'update'){
					echo $form->field($model, 'no_iom')->textInput(['disabled'=>$isDisabled]);
				}
			?>

			<?php
				if (Yii::$app->controller->action->id == 'create'){
						echo $form->field($modelDistrict, 'name')->widget(DepDrop::classname(), [
						'options'=>['id'=>'district-id'],
							'pluginOptions'=>[
								'depends'=>['iom-id'],
								'placeholder'=>'Select District',
								'url'=>Url::to(['/site/getdistrictbyiom'])
							]
						]);
				} else if (Yii::$app->controller->action->id == 'update'){
					echo $form->field($modelDistrict, 'name')->textInput(['disabled'=>$isDisabled]);
				}
			?>

			<?php
				if (Yii::$app->controller->action->id == 'create'){
					echo $form->field($modelArea, 'id_subdistrict')->widget(DepDrop::classname(), [
						'options'=>['id'=>'subdistrict-id'],
							'pluginOptions'=>[
								'depends'=>['district-id'],
								'placeholder'=>'Select Subdistrict',
								'url'=>Url::to(['/site/getsubdistrict'])
							]
					]);
				} else if (Yii::$app->controller->action->id == 'update'){
					echo $form->field($modelArea->idSubdistrict, 'name')->textInput(['disabled'=>$isDisabled]);
				}
			?>



			<?php if (Yii::$app->controller->action->id == 'update') {
				$area = explode('/',$model->id_area);
				$model->owner = $area[3];
				$model->rw = $area[4];
			} ?>
			<?php
				if (Yii::$app->controller->action->id == 'update') {
					echo $form->field($model, 'owner')->textInput(['disabled' => true]);
					echo $form->field($model, 'rw')->textInput(['disabled' => true])->label('RW');
				}else{
					echo $form->field($model, 'owner')->dropDownList(['RW' => 'RW', 'KL' => 'Kepling', 'KB'=>'Klian Banjar', 'DV'=>'Developer'],['prompt'=>'Please select Owner']);
					echo $form->field($model, 'rw')->textInput(['maxlength' => true])->label('RW');
				}
			?>



			<?= $form->field($model, 'id_area')->textInput(['maxlength' => true, 'disabled'=>true],['id'=>'area-id']) ?>

			<?= $form->field($model, 'survey_date')->widget(
                DatePicker::classname(), [
					'inline' => false,
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
						'endDate' => Date('Y-m-d'),
						'todayBtn' => 'linked',
                    ],
            ]);?>

            <?= $form->field($model, 'location_description')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'iom_type')->radioList([201=>'IOM Roll Out', 202=>'IOM Special Request']); ?>




			<?php
				if ($model->load(Yii::$app->request->post($model->iom_type = 202))){
					echo $form->field($model, 'pic_special_request')->textInput(['maxlength' => true]);
				}
			?>

			<?= $form->field($model, 'pic_iom_special')->widget(Select2::classname(), [
			  'data' => ArrayHelper:: map ( Labor:: find()->select([new \yii\db\Expression('name || \' - \' || nik as name'), 'nik'])->where(['division'=>8])->orderBy(['name'=>SORT_ASC])-> all(), 'nik','name'),
			  'language' => 'en',
			  'options' => ['placeholder' => 'Select Leader'],
			  'pluginOptions' => [
			  'allowClear' => true],
			  ]) ?>

			<?= $form->field($model, 'notes')->textArea() ?>

			<?= $form->field($model, 'pic_survey')->widget(Select2::classname(), [
	            'data' => ArrayHelper :: map ( Labor :: find()->select([new \yii\db\Expression('name || \' - \' || nik as name'), 'nik'])->where(['division'=>8])->orderBy(['name'=>SORT_ASC])-> all(), 'nik','name'),
	            'language' => 'en',
	            'options' => ['placeholder' => 'Select PIC Survey'],
	            'pluginOptions' => [
	                'allowClear' => true,
	            ],
	        ]); ?>

			<?= $form->field($model, 'contact_survey')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'file_xls')->fileInput()->label('File Excel')?>
			<label class='control-label col-sm-4'> </label>
			<div class='col-sm-6'>
			<?php
				if (Yii::$app->controller->action->id == 'update') {
					echo Html::a(basename($model->xls_file), ['downloadfile', 'id' => $model->id], $options = ['target'=>'_blank', 'data' => [
							'method' => 'post',
							'params' => [
								'data' => 'xls_file',
								// 'path' => 'true'
							],
							]]);
				}
			?>
			</div>
			<div class="form-group">
				<label class='control-label col-sm-4'> </label>
				<div class='col-sm-6'>

				</div>
			</div>
			<?= $form->field($model, 'file_doc')->fileInput() ?>
			<div class="form-group">
				<label class='control-label col-sm-4'> </label>
				<div class='col-sm-6'>
					<?php if (Yii::$app->controller->action->id == 'update') {
						echo Html::a(basename($model->doc_file), ['downloadfile', 'id' => $model->id], $options = ['target'=>'_blank', 'data' => [
							'method' => 'post',
							'params' => [
								'data' => 'doc_file',
								// 'path' => 'true'
							],
							]]);
					}?>
				</div>
			</div>

			<?= $form->field($model, 'file_pdf')->fileInput() ?>
			<div class="form-group">
				<label class='control-label col-sm-4'> </label>
				<div class='col-sm-6'>
					<?php if (Yii::$app->controller->action->id == 'update') {
						echo Html::a(basename($model->pdf_file), ['downloadfile', 'id' => $model->id], $options = ['target'=>'_blank', 'data' => [
							'method' => 'post',
							'params' => [
								'data' => 'pdf_file',
								// 'path' => 'true'
							],
							]]);
					}?>
				</div>
			</div>

            <?php $model->property_area_type = ArrayHelper::getColumn(CaBaSurveyReference::find()->select(['id_ca_reference'])->andFilterWhere(['and',['id_ca_ba_survey'=>$model->id],['in','id_ca_reference',[9,3,47]]])->asArray()->all(), 'id_ca_reference'); ?>
			<?php $arr_property_area_type =  ArrayHelper::map(CaReference::find()->where(['name'=>'property_area_type','status'=>27])->asArray()->all(),'id','value'); ?>
			<?= $form->field($model, 'property_area_type')->checkboxList($arr_property_area_type, ['prompt' => 'Select Area Propety Type']) ?>

            <?php $model->house_type =  ArrayHelper::getColumn(CaBaSurveyReference::find()->select(['id_ca_reference'])->andFilterWhere(['and',['id_ca_ba_survey'=>$model->id],['in','id_ca_reference',[2,6,7,10]]])->asArray()->all(), 'id_ca_reference');?>
			<?php $arr_house_type =  ArrayHelper::map(CaReference::find()->where(['name'=>'house_type','status'=>27])->asArray()->all(),'id','value'); ?>
            <?= $form->field($model, 'house_type')->checkboxList($arr_house_type, ['prompt' => 'Select Area Propety Type']) ?>

			<?php $model->avr_occupancy_rate = ArrayHelper::getColumn(CaBaSurveyReference::find()->andFilterWhere(['and',['id_ca_ba_survey'=>$model->id],['in','id_ca_reference',[16,17,18,19,20,21,22,23,24,25]]])->asArray()->all(), 'id_ca_reference'); ?>
			<?php $avr_occupancy_rate =  ArrayHelper::map(CaReference::find()->where(['name'=>'avr_occupancy_rate','status'=>27])->orderBy(['id'=>SORT_ASC])->asArray()->all(),'id','value'); ?>
            <?= $form->field($model, 'avr_occupancy_rate')->dropDownList($avr_occupancy_rate, ['prompt' => 'Select Average Ocupancy Level']) ?>

            <?php $model->myr_population_hv = ArrayHelper::getColumn(CaBaSurveyReference::find()->select(['id_ca_reference'])->andFilterWhere(['and',['id_ca_ba_survey'=>$model->id],['in','id_ca_reference',[26,27]]])->asArray()->all(), 'id_ca_reference');?>
			<?php $myr_population_hv =  ArrayHelper::map(CaReference::find()->where(['name'=>'myr_population_hv','status'=>27])->asArray()->all(),'id','value'); ?>
            <?= $form->field($model, 'myr_population_hv')->checkboxList($myr_population_hv, ['prompt' => 'Select Majority of Occupant']) ?>

            <?php $model->dev_method = ArrayHelper::getColumn(CaBaSurveyReference::find()->select(['id_ca_reference'])->andFilterWhere(['and',['id_ca_ba_survey'=>$model->id],['in','id_ca_reference',[28,29,30]]])->asArray()->all(), 'id_ca_reference');?>
			<?php $dev_method =  ArrayHelper::map(CaReference::find()->where(['name'=>'dev_method','status'=>27])->asArray()->all(),'id','value'); ?>
			<?= $form->field($model, 'dev_method')->checkboxList($dev_method, ['prompt' => 'Select Methods of Development']) ?>

            <?php $model->access_to_sell = ArrayHelper::getColumn(CaBaSurveyReference::find()->select(['id_ca_reference'])->andFilterWhere(['and',['id_ca_ba_survey'=>$model->id],['in','id_ca_reference',[31,32,33]]])->asArray()->all(), 'id_ca_reference');?>
			<?php $access_to_sell =  ArrayHelper::map(CaReference::find()->where(['name'=>'access_to_sell','status'=>27])->asArray()->all(),'id','value'); ?>
            <?= $form->field($model, 'access_to_sell')->checkboxList($access_to_sell, ['prompt' => 'Select Access to Sales']) ?>

			<div>
            <?php $model->competitors = ArrayHelper::getColumn(CaBaSurveyReference::find()->select(['id_ca_reference'])->andFilterWhere(['and',['id_ca_ba_survey'=>$model->id],['in','id_ca_reference',[34,35,36,37,38,39]]])->asArray()->all(), 'id_ca_reference');?>
			<?php $competitors =  ArrayHelper::map(CaReference::find()->where(['name'=>'competitors','status'=>27])->asArray()->all(),'id','value'); ?>
            <?= $form->field($model, 'competitors')->checkboxList($competitors, ['prompt' => 'Select Area Propety Type']) ?>
			</div>

            <?php $model->occupancy_use_dth = ArrayHelper::getColumn(CaBaSurveyReference::find()->select(['id_ca_reference'])->andFilterWhere(['and',['id_ca_ba_survey'=>$model->id],['in','id_ca_reference',[40,41,42,43,44]]])->asArray()->all(), 'id_ca_reference');?>
			<?php $occupancy_use_dth =  ArrayHelper::map(CaReference::find()->where(['name'=>'occupancy_use_dth','status'=>27])->asArray()->all(),'id','value'); ?>
            <?= $form->field($model, 'occupancy_use_dth')->checkboxList($occupancy_use_dth, ['prompt' => 'Select Area Propety Type']) ?>


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
			<?= Html::button($actionText, ['id'=>'createButton','class'=>'btn btn-success']) ?>
			<?= Html::button('Need Permit', ['id'=>'repermitButton','class'=>'btn btn-warning']) ?>
			<?= Html::button('Submitting', ['id'=>'loadingButton','class'=>'btn btn-info','style'=>'display:none']) ?>
		</div>
	</div>


    <?php ActiveForm::end(); ?>

</div>

<script>
	var id_area ='';
	$(document).ready(function(){
		if($( 'input[name="CaBaSurvey\\[iom_type\\]"]:checked' ).val() == 202) {
			$( '.field-cabasurvey-pic_iom_special' ).show();
			$( '#iom-id').show();
		} else {
			$( '.field-cabasurvey-pic_iom_special' ).hide();
			$( '#iom-id').hide();
		}
	});

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
	tempArr = [];

	$( 'input[name="CaBaSurvey\\[iom_type\\]"]' ).change(function(){
		console.log($( 'input[name="CaBaSurvey\\[iom_type\\]"]:checked' ).val());
		if($( 'input[name="CaBaSurvey\\[iom_type\\]"]:checked' ).val() == 202) {
			$( '.field-cabasurvey-pic_iom_special' ).show();
			$( '#iom-id').show();
		} else {
			$( '.field-cabasurvey-pic_iom_special' ).hide();
			$( '#iom-id').hide();
		}
	});





	$('#repermitButton').click(function () {
        var button = $(this);
        button.prop('disabled', true);
		$.ajax({
			url: '<?php echo Url::to(['/ca-ba-survey/repermit', 'id' => $model->id]) ;?>',
			type: 'post',
			success: function (response) {
				if(response == 'success') {
					$('#modal').modal('hide');
					setPopupAlert('Data has been verified.');
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
	});

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
			data.append( 'CaBaSurvey[survey_date]', $( '#cabasurvey-survey_date' ).val() );
			data.append( 'CaBaSurvey[location_description]', $( '#cabasurvey-location_description' ).val() );
			data.append( 'CaBaSurvey[owner]', $( '#cabasurvey-owner' ).val() );
			data.append( 'CaBaSurvey[iom_type]', $( 'input[name="CaBaSurvey\\[iom_type\\]"]:checked' ).val() );
			data.append( 'CaBaSurvey[notes]', $( '#cabasurvey-notes' ).val() );
			data.append( 'CaBaSurvey[pic_survey]', $( '#cabasurvey-pic_survey' ).val() );
			data.append( 'CaBaSurvey[contact_survey]', $( '#cabasurvey-contact_survey' ).val() );
			data.append( 'CaBaSurvey[pic_iom_special]', $( '#cabasurvey-pic_iom_special' ).val());
			data.append( 'CaBaSurvey[qty_soho_pot]', 0);
			data.append( 'CaBaSurvey[qty_hp_pot]', 0);
			data.append( 'CaBaSurvey[rw]', $( '#cabasurvey-rw' ).val());
			tempArr = [];
			$("input:checkbox[name=CaBaSurvey\\[property_area_type\\]\\[\\]]:checked").each(function(){
				tempArr.push($(this).val());
			});
			data.append( 'CaBaSurvey[property_area_type]', tempArr );

			tempArr = [];
			$("input:checkbox[name=CaBaSurvey\\[house_type\\]\\[\\]]:checked").each(function(){
				tempArr.push($(this).val());
			});
			data.append( 'CaBaSurvey[house_type]', tempArr );
			data.append( 'CaBaSurvey[avr_occupancy_rate]', $( '#cabasurvey-avr_occupancy_rate' ).val() );
			tempArr = [];
			$("input:checkbox[name=CaBaSurvey\\[myr_population_hv\\]\\[\\]]:checked").each(function(){
				tempArr.push($(this).val());
			});
			data.append( 'CaBaSurvey[myr_population_hv]', tempArr );
			tempArr = [];
			$("input:checkbox[name=CaBaSurvey\\[dev_method\\]\\[\\]]:checked").each(function(){
				tempArr.push($(this).val());
			});
			data.append( 'CaBaSurvey[dev_method]', tempArr );
			tempArr = [];
			$("input:checkbox[name=CaBaSurvey\\[access_to_sell\\]\\[\\]]:checked").each(function(){
				tempArr.push($(this).val());
			});
			data.append( 'CaBaSurvey[access_to_sell]', tempArr );
			tempArr = [];
			$("input:checkbox[name=CaBaSurvey\\[competitors\\]\\[\\]]:checked").each(function(){
				tempArr.push($(this).val());
			});
			data.append( 'CaBaSurvey[competitors]', tempArr );
			tempArr = [];
			$("input:checkbox[name=CaBaSurvey\\[occupancy_use_dth\\]\\[\\]]:checked").each(function(){
				tempArr.push($(this).val());
			});
			data.append( 'CaBaSurvey[occupancy_use_dth]', tempArr );
			data.append( 'Area[id_subdistrict]', $( '#subdistrict-id' ).val() );
			data.append( 'file_xls', $( '#cabasurvey-file_xls' )[0].files[0]);
			data.append( 'file_doc', $( '#cabasurvey-file_doc' )[0].files[0]);
			data.append( 'file_pdf', $( '#cabasurvey-file_pdf' )[0].files[0]);
			for (var pair of data.entries())
			{
			 console.log(pair[0]+ ', '+ pair[1]);
			}
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
