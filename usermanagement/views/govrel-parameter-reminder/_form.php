<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GovrelParameterReminder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="govrel-parameter-reminder-form">

    <?php $form = ActiveForm::begin(); ?>

	<div class="row">
		<div class="col-lg-3">
			<?= $form->field($model, 'type')->textInput() ?>
			
			<?= $form->field($model, 'day')->textInput() ?>
		</div>
	</div>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
