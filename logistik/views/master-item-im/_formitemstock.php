<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\MasterItemDetail;
use common\models\MasterItemIm;
use common\models\Warehouse;
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
		
		<?= $form->field( $model, 'id_master_item_im' )->widget(Select2::classname(), [
			'data' => ArrayHelper :: map ( MasterItemIm :: find()->select(['id','im_code'])->orderBy('im_code asc')->all(), 'id','im_code'),
			'options' => ['placeholder' => 'Select IM Code'],
			'pluginOptions' => [
				'allowClear' => true
			],
			
		]) ?>
		
		<?= $form->field( $model, 'id_warehouse' )->widget(Select2::classname(), [
			'data' => ArrayHelper :: map ( Warehouse :: find()->select(['id', 'nama_warehouse'])->orderBy('nama_warehouse asc')->all(), 'id','nama_warehouse'),
			'options' => ['placeholder' => 'Select Warehouse'],
			'pluginOptions' => [
				'allowClear' => true
			],
			
		]) ?>	    
		
		<?= $form->field($model, 's_good')->textInput() ?>

		<?= $form->field($model, 's_not_good')->textInput() ?>

		<?= $form->field($model, 's_reject')->textInput() ?>

		<?= $form->field($model, 's_dismantle')->textInput() ?>

		<?= $form->field($model, 's_revocation')->textInput() ?>
		
		<?= $form->field($model, 's_good_rec')->textInput() ?>
		<?= $form->field($model, 's_good_for_recond')->textInput() ?>


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

