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

    <p>
        <?= Html::a('Add new City', ['createcity'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Back to IOM', ['update','id'=>\Yii::$app->session->get('idIom')], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Save IOM', ['save','idIom'=>\Yii::$app->session->get('idIom')], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
				'class' => 'yii\grid\ActionColumn',
				'template'=>'{delete}',
				'buttons'=>[
					'delete' => function ($url, $model) {
						return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-trash"></span>', Url::to(['deletecity','id'=>$model->id,'idIom'=>\Yii::$app->session->get('idIom')]), [
							'title' => Yii::t('app', 'Delete'), 'class' => 'deleteButton', 'value'=>$model->id]);
						
					},
				],
			],
            'id_city',
			[
				'attribute' => 'city',
				'value' => 'idCity.name'
			],

        ],
    ]); ?>
</div>
