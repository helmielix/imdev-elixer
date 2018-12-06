<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SearchOutboundGrf */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="outbound-grf-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_instruction_grf') ?>

    <?= $form->field($model, 'created_by') ?>

    <?= $form->field($model, 'updated_by') ?>

    <?= $form->field($model, 'status_listing') ?>

    <?= $form->field($model, 'grf_type') ?>

    <?php // echo $form->field($model, 'id_division') ?>

    <?php // echo $form->field($model, 'id_region') ?>

    <?php // echo $form->field($model, 'pic') ?>

    <?php // echo $form->field($model, 'forwarder') ?>

    <?php // echo $form->field($model, 'grf_number') ?>

    <?php // echo $form->field($model, 'wo_number') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'plate_number') ?>

    <?php // echo $form->field($model, 'driver') ?>

    <?php // echo $form->field($model, 'revision_remark') ?>

    <?php // echo $form->field($model, 'print_time') ?>

    <?php // echo $form->field($model, 'handover_time') ?>

    <?php // echo $form->field($model, 'surat_jalan_number') ?>

    <?php // echo $form->field($model, 'incoming_date') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'updated_date') ?>

    <?php // echo $form->field($model, 'id_modul') ?>

    <?php // echo $form->field($model, 'file_attachment_1') ?>

    <?php // echo $form->field($model, 'file_attachment_2') ?>

    <?php // echo $form->field($model, 'purpose') ?>

    <?php // echo $form->field($model, 'requestor') ?>

    <?php // echo $form->field($model, 'id_warehouse') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
