<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\InboundRepairNew */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inbound-repair-new-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_instruction_repair')->textInput() ?>

    <?= $form->field($model, 'driver')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'status_listing')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'forwarder')->textInput() ?>

    <?= $form->field($model, 'no_sj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'plate_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'updated_date')->textInput() ?>

    <?= $form->field($model, 'revision_remark')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_modul')->textInput() ?>

    <?= $form->field($model, 'tanggal_datang')->textInput() ?>

    <?= $form->field($model, 'tagging')->textInput() ?>

    <?= $form->field($model, 'file_attachment')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
