<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OutboundRepairTransfer */


$this->title = 'Update Outbound Repair: ' . $model->id_instruction_repair;
$this->params['breadcrumbs'][] = ['label' => 'Outbound Repair', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_instruction_repair, 'url' => ['view', 'id' => $model->id_instruction_repair]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="outbound-wh-transfer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
