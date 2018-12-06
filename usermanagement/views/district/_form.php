<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Region;
use kartik\depdrop\DepDrop;

?>

<div class="district-form">

    <?php $form = ActiveForm::begin(); ?>

	<?php 
		if(Yii::$app->controller->action->id == 'update'){
			$check = true;
		}else{
			$check = false;
		}
	?>
	<div class="row">
		<div class="col-lg-3">
			<?= $form->field($modelRegion, 'id')->dropDownList(
					ArrayHelper::map(Region::find()->orderBy(['name'=>SORT_ASC])->all(),'id','name'), 
					['id'=>'region-id','prompt'=>'Select Region','disabled'=>$check])->label('Region');
			?>
			
			
			<?php if(!$model->isNewRecord) {
						echo $form->field($model, 'id_city')->widget(DepDrop::classname(), [ 
							'data'=>[$model->id_city=>$model->idCity->name],
							'pluginOptions'=>[
								'depends'=>['region-id'],
								'placeholder'=>'Select City',
								'url'=>Url::to(['/district/getcity'])
							]
						]);
					} else {
						echo $form->field($model, 'id_city')->widget(DepDrop::classname(), [ 
							'pluginOptions'=>[
								'depends'=>['region-id'],
								'placeholder'=>'Select City',
								'url'=>Url::to(['/district/getcity'])
							]
						]);
					}
			?>
			
			<?= $form->field($model, 'id')->textInput(['maxlength' => true,'disabled'=>$check]) ?>
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
		</div>
	</div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
