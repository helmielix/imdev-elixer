<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\InstructionWhTransfer */

$this->title = 'Update Instruction Wh Transfer: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instruction Wh Transfers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="instruction-wh-transfer-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
