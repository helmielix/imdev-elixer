<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\InstructionDisposalIm */

$this->title = 'Create Instruction Disposal Im';
$this->params['breadcrumbs'][] = ['label' => 'Instruction Disposal Ims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instruction-disposal-im-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
