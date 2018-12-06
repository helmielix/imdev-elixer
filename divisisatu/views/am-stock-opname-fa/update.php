<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AmStockOpnameFa */

$this->title = 'Update Am Stock Opname Fa: ' . $model->stock_opname_number;
$this->params['breadcrumbs'][] = ['label' => 'Am Stock Opname Fas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->stock_opname_number, 'url' => ['view', 'id' => $model->stock_opname_number]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="am-stock-opname-fa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
