<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\ViewReportBasurveyRegion;
use dosamigos\datepicker\DatePicker;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\DashCaHpByCity;
use app\models\CaBaSurvey;

$this->title = 'Dashboard';


// Page Lib
$this->registerCssFile('@commonpath/css/report.css',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@commonpath/css/map.css',['depends' => [\yii\web\JqueryAsset::className()]]);

// JqueryUI Lib
$this->registerCssFile('@commonpath/css/jquery-ui.css',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@commonpath/css/jquery-ui_override.css',['depends' => [\yii\web\JqueryAsset::className()]]);

// Highchart Lib
$this->registerJsFile('@commonpath/js/lib/highchart.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/initchart.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/mapreportresize.js',['depends' => [\yii\web\JqueryAsset::className()]]);

?>

<div style="height:1260px ; padding-left: 20px; padding-right: 5px; padding-top: 20px; padding-bottom: 50px;">
	<div id="mapContainer" class="panelContainer full">
		<div class="panelHeader" id="listPanelHeader" style="padding-bottom: 20px;">
			Online Map
		</div>
			<?= $this->render(
				'../../../common/views/olmap.php'
			) ?>
	</div>

	<div id="firstRowPanel" class="panelContainer full">

		<div class="panelHeader" id="listPanelHeader" style="padding-bottom: 20px;">
			Report Incoming Task
		</div>
		<div class="contentPanel custom-scroll" id="chartPanel5" style="overflow-y : scroll ;position:relative; height: 300px;">


			<?= GridView::widget([
				'dataProvider' => $dataProvider,
				'filterModel' => $searchModel,
				'summary' => "<span style='margin-left:10px'>Showing <b>{begin}</b> - <b>{end}</b> of <b>{totalCount}</b> items </span>",
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],

					[
						'attribute' => 'task_date',
						'format' => 'datetime',
						'filter' => DatePicker::widget([
	                        'model' => $searchModel,
	                        'attribute' => 'task_date',
	                        'clientOptions' => [
	                            'autoclose' => true,
	                            'format' => 'yyyy-mm-dd',
	                        ],
	                    ]),
					],
					[
						'attribute'=>'table_source',
						'format' => 'raw',
						'value'=>'table_source',
						'filter'=>true,
					],
					[
						'attribute'=>'note',
						'format' => 'raw',
						'value'=>function ($searchModel) {
							if($searchModel->table_source == "IOM AREA EXPANSION Verification") {
								return $searchModel->note .
									Html::a('View',Url::to(['inbound-po/viewverify','id'=>$searchModel->task]));
							} elseif ($searchModel->table_source == "IOM AREA EXPANSION Approval"){
								return $searchModel->note .
									Html::a('View',Url::to(['inbound-po/viewapprove','id'=>$searchModel->task]));
							} elseif ($searchModel->table_source == "IOM AREA EXPANSION Rejection"){
								return $searchModel->note .
									Html::a('View',Url::to(['inbound-po/viewoverview','id'=>$searchModel->task]));
							} elseif ($searchModel->table_source == "IOM AREA EXPANSION Revision"){
								return $searchModel->note .
									Html::a('View',Url::to(['inbound-po/view','id'=>$searchModel->task]));
							}
						},
						'filter'=>true,
					],
				],
			]); ?>
		</div>
	</div>

	<div id="thirdRowPanel" class="panelContainer center thirdrow" >
		<div class="panelHeader" id="listPanelHeader">
			Homepass CA - By City

				<div class="col-lg-3 pull-right">
					<?php $form = ActiveForm::begin([]); ?>
						<?= $form->field($model, 'city')->widget(Select2::classname(), [
							  'data' => ArrayHelper:: map ( CaBaSurvey:: find()->joinWith('idArea.idSubdistrict.idDistrict.idCity')->orderBy(['city'=>SORT_ASC])-> all(), 'idArea.idSubdistrict.idDistrict.idCity.name','idArea.idSubdistrict.idDistrict.idCity.name'),
							  'language' => 'en',
							  'options' => ['placeholder' => 'Kota Jakarta Selatan', 'id' => 'regionlist'],
							  'pluginOptions' => [
							  'allowClear' => true],
							  'pluginEvents' => [
								"change" => 'function(data) {
									regionListChange();
								}',
							],
						  ])->label("") ?>
					 <?php ActiveForm::end(); ?>
				 </div>

		</div>
		<div class="contentPanel" id="chartPanel1" >

		</div>
	</div>





</div>
