<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel divisisatu\models\MasterItemImSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Item Ims';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-item-im-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Master Item Im', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'created_by',
            'updated_by',
            'status',
            'name',
            // 'brand',
            // 'created_date',
            // 'updated_date',
            // 'im_code',
            // 'orafin_code',
            // 'sn_type',
            // 'grouping',
            // 'warna',
            // 'stock_qty',
            // 's_good',
            // 's_not_good',
            // 's_reject',
            // 'type',
            // 's_dismantle_good',
            // 's_dismantle_not_good',
            // 's_good_recondition',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
