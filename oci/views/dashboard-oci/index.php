<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
use app\models\ViewReportBasurveyRegion;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\DashOsGa;

$this->title = 'Dashboard';


// Page Lib
$this->registerCssFile('@commonpath/css/report.css',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@commonpath/css/map.css',['depends' => [\yii\web\JqueryAsset::className()]]);

// JqueryUI Lib
$this->registerCssFile('@commonpath/css/jquery-ui.css',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@commonpath/css/jquery-ui_override.css',['depends' => [\yii\web\JqueryAsset::className()]]);

// Highchart Lib
$this->registerJsFile('@commonpath/js/lib/highchart.js',['depends' => [\yii\web\JqueryAsset::className()]]);

$personil = false;
$osga = false;
$osvendor = false;
$script = '';
if (Yii::$app->user->can('/os-ga-biaya-jalan-osp/indexoverview')) {
	$osga = true;
	$script = 'osga = true;personil = false;osvendor = false';
}elseif (Yii::$app->user->can('/os-outsource-personil/indexoverview')) {
	$personil = true;
	$script = 'personil = true;osga = false;osvendor = false';
}elseif (Yii::$app->user->can('/os-vendor-regist-vendor/indexoverview')) {
	$osvendor = true;
	$script = 'osvendor = true;personil = false;osga = false;';
}
$this->registerJs($script);
$this->registerJsFile('@web/js/initchart.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/mapreportresize.js',['depends' => [\yii\web\JqueryAsset::className()]]);

?>


<div style="height:100% ; padding-left: 20px; padding-right: 5px; padding-top: 20px; padding-bottom: 50px;">
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
						'attribute'=>'task',
						'format' => 'raw',
						'value'=>function ($searchModel) {
							if($searchModel->table_source == "Vendor Registration Verification") {
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-vendor-regist-vendor/indexverify').'#viewverify?id='.$searchModel->task.'&header=Detail_Vendor_Registration').' ';
				            } elseif ($searchModel->table_source == "Vendor Registration Approval"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-vendor-regist-vendor/indexapprove').'#viewapprove?id='.$searchModel->task.'&header=Detail_Vendor_Registration').' ';
				            } elseif ($searchModel->table_source == "Vendor Registration Rejection"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-vendor-regist-vendor/index').'#view?id='.$searchModel->task.'&header=Detail_Vendor_Registration').' ';
				            } elseif ($searchModel->table_source == "Vendor Registration Revision"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-vendor-regist-vendor/index').'#view?id='.$searchModel->task.'&header=Detail_Vendor_Registration').' ';
							}

							elseif ($searchModel->table_source == "GA Vehicle Parameter Approval"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-ga-vehicle-parameter/indexapprove').'#viewapprove?id='.$searchModel->task.'&header=Detail_Vehicle_Parameter').' ';
				            } elseif ($searchModel->table_source == "GA Vehicle Parameter Rejection"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-ga-vehicle-parameter/index').'#view?id='.$searchModel->task.'&header=Detail_Vehicle_Parameter').' ';
				            } elseif ($searchModel->table_source == "GA Vehicle Parameter Revision"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-ga-vehicle-parameter/index').'#view?id='.$searchModel->task.'&header=Detail_Vehicle_Parameter').' ';
				            }

							elseif ($searchModel->table_source == "GA Vehicle Operational Cost IKO Approval"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-ga-biaya-jalan-iko/indexapprove').'#viewapprove?idOsGaVehicleIko='.$searchModel->task.'&stdkNumber='.$searchModel->stdk.'&header=Detail_Vehicle_Parameter').' ';
				            }elseif ($searchModel->table_source == "GA Vehicle Operational Cost IKO Verification"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-ga-biaya-jalan-iko/indexverify').'#viewverify?idOsGaVehicleIko='.$searchModel->task.'&stdkNumber='.$searchModel->stdk.'&header=Detail_Vehicle_Parameter').' ';
				            } elseif ($searchModel->table_source == "GA Vehicle Operational Cost IKO Rejection"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-ga-biaya-jalan-iko/index').'#view?idOsGaVehicleIko='.$searchModel->task.'&stdkNumber='.$searchModel->stdk.'&header=Detail_Vehicle_Parameter').' ';
				            } elseif ($searchModel->table_source == "GA Vehicle Operational Cost IKO Revision"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-ga-biaya-jalan-iko/index').'#view?idOsGaVehicleIko='.$searchModel->task.'&stdkNumber='.$searchModel->stdk.'&header=Detail_Vehicle_Parameter').' ';
				            }

							elseif ($searchModel->table_source == "GA Vehicle Operational Cost OSP Approval"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-ga-biaya-jalan-osp/indexapprove').'#viewapprove?idOsGaVehicleIko='.$searchModel->task.'&header=Detail_Vehicle_Parameter').' ';
				            }elseif ($searchModel->table_source == "GA Vehicle Operational Cost OSP Verification"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-ga-biaya-jalan-osp/indexverify').'#viewverify?idOsGaVehicleIko='.$searchModel->task.'&header=Detail_Vehicle_Parameter').' ';
				            } elseif ($searchModel->table_source == "GA Vehicle Operational Cost OSP Rejection"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-ga-biaya-jalan-osp/index').'#view?idOsGaVehicleIko='.$searchModel->task.'&header=Detail_Vehicle_Parameter').' ';
				            } elseif ($searchModel->table_source == "GA Vehicle Operational Cost OSP Revision"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-ga-biaya-jalan-osp/index').'#view?idOsGaVehicleIko='.$searchModel->task.'&header=Detail_Vehicle_Parameter').' ';
				            }

							elseif ($searchModel->table_source == "GA Driver Parameter Approval"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-ga-driver-parameter/indexapprove').'#viewapprove?id='.$searchModel->task.'&header=Detail_Driver_Parameter').' ';
				            } elseif ($searchModel->table_source == "GA Driver Parameter Rejection"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-ga-driver-parameter/index').'#view?id='.$searchModel->task.'&header=Detail_Driver_Parameter').' ';
				            } elseif ($searchModel->table_source == "GA Driver Parameter Revision"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-ga-driver-parameter/index').'#view?id='.$searchModel->task.'&header=Detail_Driver_Parameter').' ';
				            }

							elseif($searchModel->table_source == "Vendor Term Sheet Input") {
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('Create',Url::base().'/'.Url::to('os-vendor-term-sheet/index').'#create?idOsVendorRegist='.$searchModel->task.'&header=Create_Vendor_Term_Sheet').' ';
				            } elseif($searchModel->table_source == "Vendor Term Sheet Verification") {
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-vendor-term-sheet/indexverify').'#viewverify?id='.$searchModel->task.'&header=Detail_Vendor_Term_Sheet').' ';
				            } elseif ($searchModel->table_source == "Vendor Term Sheet Approval"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-vendor-term-sheet/indexapprove').'#viewapprove?id='.$searchModel->task.'&header=Detail_Vendor_Term_Sheet').' ';
				            } elseif ($searchModel->table_source == "Vendor Term Sheet Rejection"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-vendor-term-sheet/index').'#view?id='.$searchModel->task.'&header=Detail_Vendor_Term_Sheet').' ';
				            } elseif ($searchModel->table_source == "Vendor Term Sheet Revision"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-vendor-term-sheet/index').'#view?id='.$searchModel->task.'&header=Detail_Vendor_Term_Sheet').' ';
				            }

							elseif($searchModel->table_source == "Outsource Personil Verification") {
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-outsource-personil/indexverify').'#viewverify?id='.$searchModel->task.'&header=Detail_Outsource_Personil').' ';
				            } elseif ($searchModel->table_source == "Outsource Personil Approval"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-outsource-personil/indexapprove').'#viewapprove?id='.$searchModel->task.'&header=Detail_Outsource_Personil').' ';
				            } elseif ($searchModel->table_source == "Outsource Personil Rejection"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-outsource-personil/index').'#view?id='.$searchModel->task.'&header=Detail_Outsource_Personil').' ';
				            } elseif ($searchModel->table_source == "Outsource Personil Revision"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-outsource-personil/index').'#view?id='.$searchModel->task.'&header=Detail_Outsource_Personil').' ';
				            }

							elseif($searchModel->table_source == "Outsource Salary Verification") {
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-outsource-salary/indexverify').'#viewverify?id='.$searchModel->task.'&header=Detail_Outsource_Salary').' ';
				            } elseif ($searchModel->table_source == "Outsource Salary Approval"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-outsource-salary/indexapprove').'#viewapprove?id='.$searchModel->task.'&header=Detail_Outsource_Salary').' ';
				            } elseif ($searchModel->table_source == "Outsource Salary Rejection"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-outsource-salary/index').'#view?id='.$searchModel->task.'&header=Detail_Outsource_Salary').' ';
				            } elseif ($searchModel->table_source == "Outsource Salary Revision"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-outsource-salary/index').'#view?id='.$searchModel->task.'&header=Detail_Outsource_Salary').' ';
				            }

							elseif($searchModel->table_source == "Vendor PO Blanket Verification") {
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-vendor-pob/indexverify').'#viewverify?id='.$searchModel->task.'&header=Detail_Vendor_PO_Blanket').' ';
				            } elseif ($searchModel->table_source == "Vendor PO Blanket Approval"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-vendor-pob/indexapprove').'#viewapprove?id='.$searchModel->task.'&header=Detail_Vendor_PO_Blanket').' ';
				            } elseif ($searchModel->table_source == "Vendor PO Blanket Rejection"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-vendor-pob/index').'#view?id='.$searchModel->task.'&header=Detail_Vendor_PO_Blanket').' ';
				            } elseif ($searchModel->table_source == "Vendor PO Blanket Revision"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-vendor-pob/index').'#view?id='.$searchModel->task.'&header=Detail_Vendor_PO_Blanket').' ';
				            }

				            elseif ($searchModel->table_source == "Salary Parameter Approval"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-outsource-parameter/indexapprove').'#viewapprove?id='.$searchModel->task.'&header=Detail_Outsource_Parameter').' ';
				            } elseif ($searchModel->table_source == "Salary Parameter Rejection"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-outsource-parameter/index').'#view?id='.$searchModel->task.'&header=Detail_Outsource_Parameter').' ';
				            } elseif ($searchModel->table_source == "Salary Parameter Revision"){
				                return $searchModel->note . '  :  '.$searchModel->task.' '.
				                  Html::a('View',Url::base().'/'.Url::to('os-outsource-parameter/index').'#view?id='.$searchModel->task.'&header=Detail_Outsource_Parameter').' ';
				            }




						},
						'filter'=>true,
					],
				],
			]); ?>
		</div>
	</div>
	<?php if ($personil): ?>
	<div id="secondRowPanel" class="panelContainer full" >
		<div class="panelHeader" id="graphPanelHeader">
			OS Personil

		</div>
		<div class="contentPanel" id="chartPanel2">

		</div>
	</div>
	<?php endif; ?>

	<?php if ($osga): ?>
	<div id="secondRowPanel" class="panelContainer full" >
		<div class="panelHeader" id="graphPanelHeader">
			OS GA
			<div class="col-lg-3 pull-right">
				<?php $form = ActiveForm::begin([]); ?>
					<?= $form->field($modelDashOsGa, 'city')->widget(Select2::classname(), [
						  'data' => ArrayHelper:: map ( DashOsGa:: find()->orderBy(['city'=>SORT_ASC])->all(), 'city','city'),
						  'language' => 'en',
						  'options' => ['placeholder' => 'Kota Jakarta Selatan', 'id' => 'cityga'],
						  'pluginOptions' => [
						  'allowClear' => true],
						  'pluginEvents' => [
							"change" => 'function(data) {
								cityGaChange();
							}',
						],
					  ])->label("") ?>
				 <?php ActiveForm::end(); ?>
			 </div>
		</div>
		<div class="contentPanel" id="chartPanel1">

		</div>
	</div>
	<?php endif; ?>

	<?php if ($osvendor): ?>
	<div id="secondRowPanel" class="panelContainer full" >
		<div class="panelHeader" id="graphPanelHeader">
			OS Vendor

		</div>
		<div class="contentPanel" id="chartPanel3">

		</div>
	</div>
	<?php endif; ?>

</div>
<script>


</script>
