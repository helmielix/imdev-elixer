<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use setting\models\MkmMasterItem;
use common\models\Reference;
use common\models\StatusReference;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model setting\models\MasterItemIm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-item-im-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
		<div class="col-lg-6">

		<?= $form->field($model, 'orafin_code')->dropDownList(
			ArrayHelper::map(MkmMasterItem::
				find()->select(['item_code'])->all(),'item_code','item_code'
			),
        ['prompt'=>'Select...']
        
        );
        ?>

		<?= $form->field($model, 'sn_type')->dropDownList(
        ArrayHelper::map(Reference::find()->where(['in','id',[1,2]])->all(),'id','description'),
        ['prompt'=>'Select...']
        );?>

	    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'brand')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'grouping')->dropDownList(
        ArrayHelper::map(StatusReference::find()->select(['id'])->all(),'id','status_color'),
        ['prompt'=>'Select...']
        );?>

        <?= $form->field($model, 'warna')->dropDownList(
        ArrayHelper::map(StatusReference::find()->select(['id'])->all(),'id','status_color'),
        ['prompt'=>'Select...']
        );?>

	                      
		</div>                           
	</div>                                                                                                                                                   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
