<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\StockOpnameInternal */

$this->title = 'Update Stock Opname Internal: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Stock Opname Internal', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stock-opname-internal-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
