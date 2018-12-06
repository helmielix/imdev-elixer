<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Alert;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;


if(Yii::$app->controller->action->id == 'index') $this->title = Yii::t('app','Input BA Survey');
if(Yii::$app->controller->action->id == 'indexverify') $this->title = Yii::t('app','Verify BA Survey');
if(Yii::$app->controller->action->id == 'indexapprove') $this->title = Yii::t('app','Approve BA Survey');
if(Yii::$app->controller->action->id == 'indexoverview_presurvey') $this->title = Yii::t('app','Overview Presurvey');

$this->registerCssFile('@commonpath/css/olmap_with_grid.css',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/mapresize.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/listeners/btn_drawpolygon.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/listeners/btn_zoomto.js',['depends' => [\yii\web\JqueryAsset::className()]]); 
$this->registerJsFile('@commonpath/js/olmap/listeners/btn_resizepanel.js',['depends' => [\yii\web\JqueryAsset::className()]]); 
$this->registerJsFile('@commonpath/js/popup_alert.js',['depends' => [\yii\web\JqueryAsset::className()]]); 
?>

<?php Modal::begin([
		'header'=>'<h3 id="modalHeader"></h3>',
		'id'=>'modal',
		'size'=>'modal-lg'
	]); 

	echo '<div id="modalContent"> </div>';

	Modal::end();
?>

<?= $this->render(
	'../../../common/views/olmap.php'
) ?>
    
<div id="southPanel" > 
	<div id="southPanelHeader">
		BA Survey List
		<div class="panelZoomController">
			<span class="panelZoomButton up"> &#x2912; </span>
			<span class="panelZoomSeparator"> </span>
			<span class="panelZoomButton down"> &#x2913; </span>
		</div>
		<?=  Yii::$app->controller->action->id == 'index_presurvey' ? Html::a('Create', '#create_presurvey?header=Create_Pre-Survey', ['class' => 'btn btn-success headerButton', 'id' => 'createModal', 'value'=>Url::to(['ca-ba-survey/create_presurvey']), 'header'=> yii::t('app','Create Pre-Survey')]) : '' ?>
		<?=  Yii::$app->controller->action->id == 'indexoverview' ? Html::a('Setting', '#setting?header=List_Setting', ['class' => 'btn btn-success headerButton', 'id' => 'createModal', 'value'=>Url::to(['ca-ba-survey/setting']), 'header'=> yii::t('app','List Setting')]) : '' ?>
		
	</div>

	<div id="southPanelGrid"> 
	<?php \yii\widgets\Pjax::begin(['id' => 'pjax']); ?>
		<?php 
			
			$setting = \Yii::$app->session->get('ca-ba-survey-setting');
			$columns = []; 
			array_push($columns,
				['class' => 'yii\grid\SerialColumn']
			);
			array_push($columns,
				[
					'class' => 'yii\grid\ActionColumn',
					'header' => 'Actions',
					'headerOptions' => ['style' => 'color:#337ab7'],
					'template' => '{view}{draw}{zoomto}',
					'buttons' => [
						'view' => function ($url, $model) {
									if(Yii::$app->controller->action->id == 'index_presurvey') $viewurl = 'view_presurvey'; 
									if(Yii::$app->controller->action->id == 'indexverify_presurvey') $viewurl = 'viewverify_presurvey'; 
									if(Yii::$app->controller->action->id == 'indexapprove_presurvey') $viewurl = 'viewapprove_presurvey'; 
									if(Yii::$app->controller->action->id == 'indexoverview_presurvey') $viewurl = 'viewoverview_presurvey'; 
									return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#'.$viewurl.'?id='.$model->id.'&header=Detail_Pre_Survey', [
											'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['ca-ba-survey/'.$viewurl, 'id' => $model->id]), 'header'=> yii::t('app','Detail Pre Survey')
								]);
						},
						'draw' => function ($url, $model) {
							if(Yii::$app->controller->action->id == 'index_presurvey') {
								return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-edit"></span>', '#', [
									'title' => Yii::t('app', 'draw polygon'), 'class' => 'drawButton', 'value'=>$model->id
								]);
							}
						},
						'zoomto' => function ($url, $model) {
							if($model->geom != '') {
									return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-screenshot"></span>', '#', [
											'title' => Yii::t('app', 'zoom to map object'), 'class' => 'zoomtoButton', 'value'=>$model->id
								]);
							}
						},
						
			  
					],
				]
			
			);
			array_push($columns,
				[
					'attribute' => 'status_presurvey',
					'format' => 'raw',
					'value' => function ($searchModel) {
							return "<span class='label' style='background-color:{$searchModel->statusReferencePreSurvey->status_color}' >{$searchModel->statusReferencePreSurvey->displayText()}</span>";
						},
					'filter' => [
						1 => 'Inputted',
						2 => 'Revised',
						3 => 'Need revise',
						4 => 'Verified',
						5 => 'Approved',
						7 => 'Drafted',
						6 => 'Rejected',
					]
				]
			);
			if(in_array("city", $setting)) array_push($columns,
				[
					'attribute' => 'city',
					'value' => 'idArea.idSubdistrict.idDistrict.idCity.name'
				]
			);
			if(in_array("district", $setting)) array_push($columns,
				[
					'attribute' => 'district',
					'value' => 'idArea.idSubdistrict.idDistrict.name'
				]
			);
			if(in_array("subdistrict", $setting)) array_push($columns,
				[
					'attribute' => 'subdistrict',
					'value' => 'idArea.idSubdistrict.name'
				]
			);
			if(in_array("survey_date", $setting)) array_push($columns,
				[ 
					'attribute' => 'survey_date',
					'value'  => 'survey_date',
					'format' => 'date',
					'filter' => DatePicker::widget([
						'model' => $searchModel,
						'attribute' => 'survey_date',
						'clientOptions' => [
							'autoclose' => true,
							'format' => 'yyyy-mm-dd',
						],
					]),
				]
			);
			if(in_array("updated_date", $setting)) array_push($columns,
				[ 
					'attribute' => 'updated_date',
					'value'  => 'updated_date',
					'format' => 'datetime',
					'filter' => DatePicker::widget([
						'model' => $searchModel,
						'attribute' => 'updated_date',
						'clientOptions' => [
							'autoclose' => true,
							'format' => 'yyyy-mm-dd',
						],
					]),
				]
			);
			if(in_array("created_date", $setting)) array_push($columns,
				[ 
					'attribute' => 'created_date',
					'value'  => 'created_date',
					'format' => 'datetime',
					'filter' => DatePicker::widget([
						'model' => $searchModel,
						'attribute' => 'created_date',
						'clientOptions' => [
							'autoclose' => true,
							'format' => 'yyyy-mm-dd',
						],
					]),
				]
			);
			if(in_array("qty_hp_pot", $setting)) array_push($columns,"qty_hp_pot");
			if(in_array("id", $setting)) array_push($columns,"id");
			if(in_array("id_area", $setting)) array_push($columns,"id_area");
			if(in_array("notes", $setting)) array_push($columns,"notes");
			if(in_array("created_by", $setting)) array_push($columns,"created_by");
			if(in_array("status_iom", $setting)) array_push($columns,"status_iom");
			if(in_array("potency_type", $setting)) array_push($columns,"potency_type");
			if(in_array("no_iom", $setting)) array_push($columns,"no_iom");
			if(in_array("avr_occupancy_rate", $setting)) array_push($columns,"avr_occupancy_rate");
			if(in_array("property_area_type", $setting)) array_push($columns,"property_area_type");
			if(in_array("myr_population_hv", $setting)) array_push($columns,"myr_population_hv");
			if(in_array("dev_method", $setting)) array_push($columns,"dev_method");
			if(in_array("access_to_sell", $setting)) array_push($columns,"access_to_sell");
			if(in_array("competitors", $setting)) array_push($columns,"competitors");
			if(in_array("location_description", $setting)) array_push($columns,"location_description");
			if(in_array("pic_survey", $setting)) array_push($columns,"pic_survey");
			if(in_array("contact_survey", $setting)) array_push($columns,"contact_survey");
			if(in_array("pic_iom_special", $setting)) array_push($columns,"pic_iom_special");
			if(in_array("revision_remark", $setting)) array_push($columns,"revision_remark");
		?>
		
		<div>
			<?= ExportMenu::widget([
				'dataProvider' => $dataProvider,
				'columns' => $columns
			]); ?>
		</div>
		
		 <?= GridView::widget([
				'id' => 'gridView',
				'dataProvider' => $dataProvider,
				'filterModel' => $searchModel,
				'columns' => $columns,
			]); ?>
	<?php \yii\widgets\Pjax::end(); ?>
    </div>
</div>
