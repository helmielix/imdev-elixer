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
				'value'=>$model->statusReference->status_listing,
			],
			[
                'attribute'=>'doc_file',
                'format'=>'raw',
                'value'=>Html::a(basename($model->doc_file), ['downloadfile', 'id' => $model->id], $options = ['target'=>'_blank', 'data' => [
                    'method' => 'post',
                    'params' => [
                        'data' => 'doc_file',
                        // 'path' => 'true'
                    ],
                    ]]),

            ],

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
       
        <?=  Yii::$app->controller->action->id == 'viewverify' && $model->status!=4? Html::a('Verify', ['verify', 'id' => $model->id], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' => 'Are you sure you want to verify this item?'
              
            ],
			'data-method'=>'post'
        ]) : ' ' ?>
        
            
        
        <?=  Yii::$app->controller->action->id == 'viewapprove' && $model->status!=5? Html::a('Approve', ['approve', 'id' => $model->id], [
            'class' => 'btn btn-primary',
            'data' => [
                'confirm' => 'Are you sure you want to approve this item?'
              
            ],
			'data-method'=>'post'
        ]) : '' ?>      
        
        
                
        
		
		<?php if((Yii::$app->controller->action->id == 'viewverify') && ($model->status != 5 && $model->status != 4)){
			echo Html::button(Yii::t('app','Revise'), ['id'=>'reviseButton','class' => 'btn btn-warning']); 
		}else if(Yii::$app->controller->action->id == 'viewapprove' && $model->status != 5){
			echo Html::button(Yii::t('app','Revise'), ['id'=>'reviseButton','class' => 'btn btn-warning']); 
		}
		?>
        <?php if((Yii::$app->controller->action->id == 'viewverify') && ($model->status != 5 && $model->status != 4)){
			echo Html::button(Yii::t('app','Reject'), ['id'=>'rejectButton','class' => 'btn btn-danger']); 
		}else if((Yii::$app->controller->action->id == 'viewapprove') && $model->status != 5){
			echo Html::button(Yii::t('app','Reject'), ['id'=>'rejectButton','class' => 'btn btn-danger']); 
		}
		?>
        
        <?php if((Yii::$app->controller->action->id == 'view') && ($model->status == 1 || $model->status == 6 || $model->status == 7)){
			echo Html::a('Delete', ['delete', 'id'=>$model->id], ['class' => 'btn btn-danger', 'data-method'=>'POST']); 
		}
		?>
    </p>

	<p>
	<?= Yii::$app->controller->action->id == 'view' ? Html::a('Back to Index', ['index'], ['class' => 'btn btn-primary']): ' ' ?>
	<?= Yii::$app->controller->action->id == 'view' && $model->status != 6? Html::a('Update', ['update', 'id'=>$model->id], ['class' => 'btn btn-primary']): ' ' ?>
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
		} else if (Yii::$app->controller->action->id == 'view'){
			$action = 'reviseapprove';
			$action_reject = 'rejectapprove';
		}
		
		
	?>
	
	<?php $form = ActiveForm::begin(['action' =>[$action,'id'=>$model->id],'id'=>'reviseForm','options'=>['style'=>'display:none']]); ?>

    <?= $form->field($model, 'revision_remark')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit Revision', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
	
	<?php $form = ActiveForm::begin(['action' =>[$action_reject,'id'=>$model->id],'id'=>'rejectForm','options'=>['style'=>'display:none']]); ?>

    <?= $form->field($model, 'revision_remark')->textarea(['maxlength' => true])->label('Reject Remark') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit Rejection', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
	

</div>
