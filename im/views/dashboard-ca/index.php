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
									Html::a('View',Url::to(['ca-iom-area-expansion/viewverify','id'=>$searchModel->task]));
							} elseif ($searchModel->table_source == "IOM AREA EXPANSION Approval"){
								return $searchModel->note .
									Html::a('View',Url::to(['ca-iom-area-expansion/viewapprove','id'=>$searchModel->task]));
							} elseif ($searchModel->table_source == "IOM AREA EXPANSION Rejection"){
								return $searchModel->note .
									Html::a('View',Url::to(['ca-iom-area-expansion/viewoverview','id'=>$searchModel->task]));
							} elseif ($searchModel->table_source == "IOM AREA EXPANSION Revision"){
								return $searchModel->note .
									Html::a('View',Url::to(['ca-iom-area-expansion/view','id'=>$searchModel->task]));
							} elseif ($searchModel->table_source == "BA SURVEY Verification"){
								return $searchModel->note .
									Html::a('View',
									Url::base().'/'.Url::to('ca-ba-survey/indexverify').'#viewverify?id='.$searchModel->task.'&header=Detail_Berita_Acara_Survey').' ';
							} elseif ($searchModel->table_source == "BA SURVEY Approval"){
								return $searchModel->note .
									Html::a('View',
									Url::base().'/'.Url::to('ca-ba-survey/indexapprove').'#viewapprove?id='.$searchModel->task.'&header=Detail_Berita_Acara_Survey').' ';
							} elseif ($searchModel->table_source == "BA SURVEY Revision"){
								return $searchModel->note .
									Html::a('View',
									Url::base().'/'.Url::to('ca-ba-survey/index').'#view?id='.$searchModel->task.'&header=Detail_Berita_Acara_Survey').' ';
							} elseif ($searchModel->table_source == "BA SURVEY Rejection"){
								return $searchModel->note .
									Html::a('View',
									Url::base().'/'.Url::to('ca-ba-survey/index_iom').'#view_iom?id='.$searchModel->task.'&header=Detail_Berita_Acara_Survey').' ';
							} elseif ($searchModel->table_source == "IOM Rollout Input"){
								return $searchModel->note .
									Html::a('View',
									Url::base().'/'.Url::to('ca-ba-survey/index_iom').'#view_iom?id='.$searchModel->task.'&header=Detail_Berita_Acara_Survey').' ';
							} elseif ($searchModel->table_source == "IOM Rollout Verification"){
								return $searchModel->note .
									Html::a('View',
									Url::base().'/'.Url::to('ca-ba-survey/indexverify_iom').'#viewverify_iom?id='.$searchModel->task.'&header=Detail_Berita_Acara_Survey').' ';
							} elseif ($searchModel->table_source == "IOM Rollout Approval"){
								return $searchModel->note .
									Html::a('View',
									Url::base().'/'.Url::to('ca-ba-survey/indexapprove_iom').'#viewapprove_iom?id='.$searchModel->task.'&header=Detail_Berita_Acara_Survey').' ';
							} elseif ($searchModel->table_source == "IOM Rollout Revision"){
								return $searchModel->note .
									Html::a('View',
									Url::base().'/'.Url::to('ca-ba-survey/index_iom').'#view_iom?id='.$searchModel->task.'&header=Detail_Berita_Acara_Survey').' ';
							} elseif ($searchModel->table_source == "IOM Rollout Rejection"){
								return $searchModel->note .
									Html::a('View',
									Url::base().'/'.Url::to('ca-ba-survey/index_potensial').'#view_potensial?id='.$searchModel->task.'&header=Detail_Berita_Acara_Survey').' ';
							} elseif ($searchModel->table_source == "PRE-SURVEY Verification"){
				                return $searchModel->note .
				                  Html::a('View',
				                  Url::base().'/'.Url::to('ca-ba-survey/indexverify_presurvey').'#viewverify_presurvey?id='.$searchModel->task.'&header=Detail_Berita_Acara_Survey').' ';
				            } elseif ($searchModel->table_source == "PRE-SURVEY Approval"){
				                return $searchModel->note .
				                  Html::a('View',
				                  Url::base().'/'.Url::to('ca-ba-survey/indexapprove_presurvey').'#viewapprove_presurvey?id='.$searchModel->task.'&header=Detail_Berita_Acara_Survey').' ';
				            } elseif ($searchModel->table_source == "PRE-SURVEY Revision"){
				                return $searchModel->note .
				                  Html::a('View',
				                  Url::base().'/'.Url::to('ca-ba-survey/index_presurvey').'#view_presurvey?id='.$searchModel->task.'&header=Detail_Berita_Acara_Survey').' ';
				            } elseif ($searchModel->table_source == "PRE-SURVEY Rejection"){
				                return $searchModel->note .
				                  Html::a('View',
				                  Url::base().'/'.Url::to('ca-ba-survey/index_presurvey').'#view?_presurveyid='.$searchModel->task.'&header=Detail_Berita_Acara_Survey').' ';
				            }
				            elseif ($searchModel->table_source == "PPL IKO ATP Invitation"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View', Url::to('http://10.9.39.41/foro/ppl/web/ppl-iko-atp').'/viewinvitation?id='.$searchModel->task.'&header=RESPON_IKO_ATP_INVITATION').' ';
				            }

				            elseif ($searchModel->table_source == "PPL OSP ATP Invitation"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View', Url::to('http://10.9.39.41/foro/ppl/web/ppl-osp-atp').'/viewinvitation?id='.$searchModel->task.'&header=RESPON_OSP_ATP_INVITATION').' ';
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
