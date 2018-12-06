<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel ca\models\SubdistrictSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subdistricts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subdistrict-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
			['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '{update} {delete}'
			],
			[
				'attribute'=>'region',
				'value'=>'idDistrict.idCity.idRegion.name'
            ],
			[
				'attribute'=>'city',
				'value'=>'idDistrict.idCity.name'
            ],
			[
				'attribute'=>'district',
				'value'=>'idDistrict.name'
            ],
			
			'name',
			'zip_code',

        ],
    ]); ?>
</div>
