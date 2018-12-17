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
// $this->registerCssFile('@commonpath/css/map.css',['depends' => [\yii\web\JqueryAsset::className()]]);

// JqueryUI Lib
$this->registerCssFile('@commonpath/css/jquery-ui.css',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@commonpath/css/jquery-ui_override.css',['depends' => [\yii\web\JqueryAsset::className()]]);

// Highchart Lib
// $this->registerJsFile('@commonpath/js/lib/highchart.js',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@web/js/initchart.js',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@commonpath/js/mapreportresize.js',['depends' => [\yii\web\JqueryAsset::className()]]);

?>

<div style="height:1260px ; padding-left: 20px; padding-right: 5px; padding-top: 20px; padding-bottom: 50px;">
	

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
							// INBOUND PO
							if($searchModel->table_source == "GRF Verification") {
								return $searchModel->note .
									Html::a('View',Url::to(['grf/indexverify#viewverify','id'=>$searchModel->task]));
							} elseif ($searchModel->table_source == "GRF Approval"){
								return $searchModel->note .
									Html::a('View',Url::to(['grf/indexapprove#viewapprove','id'=>$searchModel->task]));
							} elseif ($searchModel->table_source == "GRF Revision"){
								return $searchModel->note .
									Html::a('View',Url::to(['grf/index#view','id'=>$searchModel->task]));
							}

						},
						'filter'=>true,
					],
				],
			]); ?>
		</div>
	</div>

	





</div>
