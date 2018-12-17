<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;

use common\models\OrafinViewMkmPrToPay;
use common\models\StatusReference;
use common\models\Warehouse;

$this->title = Yii::t('app','Warehouse Transfer');

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
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


<div class="inbound-po-view">
	<h3>
	<?php
		if(Yii::$app->controller->action->id == 'index'){
			echo 'List Input Inbound Warehouse Transfer';
		};
		if(Yii::$app->controller->action->id == 'indexprintsj'){echo 'List Print Surat Jalan';};
		if(Yii::$app->controller->action->id == 'indextagsn'){echo 'List Tag SN';};
		if(Yii::$app->controller->action->id == 'indextagsnapprove'){echo 'List Approve Tag SN';};
		if(Yii::$app->controller->action->id == 'indexapprove'){echo 'List Approval Surat Jalan';};
	?>
	</h3>


        <?php \yii\widgets\Pjax::begin(['id' => 'pjax',]); ?>
        <?php 
            function getFilterWh(){
                if(Yii::$app->controller->action->id == 'index'){
                    $list = ArrayHelper::map( Warehouse::find()->all(), 'id', 'nama_warehouse' );
                    // $list[999] = 'new Received';
                    // $list[1] = 'Inputted';
                    return $list;
                }
            }
        ?>
    <?php function getFilterStatus() {
        if(Yii::$app->controller->action->id == 'index'){
			$list = ArrayHelper::map( StatusReference::find()->andWhere(['id' => [1,31, 999] ])->all(), 'id', 'status_listing' );
            $list[999] = 'new Received';
			// $list[1] = 'Inputted';
			return $list;
		}

        if(Yii::$app->controller->action->id == 'indexverify')
            return [
                31 => 'Uncompleted',
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
    } ;
	function getFilterStatusTagsn(){
		if(Yii::$app->controller->action->id == 'indextagsn'){
			$list = ArrayHelper::map( StatusReference::find()->andWhere(['id' => [41, 43, 999] ])->all(), 'id', 'status_listing' );
			$list[999] = 'new WT';
			return $list;
		}
		if(Yii::$app->controller->action->id == 'indextagsnapprove'){
			$list = ArrayHelper::map( StatusReference::find()->andWhere(['id' => [46, 5] ])->all(), 'id', 'status_listing' );
			// $list[999] = 'new WT';
			return $list;
		}
	}
	?>
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
				'template'=>'{view}',
                'buttons'=>[
					'view' => function ($url, $model) {
                        if(Yii::$app->controller->action->id == 'index' && !isset($model->status_listing)){
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-plus"></span>', '#viewoutbound?id='.$model->id_outbound_wh.'&header=Create_Tag_SN', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/viewoutbound','id' => $model->id_outbound_wh]), 'header'=> yii::t('app','Data Outbound Warehouse Transfer')
                            ]);
                        }
						else {
							$icon = 'eye-open';
                            if(Yii::$app->controller->action->id == 'index') {
								$viewurl = 'viewinbound';
								$header = 'Input Inbound Warehouse Transfer';
                                if ($model->status_listing == 52){
                                    $icon = 'plus';
                                    $viewurl = 'viewoutbound';
                                    $header = 'Data Outbound Warehouse Transfer';
                                }
							}
							if(Yii::$app->controller->action->id == 'indextagsn') {
								$viewurl = 'viewtagsn';
								$header = 'Create Tag SN';

								if ($model->status_tagsn == 999){
									$icon = 'plus';
								}
							}
							if(Yii::$app->controller->action->id == 'indextagsnapprove') {
								$viewurl = 'viewtagsnapprove';
								$header = 'Re-Tag SN';
							}
                            if(Yii::$app->controller->action->id == 'indexprintsj') {
								$viewurl = 'view';
								$header = 'Create Surat Jalan';
								$headerlnk = str_replace(' ', '_', $header);
								if ($model->status_listing == 42){ // tag inputted
									$icon = 'plus';
								}
								if ($model->status_listing == 25){ // ready to print
									$viewurl = 'viewprintsj';
									$header = '';
								}
							}
							if(Yii::$app->controller->action->id == 'indexapprove') {
								$viewurl = 'viewreportapprove';
								$header = 'Detail view inbound warehouse transfer';
							}
							if(Yii::$app->controller->action->id == 'indexverify') {
								$viewurl = 'viewreportverify';
								$header = 'Detail view inbound warehouse transfer';
							}
                            if(Yii::$app->controller->action->id == 'indexoverview'){
								$viewurl = 'viewoverview';
							}

							$headerlnk = str_replace(' ', '_', $header);
							return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-'.$icon.'"></span>', '#'.$viewurl.'?id='.$model->id_outbound_wh.
							'&header='.$headerlnk, [
								'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/'.$viewurl, 'id' => $model->id_outbound_wh]), 'header'=> yii::t('app',$header)
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
                        return "<span class='label' style='background-color:red'>New Received</span>";
                    }
                },
                'filter' => getFilterStatus(),
				'visible' => $this->context->action->id == 'index',
            ],
			[
                'attribute' => 'status_tagsn',
                'format' => 'raw',
                'value' => function ($searchModel) {
                    if ($searchModel->status_tagsn != 999) {
                        return "<span class='label' style='background-color:{$searchModel->statusTagsn->status_color}' >{$searchModel->statusTagsn->status_listing}</span>";
                    } else {
                        return "<span class='label' style='background-color:red'>New WT</span>";
                    }
                },
                'filter' => getFilterStatusTagsn(),
				'visible' => $this->context->action->id == 'indextagsn',
            ],
			[
                'attribute' => 'status_retagsn',
                'format' => 'raw',
                'value' => function ($searchModel) {
                    if ($searchModel->status_retagsn != 999) {
                        return "<span class='label' style='background-color:{$searchModel->statusRetagsn->status_color}' >{$searchModel->statusRetagsn->status_listing}</span>";
                    } else {
                        return "<span class='label' style='background-color:red'>New WT</span>";
                    }
                },
                'filter' => getFilterStatusTagsn(),
				'visible' => $this->context->action->id == 'indextagsnapprove',
            ],
			[
                'attribute' => 'status_report',
                'format' => 'raw',
                'value' => function ($searchModel) {
					return "<span class='label' style='background-color:".StatusReference::findColor($searchModel->status_report)."' >".StatusReference::findText($searchModel->status_report)."</span>";
                },
                'filter' => getFilterStatus(),
				'visible' => $this->context->action->id == 'indexverify' || $this->context->action->id == 'indexapprove',
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
                'filter' => getFilterWh(),
			],

        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>

</div>
