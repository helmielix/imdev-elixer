<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model divisisatu\models\InstructionWhTransfer */

$this->title = 'Create Instruction Wh Transfer';
$this->params['breadcrumbs'][] = ['label' => 'Instruction Wh Transfers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instruction-wh-transfer-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
