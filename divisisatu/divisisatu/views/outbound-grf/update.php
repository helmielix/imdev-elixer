<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OutboundGrf */

$this->title = 'Update Outbound Grf: ' . $model->id_instruction_grf;
$this->params['breadcrumbs'][] = ['label' => 'Outbound Grves', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_instruction_grf, 'url' => ['view', 'id' => $model->id_instruction_grf]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="outbound-grf-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
