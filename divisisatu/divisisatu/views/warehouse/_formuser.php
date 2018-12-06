<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Region;
use common\models\User;
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
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ],
        ],
        'requiredCssClass' => 'requiredField'
    ]); ?>
	
	<div class="row">
		<div class="col-lg-8">	

    <?= $form->field($model->idwarehouse, 'nama_warehouse')->textInput(['disabled' => true]) ?>
    <?= $form->field($model, 'id_warehouse')->hiddenInput(['readonly' => true])->label(false) ?>
	<?php  ?>
	
	<?= $form->field( $model, 'id_user' )->widget(Select2::classname(), [
			'data' => ArrayHelper :: map ( User :: find()->all(), 'id','username'),
			'size' => Select2::LARGE,
			'options' => ['placeholder' => 'Select User', 'multiple' => true],
			'pluginOptions' => [
				'allowClear' => true
			],
			
		]) ?>
		

			<div class="form-group">
				<div class='col-sm-4 col-sm-offset-4'>
				<?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => 'btn btn-success']) ?>
				</div>
			</div>
		</div>
	</div>

    <?php ActiveForm::end(); ?>

</div>
