<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model instruction\models\InstructionDisposal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="instruction-disposal-form">

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
            'requiredCssClass' => 'requiredField',
        ]); ?>

	<div class ="col-sm-6">
    <?= $form->field($model, 'no_iom')->textInput() ?>
    <?= $form->field($model, 'created_date', ['template' => '{label} <div class="col-sm-6 row"><div class="col-sm-12">{input}{error}{hint}</div></div>'])->textInput() ?>
    <?= $form->field($model, 'updated_by', ['inputTemplate' => '<div class="input-group"><span class="input-group-addon">Rp</span>{input}</div>'])->textInput() ?>
	</div>

	<div class="col-sm-6">    
    <?= $form->field($model, 'revision_remark')->textarea(['rows' => 6]) ?>
	</div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
