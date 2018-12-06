<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AmStockOpnameFa */

$this->title = $model->stock_opname_number;
$this->params['breadcrumbs'][] = ['label' => 'Am Stock Opname Fas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="am-stock-opname-fa-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->stock_opname_number], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->stock_opname_number], [
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
            'stock_opname_number',
            'status_listing',
            'created_by',
            'updated_by',
            'id_warehouse',
            'pic',
            'cut_off_data',
            'file',
            'revision_remark:ntext',
            'created_date',
            'updated_date',
            'id_modul',
            'sto_start_date',
            'sto_end_date',
            'time_cut_off_data',
        ],
    ]) ?>

</div>
