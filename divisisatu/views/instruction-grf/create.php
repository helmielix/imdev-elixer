<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\InboundGrf */

$this->title = 'Create Instruction Grf';
$this->params['breadcrumbs'][] = ['label' => 'Instruction Grves', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instruction-grf-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
