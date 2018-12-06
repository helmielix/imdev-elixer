<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel setting\models\searchMasterItemIm */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Add Stock To Warehouse';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-item-im-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add', ['createstock'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'options' => ['style' => 'overflow-x:scroll'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id_master_item_im',
            [
                'attribute' => 'name',
                'value' => function($model){
                    return $model->idMasterItemIm->name;
                }
            ],
            [
                'attribute' => 'orafin_code',
                'value' => function($model){
                    return $model->idMasterItemIm->orafin_code;
                }
            ],[
                'attribute' => 'im_code',
                'value' => function($model){
                    return $model->idMasterItemIm->im_code;
                }
            ],
            
   //          [
			// 	'attribute' => 'status',
			// 	'value' => function ($model) {
			// 		return $model->status0->status_listing;					
			// 	},
			// 	'filter' => [27 => 'Active', 40 => 'Not Actived']
			// ],


            [   'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
            ],
        ],
    ]); ?>
</div>
