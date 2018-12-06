<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\SearchInstructionWhTransfer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="instruction-wh-transfer-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
    ]);
    ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'created_by') ?>

    <?= $form->field($model, 'updated_by') ?>

    <?= $form->field($model, 'status_listing') ?>

    <?= $form->field($model, 'wh_destination') ?>

    <?php // echo $form->field($model, 'instruction_number') ?>

    <?php // echo $form->field($model, 'delivery_target_date') ?>

    <?php // echo $form->field($model, 'file_attachment') ?>

    <?php // echo $form->field($model, 'created_date') ?>

    <?php // echo $form->field($model, 'updated_date') ?>

    <?php // echo $form->field($model, 'grf_number') ?>

        <?php // echo $form->field($model, 'wh_origin')  ?>

    <div class="form-group">
<?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
