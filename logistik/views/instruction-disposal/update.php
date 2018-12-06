<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InstructionDisposal */

$this->title = 'Update Instruction Disposal: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instruction Disposals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="instruction-disposal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
