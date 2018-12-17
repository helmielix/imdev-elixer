<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PermitDistribusi */
/* @var $form ActiveForm */


$this->title = 'Input Permit Distribusi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="permit_distribusi_view">
<h1><?= Html::encode($this->title) ?></h1>

    <p>Isi Form Input Permit Distribusi</p>

	<div class="row">
        <div class="col-lg-5">
	    <?php $form = ActiveForm::begin(); ?>

	        <?= $form->field($model, 'tanggal') ?>
	        <?= $form->field($model, 'pic') ?>
	        <?= $form->field($model, 'keterangan') ?>
	    
	        <div class="form-group">
	            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
	        </div>
	    <?php ActiveForm::end(); ?>
	    </div>
	</div>
</div><!-- permit_distribusi_view -->
