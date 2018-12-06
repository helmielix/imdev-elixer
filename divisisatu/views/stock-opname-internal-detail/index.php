<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel divisisatu\models\StockOpnameInternalDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stock Opname Internal Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-opname-internal-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!-- <?= Html::a('Create Stock Opname Internal Detail', ['create'], ['class' => 'btn btn-success']) ?> -->
        <?= Html::a('Create Stock Opname Internal Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'stock_opname_internal',
            'id_item_im',
            'f_good',
            'f_not_good',
            'f_reject',
            'd_good',
            'd_not_good',
            'd_reject',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
