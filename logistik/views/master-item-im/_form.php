<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use setting\models\MkmMasterItem;
use common\models\Reference;
use common\models\StatusReference;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model setting\models\MasterItemIm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-item-im-form">

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
        'requiredCssClass' => 'requiredField'
    ]); ?>
    <div class="row">
		<div class="col-lg-8">
		
		<?= $form->field( $model, 'orafin_code' )->widget(Select2::classname(), [
			'data' => ArrayHelper :: map ( MkmMasterItem :: find()->select(['item_code'])->orderBy('item_code asc')->all(), 'item_code','item_code'),
			'options' => ['placeholder' => 'Select Orafin Code'],
			'pluginOptions' => [
				'allowClear' => true
			],
			
		]) ?>
		
		<?= $form->field( $model, 'name' )->widget(Select2::classname(), [
			'data' => ArrayHelper :: map ( MkmMasterItem :: find()->select(['item_desc', 'item_code'])->orderBy('item_desc asc')->all(), 'item_code','item_desc'),
			'options' => ['placeholder' => 'Select Nama Barang'],
			'pluginOptions' => [
				'allowClear' => true
			],
			
		]) ?>	    
		
		<?= $form->field( $model, 'sn_type' )->widget(Select2::classname(), [
			'data' => ArrayHelper :: map ( Reference::find()->where(['in','id',[1,2]])->all(), 'id','description'),
			'options' => ['placeholder' => 'Select SN type'],
			'pluginOptions' => [
				'allowClear' => true,
				'minimumResultsForSearch' => '-1',
			],
		]) ?>

		<?= $form->field( $model, 'grouping' )->widget(Select2::classname(), [
			'data' => ArrayHelper :: map ( Reference :: find()->andWhere(['ilike', 'table_relation' , 'grouping'])->all(), 'id','description'),
			'options' => ['placeholder' => 'Select Grouping'],
			'pluginOptions' => [
				'allowClear' => true
			],
		]) ?>
		
		<?= $form->field( $model, 'brand' )->widget(Select2::classname(), [
			'data' => ArrayHelper :: map ( Reference :: find()->andWhere(['ilike' ,'table_relation' , 'brand'])->all(), 'id','description'),
			'options' => ['placeholder' => 'Select Brand'],
			'pluginOptions' => [
				'allowClear' => true
			],
		]) ?>
	    	    
		<?= $form->field( $model, 'warna' )->widget(Select2::classname(), [
			'data' => ArrayHelper :: map ( Reference :: find()->andWhere(['ilike' ,'table_relation' , 'warna'])->all(), 'id','description'),
			'options' => ['placeholder' => 'Select Warna'],
			'pluginOptions' => [
				'allowClear' => true
			],
		]) ?>
		
		<?= $form->field( $model, 'type' )->widget(Select2::classname(), [
			'data' => ArrayHelper :: map ( Reference :: find()->andWhere(['ilike' ,'table_relation' , 'item_type'])->all(), 'id','description'),
			'options' => ['placeholder' => 'Select Type'],
			'pluginOptions' => [
				'allowClear' => true
			],
		]) ?>
		
		<?php if (!$model->isNewRecord):?>
		<?= $form->field($model, 'im_code')->textInput(['disabled' => true]) ?>
		<?php endif;?>
		
			<div class="form-group">
				<div class='col-sm-4 col-sm-offset-4'>
				<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				</div>
			</div>
        
		</div>
	</div>


    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs(<<<JSC
$('#createForm').on('select2:select', 'select', function(){
	var val = $(this).val();
	name = $(this).attr('name');
	
	if (name == 'MasterItemIm[name]'){
		$('#masteritemim-orafin_code').val(val).trigger('change');
	}else if (name == 'MasterItemIm[orafin_code]'){
		$('#masteritemim-name').val(val).trigger('change');
	}
	console.log( $(this).attr('name') );
	
});
JSC
, \yii\web\View::POS_END);
?>

