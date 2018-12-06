<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Region';
?>
<div class="region-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Region', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	<?php if (Yii::$app->session->hasFlash('failed')): ?>
		<div class="alert alert-danger alert-dismissable">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		<h4><i class="icon fa fa-cross"></i>Failed!</h4>
		<?= Yii::$app->session->getFlash('failed') ?>
		</div>
	<?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '{update} {delete}',
                'buttons' => [
					'update' => function ($url, $model) {
						if($model->status == 27){
							return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>',
                            Url::to(['/region/update', 'id' => $model->id]),
                            [
								'title' => Yii::t('app', 'update'), 'class' => 'updateButton', 'value'=>$model->id
							]);
						} else {
							return '';
						}
						}
					],
			],
            'name',

			[
				'attribute' => 'status',
				'format' => 'raw',
				'value' => function ($searchModel) {
						if($searchModel->statusRegion->status_listing){
							return "<span class='label' style='background-color:{$searchModel->statusRegion->status_color}' >{$searchModel->statusRegion->status_listing}</span>";
						}


					},
				'filter' => [
					27 => 'Active',
					18 => 'Non Active'
				],
			]
        ],
    ]); ?>
</div>
