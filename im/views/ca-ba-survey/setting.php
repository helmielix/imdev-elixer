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
		<?= Html::checkboxList('settings', \Yii::$app->session->get('ca-ba-survey-setting'),
			[
			'qty_hp_pot'=>'QTY Home Pass Potensial',
			'survey_date'=>'Survey Date',
			'created_date'=>'Created Date',
			'updated_date'=>'Updated Date',
			'id'=>'ID',
			'id_area'=>'ID Area',
			'notes'=>'Notes',
			'created_by'=>'Created By',
			'updated_by'=>'Updated By',
			'status_listing'=>'Status Listing',
			'status_iom'=>'Status IOM',
			'potency_type'=>'Potency Type',
			'no_iom'=>'No IOM',
			'avr_occupancy_rate'=>'Average Occupancy Rate',
			'property_area_type'=>'Property Area Type',
			'house_type'=>'House Type',
			'myr_population_hv'=>'Majority Population Have',
			'dev_method'=>'Developing Method',
			'access_to_sell'=>'Access To Sell',
			'competitors'=>'Competitors',
			'location_description'=>'Location Description',
			'pic_survey'=>'PIC Survey',
			'contact_survey'=>'Contact Survey',
			'pic_iom_special'=>' PIC IOM Special',
			'revision_remark'=>'Revision Remark',
			'city'=>'City',
			'district'=>'District',
			'city'=>'City',
			'subdistrict'=>'Subdistrict',
			'status_area'=>'Status Area',
			
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
			  url: '<?php echo Url::to(['/ca-ba-survey/submitsetting'])?>',
			  type: 'post',
			  data: {setting:tempArr},
		 });
	});
</script>
