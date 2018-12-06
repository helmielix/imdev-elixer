<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;

use common\models\OrafinViewMkmPrToPay;

if(Yii::$app->controller->action->id == 'indexlog') $this->title = Yii::t('app','Log History');
// $this->registerCssFile('@commonpath/css/olmap_with_grid.css',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@commonpath/js/mapresize.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@commonpath/js/olmap/listeners/btn_zoomto.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/popup_alert.js',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@commonpath/js/olmap/listeners/btn_resizepanel.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<?php Modal::begin([
        'header'=>'<h3 id="modalHeader"></h3>',
        'id'=>'modal',
        'size'=>'modal-lg'
    ]);
    echo '<div id="modalContent"> </div>';
    Modal::end();
?>


<div class="inbound-po-view">

    
   
        <?php \yii\widgets\Pjax::begin(['id' => 'pjax',]); ?>
    <?php function getFilterStatus() {
        if(Yii::$app->controller->action->id == 'index')
            return [
                1 => 'Inputted',
               
				7 => 'Drafted'
            ];
        if(Yii::$app->controller->action->id == 'indexlog')
            return [
                1 => 'Inputted',
               
                7 => 'Drafted'
            ];
        if(Yii::$app->controller->action->id == 'indexverify')
            return [
                1 => 'Inputted',
                2 => 'Revised',
                4 => 'Verified',
            ];
        if(Yii::$app->controller->action->id == 'indexapprove')
            return [
                5 => 'Approved',
                4 => 'Verified'
            ];
        if(Yii::$app->controller->action->id == 'indexoverview')
            return [
                1 => 'Inputted',
                2 => 'Revised',
                3 => 'Need Revise',
                39 => 'Need Revise by IM',
                5 => 'Approved',
                4 => 'Verified',
                6 => 'Rejected',
            ];
    } ; ?>
    <?php
        $exportColumns = [
            [
                'attribute' => 'iko_grf_vendor.status_listing',
                'value' => function ($searchModel) {
                    return "{$searchModel->statusReference->status_listing}";
                },
            ],
            [
                'attribute' => 'area',
                'value' => 'idPlanningIkoBoqP.idPlanningIkoBasPlan.idCaBaSurvey.idArea.id'
            ],
            [
                'attribute' => 'boq_number',
                'value' => 'idPlanningIkoBoqP.boq_number'
            ],
            'grf_number',
            [
                'attribute' => 'grf_date',
                'value'  => 'grf_date',
            ],
            [
                'attribute' => 'updated_date',
                'value'  => 'updated_date',
            ],
        ]
    ?>
        <?php if (Yii::$app->controller->action->id == 'indexoverview'): ?>
            <?= ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $exportColumns
            ]); ?>
        <?php endif; ?>
		
		
    <?= GridView::widget([
        'id' => 'gridView',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
				'class' => 'yii\grid\ActionColumn',
				'template'=>'{view} {create} {update}',
                'buttons'=>[
                    'view' => function ($url, $model) {
                         if(Yii::$app->controller->action->id == 'index' && (!isset($model->status_listing))){
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#viewlog?id='.$model->idlog.'&header=Detail_Material_GRF_Vendor_IKO', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['inbound-wh-transfer/viewlog','id' => $model->idlog]), 'header'=> yii::t('app','Detail Inbound WH Transfer')
                            ]);
                        } 
						else {
                            if(Yii::$app->controller->action->id == 'indextagsn') $viewurl = 'viewsn';
                            if(Yii::$app->controller->action->id == 'index' && $model->status_listing != 42) $viewurl = 'view';
                            if(Yii::$app->controller->action->id == 'indexlog' && $model->status_listing != 42) $viewurl = 'viewlog';
                            if(Yii::$app->controller->action->id == 'indexapprove') $viewurl = 'viewapprove';
                            if(Yii::$app->controller->action->id == 'indexoverview') $viewurl = 'viewoverview';
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#'.$viewurl.'?id='.$model->id_outbound_wh.'&header=Detail_Material_GRF_Vendor_IKO', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['inbound-wh-transfer/'.$viewurl, 'id' => $model->id_outbound_wh]), 'header'=> yii::t('app','Detail Inbound PO')
                                ]);
                        }
                    },
					'create' => function ($url, $model) {
                        if(Yii::$app->controller->action->id == 'index' && !isset($model->status_listing)){
                            // if($model->status_listing != 6)
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-plus"></span>', '#create?id='.$model->id_outbound_wh.'&header=Update_Material_GRF_Vendor_IKO:_', [
                                'title' => Yii::t('app', 'create'), 'class' => 'viewButton', 'value'=>Url::to(['inbound-wh-transfer/create', 'idOutboundWh'=> $model->id_outbound_wh]), 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }
                    },
					'update' => function ($url, $model) {
                        if(Yii::$app->controller->action->id == 'index' && $model->status_listing == 1){
                            // if($model->status_listing != 6)
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>', '#update?id='.$model->id_outbound_wh.'&header=Update_Material_GRF_Vendor_IKO:_', [
                                'title' => Yii::t('app', 'update'), 'class' => 'viewButton', 'value'=>Url::to(['inbound-wh-transfer/update', 'idOutboundWh'=> $model->id_outbound_wh]), 'header'=> yii::t('app','Update Material GRF Vendor IKO')
                            ]);
                        }
                    },
                ],
			],
			[
                'attribute' => 'status_listing',
                'format' => 'raw',
                'value' => function ($searchModel) {
                    if ($searchModel->status_listing != '') {
                        return "<span class='label' style='background-color:{$searchModel->statusListing->status_color}' >{$searchModel->statusListing->status_listing}</span>";
                    } else {
                        return "<span class='label' style='background-color:red'>New Intransit</span>";
                    }
                },
                'filter' => getFilterStatus()
            ],
            'no_sj',
            // 'delivery_target_date',
            // 'wh_destination',
			[
				'attribute' => 'arrival_date',
				'value'  => 'arrival_date',
				'format' => 'date',
				'filter' => DatePicker::widget([
					'model' => $searchModel,
					'attribute' => 'arrival_date',
					'clientOptions' => [
						'autoclose' => true,
						'format' => 'yyyy-mm-dd',
					],
				]),
			],
			[
				'attribute' => 'wh_origin',
				'value' => 'idOutboundWh.idInstructionWh.whOrigin.nama_warehouse',				
			],
			
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
   
</div>