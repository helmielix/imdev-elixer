<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\CaIomAndCity;
use app\models\CaReference;
use yii\bootstrap\ActiveForm;
use kartik\depdrop\DepDrop;
use dosamigos\datepicker\DatePicker;
?>
<?php $this->registerCss("#settingForm label {width: 190px;}"); ?>
<div class="basurvey-form">
 
	<?= Html::beginForm('',null,$options=['id'=>'settingForm']) ?>
		<?= Html::checkboxList('settings', \Yii::$app->session->get('homepass-setting'),
			[
			'id' => 'ID',
           // 'status_ca' => 'Status CA',
            'potency_type' => 'Potency Type',
            'iom_type' => 'IOM Type',
          //  'status_govrel' => 'Status Govrel',
           // 'status_iko' => 'Status IKO',
            'home_number' => 'Home Number',
            'hp_type' => 'Home Pass Type',
          //  'status' => 'Status',
            'id_ca_ba_survey' => 'ID CA BA Survey',
            'id_govrel_ba_distribution' => 'ID Govrel BA Distribution',
            'id_iko_bas_plan' => 'ID IKO BAS Plan',
            'streetname' => 'Street Name',
            'kodepos' => 'Kode Pos',
			
			]) ?>
			
			<?= Html::button('Save Setting', ['id'=>'submitButton','class'=>'btn btn-success']) ?>

	<?= Html::endForm() ?>

</div>

<script>
	$('#submitButton').click(function () {
		tempArr= [];
		$("input:checkbox[name=settings\\[\\]]:checked").each(function(){
			tempArr.push($(this).val());
		});
	
		 $.ajax({
			  url: '<?php echo Url::to(['/homepass/submitsetting'])?>',
			  type: 'post',
			  data: {setting:tempArr},
		 });
	});
</script>
