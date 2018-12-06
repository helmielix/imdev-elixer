<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\IOMAREAEXPANSION */

$this->title = 'View IOM Area Expansions';
$this->params['breadcrumbs'][] = ['label' => 'Iom Area Expansions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(
    "
		$(document).ready(function(){
		$('#reviseButton').click(function(){
			$('#rejectForm').hide();
			$('#reviseForm').show();
		});
		$('#rejectButton').click(function(){
			$('#reviseForm').hide();
			$('#rejectForm').show();
		});
	});
	"
);
?>


<div class="iomareaexpansion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
		<?php 
			if(Yii::$app->controller->action->id != 'view'){
				echo Yii::$app->controller->action->id == 'view' ? Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']): ' ' ;
				echo  Yii::$app->controller->action->id == 'view' ? Html::a('Delete', ['delete', 'id' => $model->id], [
					'class' => 'btn btn-danger',
					'data' => [
						'confirm' => 'Are you sure you want to delete this item?',
						'method' => 'post',
					],
				]): ' ' ;
			}
		?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'no_iom_area_exp',
			'created_date',
			[
				'attribute'=>'status',
				'value'=>function ($model) {
						if($model->status)                                             
						{
							return "{$model->statusReference->status_listing}" ;						
							
						}
                        
					},
			],
			'doc_file',
			// [
                // 'attribute'=>'doc_file',
                // 'value'=> function($model){
					// return Html::a(basename($model->idCaIomAreaExpansion->doc_file), ['downloadfile', 'id' => $model->id], $options = ['target'=>'_blank', 'data' => [
                    // 'method' => 'post',
                    // 'params' => [
                        // 'data' => 'idCaIomAreaExpansion.doc_file',
                        // // 'path' => 'true'
                    // ],
                    // ]]);
				// }
				
				
				
            // ],

            'revision_remark',
        ],
    ]) ?>
	
	<h4> <b> Cities </b> </h4>
	
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
		'summary'=>'',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			[
				'attribute' => 'region',
				'value' => 'idCity.idRegion.name'
			],
			[
				'attribute' => 'city',
				'value' => 'idCity.name'
			],
        ],
    ]); ?>
	
	
    <p>
       
        <?=  Yii::$app->controller->action->id == 'viewverify' ? Html::a('Verify', ['verify', 'id' => $model->id], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' => 'Are you sure you want to verify this item?'
              
            ],
        ]) : ' ' ?>
        
            
        
        <?=  Yii::$app->controller->action->id == 'viewapprove' ? Html::a('Approve', ['approve', 'id' => $model->id], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' => 'Are you sure you want to approve this item?'
              
            ],
        ]) : '' ?>      
        
        
                
        <?= Yii::$app->controller->action->id == 'viewverify' || Yii::$app->controller->action->id == 'viewapprove' ? Html::button('Revise', ['id'=>'reviseButton','class' => 'btn btn-warning'], [
            'class' => 'btn btn-success',
        ]) : ''?>
        
        

        <?= Yii::$app->controller->action->id == 'viewverify' || Yii::$app->controller->action->id == 'viewapprove'? Html::button('Reject', ['id'=>'rejectButton','class' => 'btn btn-danger'], [
            'class' => 'btn btn-danger',
        ]) : '' ?>
        
        
    </p>

	<p>
	<?= Yii::$app->controller->action->id == 'viewlog' ? Html::a('Back to Index', ['indexlog'], ['class' => 'btn btn-primary']): ' ' ?>
	<?= Yii::$app->controller->action->id == 'view' ? Html::a('Update', ['update', 'id'=>$model->id], ['class' => 'btn btn-primary']): ' ' ?>
	<?= Yii::$app->controller->action->id == 'viewverify' ? Html::a('Back to Index', ['indexverify'], ['class' => 'btn btn-primary']): ' ' ?>
	<?= Yii::$app->controller->action->id == 'viewapprove' ? Html::a('Back to Index', ['indexapprove'], ['class' => 'btn btn-primary']): ' ' ?>
	<?= Yii::$app->controller->action->id == 'viewoverview' ? Html::a('Back to Index', ['indexoverview'], ['class' => 'btn btn-primary']): ' ' ?>
	
	</p>
	<?php 
		$action = "";
		$action_reject = "";
		if(Yii::$app->controller->action->id == 'viewverify'){
			$action = 'reviseverify';
			$action_reject = 'rejectverify';
		} else if (Yii::$app->controller->action->id == 'viewapprove'){
			$action = 'reviseapprove';
			$action_reject = 'rejectapprove';
		}
		
		
	?>
	

    
	

</div>
