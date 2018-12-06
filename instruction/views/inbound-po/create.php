<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */

$this->title = 'Create Inbound Po';
$this->params['breadcrumbs'][] = ['label' => 'Inbound Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inbound-po-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
