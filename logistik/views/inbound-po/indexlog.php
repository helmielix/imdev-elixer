<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;

use common\models\OrafinViewMkmPrToPay;

if(Yii::$app->controller->action->id == 'index') $this->title = Yii::t('app','Inbound PO');
if(Yii::$app->controller->action->id == 'indexverify') $this->title = Yii::t('app','Verify GRF Vendor IKO');
if(Yii::$app->controller->action->id == 'indexapprove') $this->title = Yii::t('app','Approve Inbound PO');
if(Yii::$app->controller->action->id == 'indexoverview') $this->title = Yii::t('app','Overview GRF Vendor IKO');
if(Yii::$app->controller->action->id == 'indexlog') $this->title = Yii::t('app','Log History');

// $this->registerCssFile('@commonpath/css/olmap_with_grid.css',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@commonpath/js/mapresize.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@commonpath/js/olmap/listeners/btn_zoomto.js',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@commonpath/js/popup_alert.js',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@commonpath/js/olmap/listeners/btn_resizepanel.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<?php Modal::begin([
        'header'=>'<h3 id="modalHeader"></h3>',
        'id'=>'modal',
        'size'=>'modal-lg',
    ]);
    echo '<div id="modalContent"> </div>';
    Modal::end();
?>

<div class="inbound-po-view">

        <?php
            if(Yii::$app->controller->action->id == 'index'){echo 'List Input Inbound PO';};
            if(Yii::$app->controller->action->id == 'indexverify'){echo 'List Inbound PO Verification';};
            if(Yii::$app->controller->action->id == 'indexapprove'){echo 'List Inbound PO Approval';};
            if(Yii::$app->controller->action->id == 'indexlog'){echo 'List Log History';};
        ?>
    
   
        <?php \yii\widgets\Pjax::begin(['id' => 'pjax',]); ?>
    <?php function getFilterStatus() {
        if(Yii::$app->controller->action->id == 'index')
            return [
                1 => 'Inputted',
                2 => 'Revised',
                3 => 'Need Revise',
                5 => 'Approved',
                4 => 'Verified',
               
				7 => 'Drafted'
            ];
        if(Yii::$app->controller->action->id == 'indexlog')
            return [
                1 => 'Inputted',
                42 => 'Tag Inputted',
                2 => 'Revised',
                3 => 'Need Revise',
                5 => 'Approved',
                4 => 'Verified',
                7 => 'Drafted',
                13 => 'Deleted' ,
                48 => 'Partially Tag Uploaded',

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
		
		<p>
			<?php if (Yii::$app->controller->action->id == 'index') { ?>
				<?=  Html::a('Create', '#create?header=Create', ['class' => 'btn btn-success', 'id' => 'createModal', 'value'=>Url::to(['inbound-po/create']), 'header'=> yii::t('app','Create')]) ; ?>
			<?php } ?>
		</p>
    <?= GridView::widget([
        'id' => 'gridView',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} ',
                'buttons'=>[
                    'view' => function ($url, $model) {
                         if(Yii::$app->controller->action->id == 'index' && isset($model->status_listing)){
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#viewinput?id='.$model->idlog.'&header=Detail_Material_GRF_Vendor_IKO', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['inbound-po/view','id' => $model->idlog]), 'header'=> yii::t('app','Detail Material GRF Vendor IKO')
                            ]);
                        } 
						else {
                            if(Yii::$app->controller->action->id == 'indextagsn') $viewurl = 'viewsn';
                            if(Yii::$app->controller->action->id == 'index') $viewurl = 'view';
                            if(Yii::$app->controller->action->id == 'indexlog') $viewurl = 'viewlog';
                            if(Yii::$app->controller->action->id == 'indexapprove') $viewurl = 'viewapprove';
                            if(Yii::$app->controller->action->id == 'indexoverview') $viewurl = 'viewoverview';
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#'.$viewurl.'?id='.$model->id.'&header=Detail_Material_GRF_Vendor_IKO', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['inbound-po/'.$viewurl, 'id' => $model->idlog]), 'header'=> yii::t('app','Detail Inbound PO')
                                ]);
                        }
                    },
                    'update' => function ($url, $model) {
                        if(Yii::$app->controller->action->id == 'index' && $model->status_listing != 42){
                            if($model->status_listing != 6)
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>', '#update?id='.$model->id.'&header=Update_Material_GRF_Vendor_IKO:_', [
                                'title' => Yii::t('app', 'update'), 'class' => 'viewButton', 'value'=>Url::to(['inbound-po/update', 'idInboundPo'=> $model->id]), 'header'=> yii::t('app','Update Material GRF Vendor IKO')
                            ]);
                        }
                    },
					
                ],
            ],
            [
                'attribute' => 'status_listing',
                'format' => 'raw',
                'value' => function ($searchModel) {
					if($searchModel->statusReference){
						if(Yii::$app->controller->action->id == 'indextagsn' && $searchModel->status_listing == 1){
							return "<span class='label' style='background-color:red' >New Inbound PO</span>";
						}else{							
							return "<span class='label' style='background-color:{$searchModel->statusReference->status_color}' >{$searchModel->statusReference->status_listing}</span>";
						}
					}
                    
                },
                'filter' => getFilterStatus(),
            ],
			[
				'attribute' => 'rr_number',
			],
			'po_number',
			'pr_number',
			[
					'attribute' => 'tgl_sj',
					'value'  => 'tgl_sj',
					'format' => 'date',
					'filter' => DatePicker::widget([
						'model' => $searchModel,
						'attribute' => 'tgl_sj',
						'clientOptions' => [
							'autoclose' => true,
							'format' => 'yyyy-mm-dd',
						],
					]),
				],
			'supplier',
            // [
				// 'label' => 'PR Number',
				// 'value' => 'idOrafinRr.pr_number'
			// ],
			// [
				// 'label' => 'PO Number',
				// 'value' => 'idOrafinRr.po_number'
			// ],
			// [
				// 'label' => 'RR Date',
				// 'value' => 'idOrafinRr.rr_date'
			// ],
			// [
				// 'label' => 'Suplier',
				// // 'value' => '-',
			// ],
			
			
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
   
</div>
