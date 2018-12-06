<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Reference;
 
/* @var $this yii\web\View */
/* @var $model common\models\OutboundRepairTransfer */
/* @var $form yii\widgets\ActiveForm */
//print_r($model); exit();
?>

<div class="outbound-wh-transfer-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
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
		'options' => ['placeholder' => 'Select '.$model->getAttributeLabel('forwarder'), 'class' => 'input-sm'],
		'pluginOptions' => [
		'allowClear' => true],
		]) ?>

    <?= $form->field($model, 'plate_number')->textInput(['maxlength' => true, 'class' => 'input-sm form-control']) ?>

    <?= $form->field($model, 'driver')->textInput(['maxlength' => true, 'class' => 'input-sm form-control']) ?>
<?php
if($model->status_listing==22){
echo \yii\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        [                      // the owner name of the model
            'label' => 'File Attachment',
            'format'=>'html',
            'value' => function($model){
            $nama= explode("/", $model->file_attachment);
    return  Html::a($nama[1], \yii\helpers\BaseUrl::base()."/".$model->file_attachment);
            },
        ],
    ],
]);
}else{
    echo $form->field($model, 'file_attachment')->fileInput() ;
}
?>

    <?php ActiveForm::end(); ?>

</div>
