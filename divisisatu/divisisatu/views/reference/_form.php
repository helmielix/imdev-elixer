<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\Reference;

/* @var $this yii\web\View */
/* @var $model setting\models\Reference */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reference-form">

    <?php $form = ActiveForm::begin(); ?>
     <div class="row">
		<div class="col-lg-6">

    <!-- s -->

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    
	<?= $form->field( $model, 'table_relation' )->widget(Select2::classname(), [
			'data' => ArrayHelper :: map ( Reference :: find()->all(), 'table_relation','table_relation'),
			'options' => ['placeholder' => 'Type or Select ...'],
			'pluginOptions' => [
				'allowClear' => true,
				'tags' => true
			],
		]) ?>

		</div>
	</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
