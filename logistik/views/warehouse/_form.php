<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Region;
use common\models\Labor;
use common\models\Division;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Warehouse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="warehouse-form">

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
	
	<div class="row">
		<div class="col-lg-8">
	
	<?= $form->field( $model, 'id_region' )->widget(Select2::classname(), [
			'data' => ArrayHelper :: map ( Region :: find()->all(), 'id','name'),
			'options' => ['placeholder' => 'Select Region'],
			'pluginOptions' => [
				'allowClear' => true
			],
			
		]) ?>

    <?= $form->field($model, 'nama_warehouse')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field( $model, 'pic' )->widget(Select2::classname(), [
			'data' => ArrayHelper :: map ( Labor :: find()->all(), 'nik','nama'),
			'options' => ['placeholder' => 'Select PIC'],
			'pluginOptions' => [
				'allowClear' => true
			],
			
		]) ?>
	 	
	
	<?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'note')->textArea() ?>

			<div class="form-group">
				<div class='col-sm-4 col-sm-offset-4'>
				<?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => 'btn btn-success']) ?>
				</div>
			</div>
		</div>
	</div>

    <?php ActiveForm::end(); ?>

</div>
