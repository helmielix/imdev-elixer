<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs(
"

", \yii\web\View::POS_END);
?>
<div class="instruction-wh-transfer-detail-index">
    
	<?php Pjax::begin([
			'id' => 'pjaxindexdetail', 
			'timeout' => false, 
			'enablePushState' => false, 
			'clientOptions' => ['method' => 'POST'
			// , 'backdrop' => false
			],
		]); ?>
    <?= GridView::widget([
        'id' => 'gridViewindexdetail',
        'dataProvider' => $dataProvider,
		'floatHeader'=>true,
		'floatOverflowContainer' => true,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'id_item_im',
				'value' => 'idMasterItemIm.im_code',
			],
			'req_good',
			'req_not_good',
			'req_reject',
			'req_good_dismantle',
			'req_not_good_dismantle',
			[
				'attribute' => 'sn_type',
				'value' => 'idMasterItemIm.referenceSn.description',
			],
			[
                'attribute' => 'status_listing',
                'format' => 'raw',
                'value' => function ($dataProvider) {
					if($dataProvider->status_listing == 999){
						return "<span class='label' style='background-color:{$dataProvider->statusReference->status_color}' >Not Yet Uploaded</span>";
					}else{
						return "<span class='label' style='background-color:{$dataProvider->statusReference->status_color}' >{$dataProvider->statusReference->status_listing}</span>";
					}
                },
				'visible' => $this->context->action->id == 'create',
            ],
			
			[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{create} {view}',
                'buttons'=>[
                    'create' => function ($url, $model) {
                        if($model->status_listing == 999 || $model->status_listing == 43){
                            return Html::a('<span style="margin:0px 2px;" class="label label-success">Upload SN</span>', '#', [
                                'title' => Yii::t('app', 'upload'), 'class' => 'viewButton', 'value'=> Url::to([$this->context->id.'/uploadsn', 'id' => $model->id, 'idOutboundWh' => $model->id_outbound_wh]), 'idOutboundWh' => $model->id_outbound_wh, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }
                    },
					
                    'view' => function ($url, $model) {
                        if($model->status_listing == 41 || $model->status_listing == 43){
							
                            return Html::a('<span style="margin:0px 2px;" class="label label-info">View</span>', '#', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/viewdetailsn', 'idOutboundWhDetail' => $model->id]), 'header'=> yii::t('app','Detail Serial Number')
                            ]);
                        }
                    },
                ],
            ],
            
        ],
    ]); ?>
	<?php yii\widgets\Pjax::end() ?>
    <p>        
		<?php if(Yii::$app->controller->action->id == 'indexdetail')
			echo Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-success']);  
		
		
		if(Yii::$app->controller->action->id != 'viewapprove'){
			switch(Yii::$app->controller->action->id){
				case 'create':
					$actionName = 'Submit SN';
					$idbutton = 'submitButton';
				break;
				case 'view':
					$actionName = 'Submit';
					$idbutton = 'submitSjButton';
				break;
			}
			?>
			
			<?= Html::button(Yii::t('app',$actionName), ['id'=>$idbutton,'class' => 'btn btn-success']) ?>
			
		<?php } ?>
    </p>
</div>

<script>   
	
    $('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id.'/update','id'=>Yii::$app->session->get('idInstWhTr')]) ;?>');
        $('#modalHeader').html('<h3> Detail Instruksi Warehouse Transfer </h3>');
    });
    
    

</script>
