<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InstructionGrf */

$this->title = 'Update Instruction Grf: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inbound Grves', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="instruction-grf-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
