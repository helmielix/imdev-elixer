<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProsesPerjanjianInstansi */
/* @var $form ActiveForm */
$this->title = 'Input Proses Perjanjian Instansi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perjanjian_instansi">
	<h1><?= Html::encode($this->title) ?></h1>
	<p>Isi Form Input Proses Perjanjian Instansi</p>
	<div class="row">
        <div class="col-lg-5">
			<?php $form = ActiveForm::begin(); ?>
		        <?= $form->field($model, 'nama_ba') ?>
				<?= $form->field($model, 'hasil_survey')->textarea(); ?>
		        <?= $form->field($model, 'data_ba_survey')->textarea(); ?>
		        <?= $form->field($model, 'file_ba_survey')->fileInput() ?>
		        <?= $form->field($model, 'file_izin_internal')->fileInput() ?>
		  
		        <div class="form-group">
		            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
		        </div>
		    <?php ActiveForm::end(); ?>
	    </div>
	</div>
</div><!-- perjanjian_instansi -->
