<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="region-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="row">
		<div class="col-lg-3">
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
		</div>
	</div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
