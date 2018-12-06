<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model instruction\models\InstructionDisposal */

$this->title = 'Create Instruction Disposal';
$this->params['breadcrumbs'][] = ['label' => 'Instruction Disposals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instruction-disposal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
