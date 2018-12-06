<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\StockOpnameInternalDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-opname-internal-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_stock_opname_internal')->textInput() ?>

    <?= $form->field($model, 'id_item_im')->textInput() ?>

    <?= $form->field($model, 'f_good')->textInput() ?>

    <?= $form->field($model, 'f_not_good')->textInput() ?>

    <?= $form->field($model, 'f_reject')->textInput() ?>

    <?= $form->field($model, 'd_good')->textInput() ?>

    <?= $form->field($model, 'd_not_good')->textInput() ?>

    <?= $form->field($model, 'd_reject')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
