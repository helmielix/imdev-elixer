<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InboundRepairNew */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Inbound Repair New',
]) . $model->id_instruction_repair;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inbound Repair News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_instruction_repair, 'url' => ['view', 'id' => $model->id_instruction_repair]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="inbound-repair-new-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
