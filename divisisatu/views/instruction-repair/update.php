<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\InstructionWhTransfer */

$this->title = 'Update Instruction Repair: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instruction Repaires', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="instruction-wh-transfer-update">

    <?php /*echo 'hello!';*/ ?>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
