<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Reference;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\OutboundWhTransfer */
/* @var $form yii\widgets\ActiveForm */

$disable = false;
if ($this->context->action->id == 'viewapprove'){
	$disable = true;
}

?>
<div class="outbound-wh-transfer-form">

    <?php if($this->context->action->id != 'viewapprove' &&  (Yii::$app->request->get('show') == 'form')){ ?>

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

    <?php }else{ ?>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'small table table-striped table-bordered detail-view'],
        'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
        'attributes' => [
            
            [
                'attribute' => 'forwarder',
                'value' => function($model){
                    if(is_numeric($model->forwarder)){
                        return Reference::findOne($model->forwarder)->description;
                    }
                },
            ],
            'plate_number',
            'driver',
            // [
            //     'attribute' => 'no_sj',
            //     'visible' => is_string($model->no_sj),
            // ],
            // 'idInstructionWh.instruction_number',
            // 'idInstructionWh.delivery_target_date:date',
            // [
            //     'attribute' => 'wh_origin',
            //     'value' => $model->idInstructionWh->whOrigin->nama_warehouse
            // ],
            // [
            //     'attribute' => 'wh_destination',
            //     'value' => $model->idInstructionWh->whDestination->nama_warehouse
            // ],
            // 'idInstructionWh.grf_number',
        ],
    ]) ?>

    <?php } ?>

</div>
