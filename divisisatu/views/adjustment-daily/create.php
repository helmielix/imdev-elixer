<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;
use common\models\StatusReference;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;

$arrJenisTransaksi=array(
    'warehouse_transfer'=>'Warehouse Transfer',
    'repair'=>'Repair',
    'disposal'=>'Disposal',
    'produksi'=>'Produksi',
    'peminjaman'=>'Peminjaman',
    'grf'=>'GRF',
    'recondition'=>'Recondition');
?>
<div class="outbound-wh-transfer-create">

	<div class="row">
		<div class="col-sm-6">
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
 <?= $form->field($model, 'jenis_transaksi')->widget(Select2::classname(), [
		'data' => $arrJenisTransaksi,               
		'language' => 'en',
		// form-control select2-hidden-accessible
		'options' => [ 'id'=>'jenis_transaksi','placeholder' => 'Select '.$model->getAttributeLabel('jenis_transaksi'), 'class' => 'input-sm'],
		'pluginOptions' => [
		'allowClear' => true],
		]) ?>
 <?= $form->field($model, 'no_sj')->widget(DepDrop::classname(), [
    'type'=>DepDrop::TYPE_SELECT2,
    'data'=>[$model->no_sj],
    'options'=>['id'=>'no_sj', 'placeholder'=>'Select '.$model->getAttributeLabel('no_sj')],
    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
    'pluginOptions'=>[
        'depends'=>['jenis_transaksi'],
        'url'=>Url::to(['/adjustment-daily/nosj']),
        'loadingText' => 'Loading '.$model->getAttributeLabel('no_sj'),
        'params'=>[$model->no_sj]
    ]
]);
 ?>
<?php echo  $form->field($model, 'file')->label('Berita Acara <span style="color:red">*</span>')->fileInput() ?>
<?php echo  $form->field($model, 'catatan')->textarea(['rows' => 4]) ?>
<div class="row">
		<div class="col-sm-offset-7">
<div class="form-group">
    <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
</div>
                </div></div>

<?php ActiveForm::end(); ?>
                </div>
        </div>
</div>