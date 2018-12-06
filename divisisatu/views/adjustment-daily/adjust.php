<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;
use common\models\StatusReference;

?>


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
                'attribute' => 'no_adj',
                'label' => 'Nama Barang',
                /*'value' => function($model){
                    return $model->name;
                }*/
                /*'value' => function($model) {
                    return ['STB', 'OTB'];
                }*/
            ],
            [
                'attribute' => 'no_sj',
                'label' => 'IM Code',
                /*'value' => function($model){
                    return $model->im_code;
                }*/
            ],
            [
                'attribute' => 'berita_acara',
                'label' => 'Brand',
                //'value' => 'item.im_code',
                /*'value' => function($model) {
                    return ['STB', 'OTB'];
                }*/
            ],
            [
                'attribute' => 'catatan',
                'label' => 'QTY Req',
                //'value' => 'item.im_code',
                /*'value' => function($model) {
                    return ['STB', 'OTB'];
                }*/
            ]
        ],
    ]); ?>
</div>