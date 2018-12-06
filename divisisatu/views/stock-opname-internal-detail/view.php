<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\StockOpnameInternalDetail */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Stock Opname Internal Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-opname-internal-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_stock_opname_internal',
            'id_item_im',
            'f_good',
            'f_not_good',
            'f_reject',
            'd_good',
            'd_not_good',
            'd_reject',
        ],
    ]) ?>

</div>
