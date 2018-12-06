<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */

$this->title = 'Update Inbound Po';
$this->params['breadcrumbs'][] = ['label' => 'Inbound Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inbound-po-create">

    <?= $this->render('_formrr', [
        'model' => $model,
		'modelOrafin' => $modelOrafin,
		// 'dataProvider' => $dataProvider
    ]) ?>

</div>
