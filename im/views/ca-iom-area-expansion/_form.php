<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="ca-iom-area-expansion-form">

    <?php $form = ActiveForm::begin(['requiredCssClass' => 'requiredField'],['options' => ['enctype' => 'multipart/form-data']]); ?>

	<div class="row">
		<div class="col-lg-5">
			<?= $form->field($model, 'file')->fileInput() ?>
			<?php 
				if(Yii::$app->controller->action->id == 'update'){
					//echo Html::a($model->doc_file, ['downloadfile','path' => $model->doc_file], $options = ['target'=>'_blank']);
					echo Html::a(basename($model->doc_file), ['downloadfile', 'id' => $model->id], $options = ['target'=>'_blank', 'data' => [
						'method' => 'post',
						'params' => [
							'data' => 'doc_file',
							// 'path' => 'true'
						],
						]]);
				}
			?>	

			<?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>
		</div>
	</div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
