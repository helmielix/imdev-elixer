<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="ca-reference-form">

    <?php $form = ActiveForm::begin(); ?>

	<div class="row">
		<div class="col-lg-3">
			<?= $form->field($model, 'name')->dropDownList(
			[
				'property_area_type' => 'Property Area Type',
				'house_type' => 'House Type',
				'myr_population_hv' => 'Majority Population Have',
				'dev_method' => 'Developing Method',
				'access_to_sell' => 'Access To Sell',
				'occupancy_use_dth' => 'Occupancy Use DTH',
				'competitors' => 'Competitors',
				'avr_occupancy_rate' => 'Average Occupancy Rate',
			],
			
			['prompt' => 'Select Parameter Name...']) ?>

		<?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
		</div>
	</div>
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
