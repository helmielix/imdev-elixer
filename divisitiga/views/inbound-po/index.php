<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;

if(Yii::$app->controller->action->id == 'index') $this->title = Yii::t('app','Inbound PO');
if(Yii::$app->controller->action->id == 'indexverify') $this->title = Yii::t('app','Verify GRF Vendor IKO');
if(Yii::$app->controller->action->id == 'indexapprove') $this->title = Yii::t('app','Approve Inbound PO');
if(Yii::$app->controller->action->id == 'indexoverview') $this->title = Yii::t('app','Overview GRF Vendor IKO');

// $this->registerCssFile('@commonpath/css/olmap_with_grid.css',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@commonpath/js/mapresize.js',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@commonpath/js/olmap/listeners/btn_zoomto.js',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@commonpath/js/popup_alert.js',['depends' => [\yii\web\JqueryAsset::className()]]);
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



<div id="southPanel" >
    <div id="southPanelHeader">
        <div class="panelZoomController">
            <span class="panelZoomButton up"> &#x2912; </span>
            <span class="panelZoomSeparator"> </span>
            <span class="panelZoomButton down"> &#x2913; </span>
        </div>
        <?php
            if(Yii::$app->controller->action->id == 'index'){echo 'List Input Inbound PO';};
            if(Yii::$app->controller->action->id == 'indexverify'){echo 'List Inbound PO Verification';};
            if(Yii::$app->controller->action->id == 'indexapprove'){echo 'List Inbound PO Approval';};
        ?>
       
    </div>
    <div id="southPanelGrid">
        <?php \yii\widgets\Pjax::begin(['id' => 'pjax',]); ?>
    <?php function getFilterStatus() {
        if(Yii::$app->controller->action->id == 'index')
            return [
                1 => 'Inputted',
                2 => 'Revised',
                3 => 'Need Revise',
                39 => 'Need Revise by IM',
				6 => 'Rejected',
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
                'template'=>'{view} {update} {create}',
                'buttons'=>[
                    'view' => function ($url, $model) {
                         if(Yii::$app->controller->action->id == 'index' && isset($model->status_listing)){
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#viewinput?id='.$model->id.'&header=Detail_Material_GRF_Vendor_IKO', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['inbound-po/viewinput','id' => $model->id]), 'header'=> yii::t('app','Detail Material GRF Vendor IKO')
                            ]);
                        } 
						// else {
                            // if(Yii::$app->controller->action->id == 'indexverify') $viewurl = 'viewverify';
                            // if(Yii::$app->controller->action->id == 'indexapprove') $viewurl = 'viewapprove';
                            // if(Yii::$app->controller->action->id == 'indexoverview') $viewurl = 'viewoverview';
                            // return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#'.$viewurl.'?id='.$model->id.'&header=Detail_Material_GRF_Vendor_IKO', [
                                // 'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['iko-grf-vendor/'.$viewurl, 'id' => $model->id]), 'header'=> yii::t('app','Detail Material GRF Vendor IKO')
                                // ]);
                        // }
                    },
                    'update' => function ($url, $model) {
                        if(Yii::$app->controller->action->id == 'index' && isset($model->status_listing)){
                            if($model->status_listing != 6)
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>', '#update?id='.$model->id.'&header=Update_Material_GRF_Vendor_IKO:_', [
                                'title' => Yii::t('app', 'update'), 'class' => 'viewButton', 'value'=>Url::to(['iko-grf-vendor/update', 'idPlanningIkoBoqP'=> $model->id]), 'header'=> yii::t('app','Update Material GRF Vendor IKO')
                            ]);
                        }
                    },
                    'create' => function ($url, $model) {
                        if(Yii::$app->controller->action->id == 'index' ){
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-plus"></span>', 'create?idOrafinRr='.$model->id_orafin_rr.'&header=Create_Material_GRF_Vendor_IKO', [
                                'title' => Yii::t('app', 'create'), 'class' => 'viewButton', 'value'=>Url::to(['inbound-po/create', 'idOrafinRr' => $model->id_orafin_rr]), 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }
                    },
					
                ],
            ],
            [
                'attribute' => 'status_listing',
                'format' => 'raw',
                'value' => function ($searchModel) {
                    if ($searchModel->status_listing) {
                        return "<span class='label' style='background-color:{$searchModel->statusReference->status_color}' >{$searchModel->statusReference->status_listing}</span>";
                    } else {
                        return "<span class='label' style='background-color:grey'>Open RR</span>";
                    }
                },
                'filter' => getFilterStatus()
            ],
			[
				'attribute' => 'rr_number',
				'value' => 'idOrafinRr.rr_number'
			],
            [
				'label' => 'PR Number',
				'value' => 'idOrafinRr.pr_number'
			],
			[
				'label' => 'PO Number',
				'value' => 'idOrafinRr.po_number'
			],
			[
				'label' => 'RR Date',
				'value' => 'idOrafinRr.rr_date'
			],
			[
				'label' => 'Suplier',
				// 'value' => '-',
			],
			
			
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
    </div>
</div>
