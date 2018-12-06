<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\StockOpnameInternalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-opname-internal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'status_listing') ?>

    <?= $form->field($model, 'created_by') ?>

    <?= $form->field($model, 'updated_by') ?>

    <?= $form->field($model, 'id_warehouse') ?>

    <?php // echo $form->field($model, 'pic') ?>

    <?php // echo $form->field($model, 'stock_opname_number') ?>

    <?php // echo $form->field($model, 'cut_off_data_date') ?>

    <?php // echo $form->field($model, 'file') ?>

    <?php // echo $form->field($model, 'revision_remark') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'updated_date') ?>

    <?php // echo $form->field($model, 'id_modul') ?>

    <?php // echo $form->field($model, 'cut_off_data_time') ?>

    <?php // echo $form->field($model, 'start_date') ?>

    <?php // echo $form->field($model, 'end_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
