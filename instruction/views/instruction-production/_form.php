<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model instruction\models\InstructionDisposal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="instruction-production-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'target_produksi')->textInput() ?>

    <?= $form->field($model, 'file_attachment')->textInput() ?>

    <?= $form->field($model, 'warehouse')->textInput() ?>

    <?= $form->field($model, 'hasil_produksi')->textInput() ?>

    <?= $form->field($model, 'qty')->textInput() ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'updated_date')->textInput() ?>

    <?= $form->field($model, 'target_implementation')->textInput() ?>

    <?= $form->field($model, 'revision_remark')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
