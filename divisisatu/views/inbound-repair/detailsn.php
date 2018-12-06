<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\Url;

use dosamigos\datepicker\DatePicker;

use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\OutboundRepairTransfer */

// MASIH ADA YANG HARUS DIUBAH!!! <CHG>

/*$this->title = $model->id_instruction_repair;
$this->params['breadcrumbs'][] = ['label' => 'Outbound Wh Transfers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
//$model = ["title" => 12]
?>
<div class="row">
    <div class="col-sm-6">

        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'small table table-striped table-bordered detail-view'],
            'attributes' => [
                [
                    'attribute' => 'name',
                    'label' => 'Nama Barang',
                    //'value' => '001/INST',
                ],
                [
                    'attribute' => 'im_code',
                    //'label' => 'Tanggal Pengiriman',
                    //'value' => '20 Juli 2018',
                ],
                [
                    'attribute' => 'grouping',
                    //'label' => 'Warehouse',
                    //'value' => 'Jakarta',
                ],
                [
                    'attribute' => 'req_qty',
                    //'label' => 'Vendor Repair',
                    //'value' => 'Makmur',
                ],
            ]
        ]); ?>

    </div>
</div>

<div class="row">
    <?= GridView::widget([
        'id' => 'gridViewindexdetail',
        'dataProvider' => $dataProvider,
        'floatHeader'=>true,
        'floatOverflowContainer' => true,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'serial_number',
                //'label' => 'Nama Barang',
                //'value' => 'item.im_code',
                /*'value' => function($model) {
                    return ['STB', 'OTB'];
                }*/
            ],
            [
                'attribute' => 'mac_address',
                //'label' => 'IM Code',
                //'value' => 'item.im_code',
                /*'value' => function($model) {
                    return ['STB', 'OTB'];
                }*/
            ],
        ],
    ]); ?>
</div>

