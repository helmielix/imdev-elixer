<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel ca\models\IomandcitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cities of IOM';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="iomandcity-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            
			[
				'attribute' => 'id_city',
				'label' => 'ID City'
			]
			

        ],
    ]); ?>
</div>
