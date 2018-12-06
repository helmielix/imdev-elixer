<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;

if(Yii::$app->controller->action->id == 'index') $this->title = Yii::t('app','Input GRF Vendor IKO');
if(Yii::$app->controller->action->id == 'indexverify') $this->title = Yii::t('app','Verify GRF Vendor IKO');
if(Yii::$app->controller->action->id == 'indexapprove') $this->title = Yii::t('app','Approve GRF Vendor IKO');
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
            if(Yii::$app->controller->action->id == 'index'){echo 'List Input GRF Vendor IKO';};
            if(Yii::$app->controller->action->id == 'indexverify'){echo 'List GRF Vendor IKO Verification';};
            if(Yii::$app->controller->action->id == 'indexapprove'){echo 'List GRF Vendor IKO Approval';};
            if(Yii::$app->controller->action->id == 'indexoverview'){echo 'List GRF Vendor IKO';};
        ?>
        <?php if (Yii::$app->controller->action->id == 'index') { ?>
            <?= Html::a('Create', '#create', ['class' => 'btn btn-success headerButton', 'id' => 'createModal', 'value'=>Url::to(['iko-grf-vendor/create']), 'header'=> yii::t('app','Create Material GRF Vendor')]) ?>
        <?php } ?>
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
                'template'=>'{view} {update} {zoomto}',
                'buttons'=>[
                    'view' => function ($url, $model) {
                         if(Yii::$app->controller->action->id == 'index' && isset($model->status_listing)){
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#viewinput?id='.$model->id.'&header=Detail_Material_GRF_Vendor_IKO', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['iko-grf-vendor/viewinput','id' => $model->id]), 'header'=> yii::t('app','Detail Material GRF Vendor IKO')
                            ]);
                        } else {
                            if(Yii::$app->controller->action->id == 'indexverify') $viewurl = 'viewverify';
                            if(Yii::$app->controller->action->id == 'indexapprove') $viewurl = 'viewapprove';
                            if(Yii::$app->controller->action->id == 'indexoverview') $viewurl = 'viewoverview';
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#'.$viewurl.'?id='.$model->id.'&header=Detail_Material_GRF_Vendor_IKO', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['iko-grf-vendor/'.$viewurl, 'id' => $model->id]), 'header'=> yii::t('app','Detail Material GRF Vendor IKO')
                                ]);
                        }
                    },
                    'update' => function ($url, $model) {
                        if(Yii::$app->controller->action->id == 'index' && isset($model->status_listing)){
                            if($model->status_listing != 6)
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>', '#update?id='.$model->id.'&header=Update_Material_GRF_Vendor_IKO:_', [
                                'title' => Yii::t('app', 'update'), 'class' => 'viewButton', 'value'=>Url::to(['iko-grf-vendor/update', 'idPlanningIkoBoqP'=> $model->id]), 'header'=> yii::t('app','Update Material GRF Vendor IKO')
                            ]);
                        }
                    },
                    'create' => function ($url, $model,$c) {
                        if(Yii::$app->controller->action->id == 'index' && !isset($model->status_listing)){
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-plus"></span>', '#create?id='.$model->id_iko_boq_p.'&header=Create_Material_GRF_Vendor_IKO', [
                                'title' => Yii::t('app', 'create'), 'class' => 'viewButton', 'value'=>Url::to(['iko-grf-vendor/create', 'id' => $model->id_iko_boq_p]), 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }
                    },
					'zoomto' => function ($url, $model) {
							if($model->idPlanningIkoBoqP->idPlanningIkoBasPlan->idCaBaSurvey->geom != '') {
									return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-screenshot"></span>', '#', [
											'title' => Yii::t('app', 'view'), 'class' => 'zoomtoButton', 'value'=>$model->idPlanningIkoBoqP->idPlanningIkoBasPlan->id_ca_ba_survey
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
                        return "<span class='label' style='background-color:grey'>GRF Vendor Approved</span>";
                    }
                },
                'filter' => getFilterStatus()
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
                'format' => 'date',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'grf_date',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ]),
            ],
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
            ],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
    </div>
</div>
