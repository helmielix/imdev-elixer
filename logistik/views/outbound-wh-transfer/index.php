<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;
use common\models\StatusReference;
use common\models\User;

$this->title = Yii::t('app','Warehouse Transfer');
// if(Yii::$app->controller->action->id == 'index')
// if(Yii::$app->controller->action->id == 'indexapprove') $this->title = Yii::t('app','Verify GRF Vendor IKO');

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/popup_alert.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/jquery.printPage.js',['depends' => [\yii\web\JqueryAsset::className()]]);

function getFilterStatus() {
	if(Yii::$app->controller->action->id == 'index'){
		$filter = ArrayHelper::map(StatusReference::find()->andWhere(['id' => [48, 42]])->all(), 'id', 'status_listing');
		$filter[999] = 'New Instruction';
		return $filter;
	}
	if(Yii::$app->controller->action->id == 'indexprintsj')
		return ArrayHelper::map(StatusReference::find()->andWhere(['id' => [42, 3, 22, 25]])->all(), 'id', 'status_listing');

	if(Yii::$app->controller->action->id == 'indexapprove'){
		return [
			22 => 'Inputted',
			25 => 'Approved'
		];
	}
		// return [
			// 5 => 'Approved',
			// 4 => 'Verified'
		// ];
	if(Yii::$app->controller->action->id == 'indexoverview')
		$filter = ArrayHelper::map(StatusReference::find()->andWhere(['id' => [48, 42, 3, 22, 25]])->all(), 'id', 'status_listing');
		$filter[999] = 'New Instruction';
		return $filter;
		// return [
		// 	1 => 'Inputted',
		// 	2 => 'Revised',
		// 	3 => 'Need Revise',
		// 	// 39 => 'Need Revise by IM',
		// 	5 => 'Approved',
		// 	4 => 'Verified',
		// 	6 => 'Rejected',
		// ];
} ;
?>
<?php Modal::begin([
		'header'=>'<h3 id="modalHeader"></h3>',
		'id'=>'modal',
		'size'=>'modal-lg',

	]);

	echo '<div id="modalContent"> </div>';

	Modal::end();
?>
<div id="southPanel">

    <div id="southPanelHeader">
        <div class="panelZoomController">

        </div>
		<h3>
        <?php
            if(Yii::$app->controller->action->id == 'index'){
				echo 'List Tag SN';
			};
            if(Yii::$app->controller->action->id == 'indexprintsj'){echo 'List Print Surat Jalan';};
            if(Yii::$app->controller->action->id == 'indexapprove'){echo 'List Approval Surat Jalan';};
            if(Yii::$app->controller->action->id == 'indexoverview'){echo 'List Overview Surat Jalan';};
        ?>
		</h3>

    </div>


<?php Pjax::begin(['id' => 'pjax', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]) ?>
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
				'class' => 'yii\grid\ActionColumn',
				'template'=>'{view}',
                'buttons'=>[
                    'view' => function ($url, $model) {
                        if(Yii::$app->controller->action->id == 'index' && !isset($model->status_listing)){
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-plus"></span>', '#viewinstruction?id='.$model->id_instruction_wh.'&header=Create_Tag_SN', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/viewinstruction','id' => $model->id_instruction_wh]), 'header'=> yii::t('app','Create Tag SN')
                            ]);
                        }
						else {
							$icon = 'eye-open';
                            if(Yii::$app->controller->action->id == 'index') {
								$viewurl = 'viewoutbound';
								$header = 'Detail Outbound Warehouse Transfer';
								if ($model->status_listing == 51) { // new instruction belum submit
									$icon = 'plus';
								}
							}
                            if(Yii::$app->controller->action->id == 'indexprintsj') {
								$viewurl = 'view';
								$header = 'Detail Surat Jalan';
								$headerlnk = str_replace(' ', '_', $header);
								$icon = 'eye-open';
								if ($model->status_listing == 42){ // tag inputted
									$icon = 'plus';
								}
								if ($model->status_listing == 25){ // ready to print
									$viewurl = 'viewprintsj';
									$header = '';
								}
	                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-'.$icon.'"></span>', '#'.$viewurl.'?id='.$model->id_instruction_wh.
								'&show=detail&header='.$headerlnk, [
	                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/'.$viewurl, 'id' => $model->id_instruction_wh, 'show' => 'detail']) , 'header'=> yii::t('app',$header)
	                                ]);
							}
							if(Yii::$app->controller->action->id == 'indexapprove') {
								$viewurl = 'viewapprove';
								$header = 'Approval Surat Jalan';
							}
                            if(Yii::$app->controller->action->id == 'indexoverview'){
								$viewurl = 'viewoverview';
								$header = 'Detail Outbound Warehouse Transfer';
							}

							$headerlnk = str_replace(' ', '_', $header);
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-'.$icon.'"></span>', '#'.$viewurl.'?id='.$model->id_instruction_wh.
							'&header='.$headerlnk, [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/'.$viewurl, 'id' => $model->id_instruction_wh]), 'header'=> yii::t('app',$header)
                                ]);
                        }
                    },
                ],
			],
			[
                'attribute' => 'status_listing',
                'format' => 'raw',
                'value' => function ($searchModel) {
                	if ($searchModel->status_listing){
	                    if ($searchModel->status_listing == 42) {
	                    	$color = 'blue';
	                    	if($this->context->action->id == 'indexprintsj'){
	                    		$color = 'red';
	                    	}
	                        return "<span class='label' style='background-color:{$color}' >{$searchModel->statusReference->status_listing}</span>";
						} else if ($this->context->action->id == 'indexapprove'){
							if ($searchModel->status_listing == 22) $searchModel->status_listing = 1;
							if ($searchModel->status_listing == 25) $searchModel->status_listing = 5;
							return "<span class='label' style='background-color:{$searchModel->statusReference->status_color}' >{$searchModel->statusReference->status_listing}</span>";
	                    } else {
	                        return "<span class='label' style='background-color:{$searchModel->statusReference->status_color}' >{$searchModel->statusReference->status_listing}</span>";
	                    }
	                }else{
	                	return "<span class='label' style='background-color:red' >New Instruction</span>";
	                }
                },
                'filter' => getFilterStatus()
            ],
			[
				'attribute' => 'no_sj',
				'visible' => $this->context->action->id != 'index',
			],
            'instruction_number',

			[
				'attribute' => 'delivery_target_date',
				'value'  => 'delivery_target_date',
				'format' => 'date',
				'filter' => DatePicker::widget([
					'model' => $searchModel,
					'attribute' => 'delivery_target_date',
					'clientOptions' => [
						'autoclose' => true,
						'format' => 'yyyy-mm-dd',
					],
				]),
			],
			[
				'attribute' => 'wh_origin',
				'value' => 'idInstructionWh.whOrigin.nama_warehouse',
				'visible' => $this->context->action->id == 'index',
			],

			[
				'attribute' => 'wh_destination',
				'value' => 'idInstructionWh.whDestination.nama_warehouse',
			],
			[
            	'attribute' => 'updated_by',
            	'label' => 'Last Updated',
            	'value' => function($model){
            		if (is_numeric($model->updated_by)) {
            			return User::findOne($model->updated_by)->name;
            		}
            	},
            	'filter' => Select2::widget([
	                'model' => $searchModel,
	                'attribute' => 'updated_by',
	                'data' => ArrayHelper::map(User::find()->all(), 'id', 'name'),
	                'options' => ['placeholder' => 'Last Updated'],
	                'pluginOptions' => [
        				'allowClear' => true],
	            ]),
            ],
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
<?php Pjax::end(); ?></div>
