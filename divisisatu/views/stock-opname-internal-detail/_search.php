<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\StockOpnameInternalDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-opname-internal-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_stock_opname_internal') ?>

    <?= $form->field($model, 'id_item_im') ?>

    <?= $form->field($model, 'f_good') ?>

    <?= $form->field($model, 'f_not_good') ?>

    <?php // echo $form->field($model, 'f_reject') ?>

    <?php // echo $form->field($model, 'd_good') ?>

    <?php // echo $form->field($model, 'd_not_good') ?>

    <?php // echo $form->field($model, 'd_reject') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
