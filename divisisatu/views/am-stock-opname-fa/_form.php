<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AmStockOpnameFa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="am-stock-opname-fa-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'stock_opname_number')->textInput() ?>

    <?= $form->field($model, 'status_listing')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'id_warehouse')->textInput() ?>

    <?= $form->field($model, 'pic')->textInput() ?>

    <?= $form->field($model, 'cut_off_data')->textInput() ?>

    <?= $form->field($model, 'file')->textInput() ?>

    <?= $form->field($model, 'revision_remark')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'updated_date')->textInput() ?>

    <?= $form->field($model, 'id_modul')->textInput() ?>

    <?= $form->field($model, 'sto_start_date')->textInput() ?>

    <?= $form->field($model, 'sto_end_date')->textInput() ?>

    <?= $form->field($model, 'time_cut_off_data')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
