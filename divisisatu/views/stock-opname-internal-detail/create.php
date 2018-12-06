<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model divisisatu\models\StockOpnameInternalDetail */

$this->title = 'Create Stock Opname Internal Detail';
$this->params['breadcrumbs'][] = ['label' => 'Stock Opname Internal Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-opname-internal-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
