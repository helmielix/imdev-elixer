<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'City';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!-- <?= Html::a('Create City', ['create'], ['class' => 'btn btn-success']) ?> -->
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '{update}',
                
			],
            [
				'attribute'=>'region',
				'value' => 'idRegion.name',
			],
			[
				'attribute'=>'province',
				'value' => 'idProvince.name',
			],
			'name',
        ],
    ]); ?>
</div>
