<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Reference;

/* @var $this yii\web\View */
/* @var $model common\models\OutboundWhTransfer */
/* @var $form yii\widgets\ActiveForm */

$disable = false;
if ($this->context->action->id == 'viewapprove'){
	$disable = true;
}

?>
<div class="outbound-wh-transfer-form">

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'id' => 'createForm',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-4 small',
                'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-6',
                'error' => '',
                'hint' => '',
            ],
        ],
        'requiredCssClass' => 'requiredField'
    ]); ?>  

    <?= $form->field($model, 'forwarder')->widget(Select2::classname(), [
		'data' => ArrayHelper::map(Reference::find()->andWhere(['table_relation' => ['forwarder']])->all(), 'id','description'),
		'language' => 'en',
		// form-control select2-hidden-accessible
		'options' => ['placeholder' => 'Select '.$model->getAttributeLabel('forwarder'), 'class' => 'input-sm', 'disabled' => $disable],
		'pluginOptions' => [
		'allowClear' => true],
		]) ?>

    <?= $form->field($model, 'plate_number')->textInput(['maxlength' => true, 'class' => 'input-sm form-control', 'disabled' => $disable]) ?>

    <?= $form->field($model, 'driver')->textInput(['maxlength' => true, 'class' => 'input-sm form-control', 'disabled' => $disable]) ?>

    <?php ActiveForm::end(); ?>

</div>
