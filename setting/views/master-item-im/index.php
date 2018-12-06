<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel setting\models\searchMasterItemIm */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Item Im';
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
            // 'id',
            'created_by',
            'updated_by',
            'status',
            'name',
            // 'brand',
            // 'warna',
            // 'created_date',
            // 'updated_date',
            // 'im_code',
            // 'orafin_code',


            [   'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
            ],
        ],
    ]); ?>
</div>
