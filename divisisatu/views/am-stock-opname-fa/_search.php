<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AmStockOpnameFaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="am-stock-opname-fa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'stock_opname_number') ?>

    <?= $form->field($model, 'status_listing') ?>

    <?= $form->field($model, 'created_by') ?>

    <?= $form->field($model, 'updated_by') ?>

    <?= $form->field($model, 'id_warehouse') ?>

    <?php // echo $form->field($model, 'pic') ?>

    <?php // echo $form->field($model, 'cut_off_data') ?>

    <?php // echo $form->field($model, 'file') ?>

    <?php // echo $form->field($model, 'revision_remark') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'updated_date') ?>

    <?php // echo $form->field($model, 'id_modul') ?>

    <?php // echo $form->field($model, 'sto_start_date') ?>

    <?php // echo $form->field($model, 'sto_end_date') ?>

    <?php // echo $form->field($model, 'time_cut_off_data') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
