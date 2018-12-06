<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Region;
use app\models\Province;

?>

<div class="city-form">

    <?php $form = ActiveForm::begin(); ?>

	<div class="row">
		<div class="col-lg-3">
		<?= $form->field($model, 'id_region')->dropDownList(
			ArrayHelper::map(Region::find()->where(['status'=>27])->all(),'id','name'), 
			['prompt'=>'Select Region']
		) ?>
		
		<?= $form->field($model, 'id_province')->dropDownList(
			ArrayHelper::map(Province::find()->all(),'id','name'), 
			['prompt'=>'Select Province','disabled'=>'true']
		) ?>
		
		<?= $form->field($model, 'id')->textInput(['maxlength' => true,'disabled'=>'true']) ?>
		<?= $form->field($model, 'name')->textInput(['maxlength' => true,'disabled'=>'true']) ?>
		</div>
	</div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
