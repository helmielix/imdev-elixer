<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchCaIomAreaExpansion */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'IOM Area Expansions';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Yii::$app->session->getFlash('success'); ?>

<?php if (Yii::$app->session->hasFlash('failed')): ?>
  <div class="alert alert-danger alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4><i class="icon fa fa-check"></i>Failed!</h4>
  <?= Yii::$app->session->getFlash('failed') ?>
  </div>
<?php endif; ?>

<div class="ca-iom-area-expansion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Yii::$app->controller->action->id == 'index'  ? Html::a('Create New IOM', ['create'], ['class' => 'btn btn-success']): ' ' ?>
    </p>

	<?php
	$columns = []; 
		array_push($columns,
				['class' => 'yii\grid\SerialColumn']
			);
		array_push($columns, [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view} {delete} {verify} {approve}',
                'buttons' => [
					'delete' => function ($url, $model) {
						return Yii::$app->controller->action->id == 'delete'  ? Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 
							Url::to(['delete','id'=>$model->id]), [
							'title' => Yii::t('app', 'delete'),
						]) : '' ;
					},
					
					
					
					'view' => function ($url, $model) {
						if( Yii::$app->controller->action->id == 'index'){
							return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 
							Url::to(['view','id'=>$model->id]), [
							'title' => Yii::t('app', 'view detail'),
						]);
						
						}else if(Yii::$app->controller->action->id == 'indexoverview'){
							return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 
							Url::to(['viewoverview','id'=>$model->id]), [
							'title' => Yii::t('app', 'view detail'),
						]);
						
						}else if(Yii::$app->controller->action->id == 'indexlog'){
							return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 
							Url::to(['viewlog','id'=>$model->id,'idLog'=>$model->idlog]), [
							'title' => Yii::t('app', 'view detail'),
						]);
						}
					
					},
				
					'verify' => function ($url, $model) {
						return Yii::$app->controller->action->id == 'indexverify'  ? Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 
							Url::to(['viewverify','id'=>$model->id]), [
							'title' => Yii::t('app', 'view detail'),
						]) : '' ;
					},
					
					'approve' => function ($url, $model) {
						return Yii::$app->controller->action->id == 'indexapprove'  ?Html::a('<span class="glyphicon glyphicon-eye-open"></span>', 
							Url::to(['viewapprove','id'=>$model->id]), [
							'title' => Yii::t('app', 'view detail'),
						]) : '' ;
					},
          
				],
			]);
		
	    array_push($columns,
	            [
				'attribute' => 'status',
				'format' => 'raw',
				'value' => function ($searchModel) {
						if($searchModel->status)                                             
						{
							return "<span class='label' style='background-color:{$searchModel->statusReference->status_color}' > {$searchModel->statusReference->status_listing}  </span>" ;						
							
						}
                        
					},
				'filter' => [
					1 => 'Inputted',
					2 => 'Revised',
					3 => 'Need revise',
					4 => 'Verified',
					5 => 'Approved',
					6 => 'Rejected',
					7 => 'Drafted',
				]
			]);

	    array_push($columns, ['attribute' => 'no_iom_area_exp','label'=>'No IOM Area Expansion']);
		array_push($columns, 
		    [ 
					'attribute' => 'created_date',
					'value'  => 'created_date',
					'format' => 'datetime',
					'filter' => DatePicker::widget([
						'model' => $searchModel,
						'attribute' => 'created_date',
						'clientOptions' => [
							'autoclose' => true,
							'format' => 'yyyy-mm-dd',
						],
					]),
	            ]);
		array_push($columns, 
		    [ 
					'attribute' => 'updated_date',
					'value'  => 'updated_date',
					'format' => 'datetime',
					'filter' => DatePicker::widget([
						'model' => $searchModel,
						'attribute' => 'updated_date',
						'clientOptions' => [
							'autoclose' => true,
							'format' => 'yyyy-mm-dd',
						],
					]),
	            ]);
		array_push($columns,
	            [
            	'attribute' => 'updated_by',
            	'value' => function($searchModel){
					if(User::findIdentity($searchModel->updated_by)){
						return  User::findIdentity($searchModel->updated_by)->username;
					}
				}
            ]);
		?>
		
    <div>
		<?php
			$exportColumns = [
				[
					'label'=>'Status',
					'format' => 'raw',
					'value'=> function($model){return ($model->status == null) ? '-' : $model->statusReference->status_listing;}
				], 
				'no_iom_area_exp',
				'created_date',
			]
		?>
		<?= ExportMenu::widget([
			'dataProvider' => $dataProvider,
			'columns' => $exportColumns,
			'fontAwesome' => true,
			'enableFormatter' => false
		]); ?>
	</div>
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
			
            
			
        
    ]); ?>
</div>
