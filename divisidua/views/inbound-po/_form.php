<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inbound-po-form">

    <?php $form = ActiveForm::begin([
		'enableClientValidation' => true,
        'id' => 'createForm',
        'layout' => 'horizontal',
		'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-4',
                'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-6',
                'error' => '',
                'hint' => '',
            ],
        ],
	]); ?>
	
	<div class="row">
		<div class="col-lg-6">
			<?= $form->field($modelOrafin, 'rr_number')->textInput(['disabled'=>true]) ?>
			
			<?= $form->field($modelOrafin, 'pr_number')->textInput(['disabled'=>true]) ?>
			
			<?= $form->field($modelOrafin, 'po_number')->textInput(['disabled'=>true]) ?>
		</div>
		<div class="col-lg-6">
			<?= $form->field($modelOrafin, 'supplier')->textInput(['disabled'=>true]) ?>

			<?= $form->field($modelOrafin, 'rr_date')->textInput(['disabled'=>true]) ?>

			<?= $form->field($modelOrafin, 'waranty')->textInput(['disabled'=>true]) ?>
		</div>
	</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	
	<?= GridView::widget([
        'id' => 'gridView',
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
			[
				'attribute' => 'orafin_name',
			]
			
			
        ],
    ]); ?>

    <?php ActiveForm::end(); ?>

</div>
