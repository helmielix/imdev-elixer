<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Region;
/* @var $this yii\web\View */
/* @var $model app\models\Warehouse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="warehouse-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="row">
		<div class="col-lg-3">

		<?= $form->field($model, 'id_warehouse')->textInput(['disabled' => true]) ?>

		<?= $form->field($model, 'warehouse_name')->textInput(['disabled' => true]) ?>

		<?= $form->field($model, 'id_region')->widget(Select2::classname(), [
			'data' => ArrayHelper::map(Region::find()->where(['status'=>27])->all(),'id','name'),
			'language' => 'de',
			'options' => ['placeholder' => 'Select a region ...'],
			'pluginOptions' => [
				'allowClear' => true
			],
		]);
		?>
		</div>
	</div>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
