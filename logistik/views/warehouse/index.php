<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Region;
use common\models\Reference;
use common\models\Labor;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchWarehouse */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Warehouse';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warehouse-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p class='pull-right'>
        <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
				'class' => 'yii\grid\ActionColumn',
				'template'=>'{view} {update} {userwarehouse} {delete}',
                'buttons'=>[
                    'userwarehouse' => function ($url, $model) {
						return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-link"></span>', 'userwarehouse?idwarehouse='.$model->id.'&header=Mapping_Warehouse_to_User', [
							'title' => Yii::t('app', 'Link to User'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/userwarehouse','idwarehouse' => $model->id]), 'header'=> yii::t('app','Mapping Warehouse to User')  
						]);
                    },
                ],
			],
            
            'nama_warehouse',
            
            [
                'attribute' => 'pic',
                'value' => function($model){
                    return $model->labor->nama;                    
                },
            ],
            
            [
                'attribute' => 'id_region',
                'value' => function($model){
                    return $model->region->name;                    
                },
            ],
            // 'alamat',
            [
                'attribute' => 'wh_type',
                'value' => function($model){
                    return $model->whtype->description;                    
                },
            ],
            // 'id_warehouse',
            // 'note:ntext',

        ],
    ]); ?>
<?php Pjax::end(); ?></div>
