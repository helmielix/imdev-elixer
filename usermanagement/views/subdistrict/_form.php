<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Region;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
?>

<div class="subdistrict-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="row">
		<div class="col-lg-3">
			<?= $form->field($modelRegion, 'id')->widget(Select2::classname(), [
							'data' => ArrayHelper::map(Region::find()->orderBy('name ASC')->all(),'id','name'),
							'language' => 'en',
							'options' => ['placeholder' => 'Select Region'],
							'pluginOptions' => [
							'allowClear' => true],
							]) ?>
			
			
			
			<?php if(!$model->isNewRecord) {
						echo $form->field($modelCity, 'name')->widget(DepDrop::classname(), [ 
							'data'=>[$model->idDistrict->id_city=>$model->idDistrict->idCity->name],
							'options'=>['id'=>'city-id'],
							'pluginOptions'=>[
								'depends'=>['region-id'],
								'placeholder'=>'Select City',
								'url'=>Url::to(['/district/getcity'])
							]
						]);
					} else {
						echo $form->field($modelCity, 'name')->widget(DepDrop::classname(), [ 
							'options'=>['id'=>'city-id'],
							'pluginOptions'=>[
								'depends'=>['region-id'],
								'placeholder'=>'Select District',
								'url'=>Url::to(['/district/getcity'])
							]
						]);
					}
			?>
			
			<?php if(!$model->isNewRecord) {
						echo $form->field($model, 'id_district')->widget(DepDrop::classname(), [ 
							'data'=>[$model->id_district=>$model->idDistrict->name],
							'pluginOptions'=>[
								'depends'=>['city-id'],
								'placeholder'=>'Select City',
								'url'=>Url::to(['/subdistrict/getdistrict'])
							]
						]);
					} else {
						echo $form->field($model, 'id_district')->widget(DepDrop::classname(), [ 
							'pluginOptions'=>[
								'depends'=>['city-id'],
								'placeholder'=>'Select City',
								'url'=>Url::to(['/subdistrict/getdistrict'])
							]
						]);
					}
			?>
			<?php 
				if(Yii::$app->controller->action->id == 'update'){
					$check = true;
				}else{
					$check = false;
				}
			?>
			<?= $form->field($model, 'id')->textInput(['maxlength' => true,'disabled'=>$check]) ?>
			
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
			
			<?= $form->field($model, 'zip_code')->textInput(['maxlength' => true]) ?>
		</div>
	</div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
