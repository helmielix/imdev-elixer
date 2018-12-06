<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\InstructionWhTransfer */

$this->title = 'Create Instruction Repair';
$this->params['breadcrumbs'][] = ['label' => 'Instruction Repaires', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instruction-wh-transfer-create">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
