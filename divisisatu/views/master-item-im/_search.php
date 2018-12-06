<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\MasterItemImSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-item-im-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'created_by') ?>

    <?= $form->field($model, 'updated_by') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'brand') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'updated_date') ?>

    <?php // echo $form->field($model, 'im_code') ?>

    <?php // echo $form->field($model, 'orafin_code') ?>

    <?php // echo $form->field($model, 'sn_type') ?>

    <?php // echo $form->field($model, 'grouping') ?>

    <?php // echo $form->field($model, 'warna') ?>

    <?php // echo $form->field($model, 'stock_qty') ?>

    <?php // echo $form->field($model, 's_good') ?>

    <?php // echo $form->field($model, 's_not_good') ?>

    <?php // echo $form->field($model, 's_reject') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 's_dismantle_good') ?>

    <?php // echo $form->field($model, 's_dismantle_not_good') ?>

    <?php // echo $form->field($model, 's_good_recondition') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
