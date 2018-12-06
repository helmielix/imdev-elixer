<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\MasterItemIm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-item-im-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'brand')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_date')->textInput() ?>

    <?= $form->field($model, 'updated_date')->textInput() ?>

    <?= $form->field($model, 'im_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'orafin_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sn_type')->textInput() ?>

    <?= $form->field($model, 'grouping')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'warna')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stock_qty')->textInput() ?>

    <?= $form->field($model, 's_good')->textInput() ?>

    <?= $form->field($model, 's_not_good')->textInput() ?>

    <?= $form->field($model, 's_reject')->textInput() ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 's_dismantle_good')->textInput() ?>

    <?= $form->field($model, 's_dismantle_not_good')->textInput() ?>

    <?= $form->field($model, 's_good_recondition')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
