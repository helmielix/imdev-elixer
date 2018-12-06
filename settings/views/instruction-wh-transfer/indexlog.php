<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;

$this->title = Yii::t('app','Warehouse Transfer Instruction');
// if(Yii::$app->controller->action->id == 'index') 
// if(Yii::$app->controller->action->id == 'indexapprove') $this->title = Yii::t('app','Verify GRF Vendor IKO');

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@commonpath/js/popup_alert.js',['depends' => [\yii\web\JqueryAsset::className()]]);

function getFilterStatus() {
	if(Yii::$app->controller->action->id == 'index')
		return [
			1 => 'Inputted',
			2 => 'Revised',
			3 => 'Need Revise',
			6 => 'Rejected',
			7 => 'Drafted'
		];
	if(Yii::$app->controller->action->id == 'indexapprove')
		return [
			5 => 'Approved',
			1 => 'Inputted'
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
            // if(Yii::$app->controller->action->id == 'index'){
				echo 'List Input Warehouse Transfer Instruction';
			// };
            // if(Yii::$app->controller->action->id == 'indexapprove'){echo 'List Inbound PO Approval';};
        ?>
		</h3>
		<div class="row">
			<div class="col-sm-12">
				<p class="pull-right">
					<?php if (Yii::$app->controller->action->id == 'index') { ?>
						<?=  Html::a('Create', '#create?header=Create Instruksi Warehouse Transfer', ['class' => 'btn btn-success', 'id' => 'createModal', 'value'=>Url::to(['instruction-wh-transfer/create']), 'header'=> yii::t('app','Create Instruksi Warehouse Transfer')]) ; ?>
					<?php } ?>
				</p>
			</div>
		</div>
		
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
                         if(Yii::$app->controller->action->id == 'index' && isset($model->status_listing)){
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#view?id='.$model->idlog.'&header=Detail_Material_GRF_Vendor_IKO', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['instruction-wh-transfer/view','id' => $model->idlog]), 'header'=> yii::t('app','Detail Material GRF Vendor IKO')  
                            ]);
                        } 
						else {
                            if(Yii::$app->controller->action->id == 'index') $viewurl = 'view';
                             if(Yii::$app->controller->action->id == 'indexlog') $viewurl = 'viewlog';
                            if(Yii::$app->controller->action->id == 'indexapprove') $viewurl = 'viewapprove';
                            if(Yii::$app->controller->action->id == 'indexoverview') $viewurl = 'viewoverview';
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#'.$viewurl.'?id='.$model->id.'&header=Detail_Material_GRF_Vendor_IKO', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['instruction-wh-transfer/'.$viewurl, 'id' => $model->id]), 'header'=> yii::t('app','Detail Inbound PO')  
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
            'instruction_number',
            'delivery_target_date',
            [
            	'attribute' => 'wh_destination',
            	'value' => 'whDestination.nama_warehouse'
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

<script>

</script>