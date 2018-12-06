<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel instruction\models\SearchInstructionDisposal */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Production Instruction';

if(Yii::$app->controller->action->id == 'index') $this->title = Yii::t('app','List Input Production Instruction');

function getFilterStatus() {
	if(Yii::$app->controller->action->id == 'index')
		return [
			1 => 'Inputted',
			2 => 'Revised',
			3 => 'Need Revise',
			6 => 'Rejected',
			999 => 'BA Survey Approved',
		];
	if(Yii::$app->controller->action->id == 'indexverify')
		return [
			1 => 'Inputted',
			2 => 'Revised',
			4 => 'Verified',
		];
	if(Yii::$app->controller->action->id == 'indexapprove')
		return [
			5 => 'Approved',
			4 => 'Verified'
		];
	if(Yii::$app->controller->action->id == 'indexoverview')
		return [
			1 => 'Inputted',
			2 => 'Revised',
			3 => 'Need Revise',
			6 => 'Rejected',
			5 => 'Approved',
			4 => 'Verified',
			999 => 'BA Survey Approved',
	];
} ;
?>
<div id="southPanel" class="instruction-production-index">

	<!--
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Instruction Disposal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	-->
	<div id="southPanelHeader">
        <?php
            if(Yii::$app->controller->action->id == 'index') {echo 'List Input Production Instruction';};
            if(Yii::$app->controller->action->id == 'indexverify') {echo 'List Planning BA Survey IKO Verification ';};
        ?>
    </div>
	<div id="southPanelGrid">
	<?php Pjax::begin(['id' => 'pjax', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]) ?>    
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'columns' => [
				['class' => 'kartik\grid\SerialColumn'],
				[
					'class' => 'kartik\grid\ActionColumn',
					'template'=>'{view} {update}',
					'buttons'=>[
                        'view' => function ($url, $model) {
                            if(Yii::$app->controller->action->id == 'index') $viewurl = 'view';
                            if(Yii::$app->controller->action->id == 'indexverify') $viewurl = 'viewverify';
                            if(Yii::$app->controller->action->id == 'indexapprove') $viewurl = 'viewapprove';
                            if(Yii::$app->controller->action->id == 'indexoverview') $viewurl = 'viewoverview';
							
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#'.$viewurl.'?id='.$model->id.'&header=Detail_Disposal_Instruction', [
                                    'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'header'=> yii::t('app','Detail Disposal Instruction')
                            ]);
                        },
                        'update' => function ($url, $model) {
                            if(Yii::$app->controller->action->id == 'index'){
                                if($model->status_listing == 3)
                                    return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>', '#update?id='.$model->id.'&header=Detail_Disposal_Instruction', [
                                        'title' => Yii::t('app', 'create'), 'class' => 'viewButton', 'header'=> yii::t('app','Detail Disposal Instruction')
                            ]); }
                        },
                    ],
				],
				// [
                    // 'attribute' => 'status_listing',
                    // 'format' => 'raw',
                    // 'value' => function ($searchModel) {
                    	// if ($searchModel->status_listing) {
                            // return "<span class='label' style='background-color:{$searchModel->statusListing->status_color}' >{$searchModel->statusListing->status_listing}</span>";
                        // } else {
                            // return "<span class='label' style='background-color:grey'>Creatable</span>";
                        // }
                    // },
                    // 'filter' => getFilterStatus()
                // ],
				'status_listing',
	            'id',
	            'target_produksi',
	            'warehouse',

			],
		]); ?>
	<?php Pjax::end(); ?>
	</div>
</div>
