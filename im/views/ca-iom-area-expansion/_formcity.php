<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\province;
use app\models\region;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
?>

<div class="iomandcity-form">

    <?php $form = ActiveForm::begin(['requiredCssClass' => 'requiredField']); ?>

    <?= $form->field($modelProvince, 'id')->dropDownList(
		ArrayHelper::map(Province::find()->orderBy('name ASC')->all(),'id','name'), 
		['id'=>'province-id','prompt'=>'Select Province']
	)->label('Province') ?>
	
	<?= $form->field($modelRegion, 'id')->widget(DepDrop::classname(), [ 
		'options'=>['id'=>'region-id'],
			'pluginOptions'=>[
				'depends'=>['province-id'],
				'placeholder'=>'Select Region',
				'url'=>Url::to(['/site/getregion'])
			]
	])->label('Region') ?>

    <?= $form->field($model, 'id_city')->widget(DepDrop::classname(), [ 
		'options'=>['id'=>'city-id'],
			'pluginOptions'=>[
				'depends'=>['region-id','province-id'],
				'placeholder'=>'Select City',
				'url'=>Url::to(['/site/getcity'])
			]
	]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
