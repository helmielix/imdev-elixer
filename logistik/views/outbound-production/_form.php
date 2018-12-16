<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Reference;
use common\models\Labor;

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

    <?= $form->field($model, 'pic')->widget(Select2::classname(), [
		'data' => ArrayHelper::map(Labor::find()->all(), 'nik','nama'),
		'language' => 'en',
		// form-control select2-hidden-accessible
		'options' => ['placeholder' => 'Select ..', 'class' => 'input-sm', 'disabled' => $disable],
		'pluginOptions' => [
		'allowClear' => true],
		]) ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <label class='control-label col-sm-4'> </label>
        <div class='col-sm-6'>
            <?php if (Yii::$app->controller->action->id == 'update') {
                echo Html::a(basename($model->file_attachment), ['downloadfile','id' => $model->id], $options = ['target'=>'_blank', 'data' => [
                        'method' => 'post',
                        'params' => [
                            'data' => 'file_attachment',
                        ]
                    ]]);
            } ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
