<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SearchInboundRepairNew */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inbound-repair-new-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_instruction_repair') ?>

    <?= $form->field($model, 'driver') ?>

    <?= $form->field($model, 'created_by') ?>

    <?= $form->field($model, 'status_listing') ?>

    <?= $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'forwarder') ?>

    <?php // echo $form->field($model, 'no_sj') ?>

    <?php // echo $form->field($model, 'plate_number') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'updated_date') ?>

    <?php // echo $form->field($model, 'revision_remark') ?>

    <?php // echo $form->field($model, 'id_modul') ?>

    <?php // echo $form->field($model, 'tanggal_datang') ?>

    <?php // echo $form->field($model, 'tagging') ?>

    <?php // echo $form->field($model, 'file_attachment') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
