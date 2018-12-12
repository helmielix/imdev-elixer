<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\Reference;
use common\models\StatusReference;
use common\models\OutboundWhTransferDetailSn;
use yii\widgets\DetailView;

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs(
"
	$('.viewButton').click(function(){
		$('#modal').modal('show')
			.find('#modalContent')
			.load($(this).attr('value'));
		$('#modalHeader').html('<h3> '+ $(this).attr('header') +'</h3>');
	});
", \yii\web\View::POS_END);

function getFilterStatus() {
	if(Yii::$app->controller->action->id == 'create'){
		$sl = ArrayHelper::map( StatusReference::find()->andWhere(['id' => [41, 43]])->all(), 'id', 'status_listing' );
		$sl[999] = 'Not Yet Uploaded';
		return $sl;

	}

} ;

?>
<div class="instruction-wh-transfer-detail-index">

	<?php Pjax::begin([
			'id' => 'pjaxindexdetail',
			'timeout' => false,
			'enablePushState' => false,
			'clientOptions' => ['method' => 'GET'],
		]); ?>
	<?php
		if ($this->context->action->id == 'exportpdf'){
			$searchModel = null;
		}
	?>
	<div class="row">
		<div class="col-sm-6">
			<?= DetailView::widget([
				'model' => $model,
				'options' => ['class' => 'small table table-striped table-bordered detail-view'],
				'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
				'attributes' => [
					[
						'attribute' => 'id_item_im',
						'label' => 'Target Produksi',
						'value' => function($model){
							return $model->idParameterMasterItem->idMasterItemIm->name;
						}
					],
					
					[
						'label' => 'IM Code',
						// 'attribute' => 'id_warehouse',
						'value' => function($model){
							return $model->idParameterMasterItem->idMasterItemIm->im_code;
						}
					],
					'qty'
				],
			]) ?>
		</div>
	</div>
    <?= GridView::widget([
        'id' => 'gridViewindexdetail',
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'floatHeader'=>true,
		'floatOverflowContainer' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
			[
				'attribute' => 'name',
				// 'value' => 'idMasterItemImDetail.idMasterItemIm.name',
				'value' => 'idMasterItemIm.name',
			],
			[
				'attribute' => 'id_item_im',
				// 'value' => 'idMasterItemImDetail.idMasterItemIm.im_code',
				'value' => 'idMasterItemIm.im_code',
			],
			[
				'attribute' => 'brand',
				// 'value' => 'idMasterItemImDetail.idMasterItemIm.brand',
				'value' => 'idMasterItemIm.referenceBrand.description',
			],
			// 'req_good',
			// 'req_not_good',
			// 'req_reject',
			// 'req_good_dismantle',
			// 'req_not_good_dismantle',
			[
				'attribute' => 'sn_type',
				// 'value' => 'idMasterItemImDetail.idMasterItemIm.referenceSn.description',
				'value' => 'idMasterItemIm.referenceSn.description',
				'filter' => ArrayHelper::map(Reference::find()->andWhere(['table_relation' => 'sn_type'])->all(), 'id_grouping', 'description'),
			],
			'req_good',
			'req_dis_good',
			'req_good_recond',
			// 'status_listing',
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
				'filter' => getFilterStatus(),
				'visible' => $this->context->action->id == 'create-item-sn' || $this->context->action->id == 'restore',
            ],

			[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{create} {view} {restore}',
                'buttons'=>[
                    'create' => function ($url, $model) {
                        // if($model->status_listing == 999 || $model->status_listing == 43){
                            return Html::a('<span style="margin:0px 2px;" class="label label-success">Upload SN</span>', '#', [
                                'title' => Yii::t('app', 'upload'), 'class' => 'viewButton', 'value'=> Url::to([$this->context->id.'/uploadsn', 'id' => $model->id, 'idOutboundProdDetail' => $model->id_outbound_production_detail]), 'header'=> yii::t('app','Upload SN')
                            ]);
                        // }
                    },

                    'view' => function ($url, $model) {
                        if(($model->status_listing == 41 || $model->status_listing == 43) && ($this->context->action->id != 'viewprintsj' && $this->context->action->id != 'exportpdf')){
							// if ($model->idMasterItemImDetail->idMasterItemIm->sn_type == 2){
							if ($model->idMasterItemIm->sn_type == 2){
								return '';
							}
                            return Html::a('<span style="margin:0px 2px;" class="label label-info">View</span>', '#', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/viewdetailsn', 'idOutboundProDetail' => $model->id]), 'header'=> yii::t('app','Detail Serial Number')
                            ]);
                        }
                    },

					'restore' => function ($url, $model){
						if ( $this->context->action->id != 'create' && $this->context->action->id != 'restore' ){
							return '';
						}
						if(($model->status_listing == 41 || $model->status_listing == 43) && ($this->context->action->id != 'viewprintsj' && $this->context->action->id != 'exportpdf')){
							$count = OutboundWhTransferDetailSn::find()->andWhere(['id_outbound_production_detail' => $model->id])->count();
							// if ($model->idMasterItemImDetail->idMasterItemIm->sn_type == 2){
							if ($model->idMasterItemIm->sn_type == 2){
								return '';
							}
							if ($count == 0){
								return '';
							}
                            return Html::a('<span style="margin:0px 2px;" class="label label-danger"> <i class="fa fa-undo fa-flip-horizontal"></i> </span>', '#', [
                                'title' => Yii::t('app', 'restore'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/restore', 'idOutboundProDetail' => $model->id, 'id' => $model->id_outbound_production_detail]), 'header'=> yii::t('app','Create Tag SN')
                            ]);
                        }
					},
                ],
				'visible' => ($this->context->action->id != 'exportpdf' && $this->context->action->id != 'viewprintsj') && ($this->context->action->id == 'create-item-sn' || $this->context->action->id == 'restore'),
            ],

        ],
    ]); ?>
	<?php yii\widgets\Pjax::end() ?>
    <p>
		<?php if(Yii::$app->controller->action->id == 'indexdetail')
			echo Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-success']);


		if(Yii::$app->controller->action->id != 'viewapprove'){
			switch(Yii::$app->controller->action->id){
				case 'create': case 'restore':
					$actionName = 'Submit SN';
					$idbutton = 'submitButton';
				break;
				case 'view':
					$actionName = 'Submit';
					$idbutton = 'submitSjButton';
				break;
				case 'viewprintsj':
					$actionName = 'Print PDF';
					$idbutton = 'exportButton';
				break;
				case 'exportpdf': case 'exportinstruction':
					$actionName = '';
					$idbutton = 'exportButton';
				break;
				case 'viewoutbound':
					$actionName = 'Input Tag SN';
					$idbutton = 'createButton';
				break;
				case 'create-item-sn':
					$actionName = 'Input Tag SN';
					$idbutton = 'createButton';
				break;
			}
			?>
			<?php 
				if($idbutton == 'exportButton'){
					echo Html::button(Yii::t('app',$actionName), ['class' => 'btn btn-success printButton','value'=>Url::to(['outbound-production/exportsj', 'id' => $model->id_outbound_production])]) ;	
				}else{
					echo Html::button(Yii::t('app',$actionName), ['id'=>$idbutton,'class' => 'btn btn-success']);
				}
			?>


		<?php } ?>
    </p>
</div>

<script>
	$('.fa-undo').click(function(){
		$(this).addClass('fa-spin');
	});
	$('#createButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id.'/create','id'=>Yii::$app->session->get('idOutboundProd')]) ;?>');
        $('#modalHeader').html('<h3> Create Tag SN </h3>');
    });
    $('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id.'/update','id'=>Yii::$app->session->get('idOutProduction')]) ;?>');
        $('#modalHeader').html('<h3> Detail Instruksi Warehouse Transfer </h3>');
    });

    	$('.printButton').printPage({
		      attr: 'value',
		      message:"Your document is being created"
		    })
  

    

    // $('#printButton').printPage({
    //   attr: 'value',
    //   message:"Your document is being created"
    // });

    $('#exportButton').click(function () {
		var hot = $('#handover_time').val();
		console.log(hot);
		// return false;
        window.open("<?php echo Url::to([$this->context->id.'/exportsj', 'id' => $model->id_outbound_production]) ?>", "_blank");

		/*
		var button = $(this);
		button.prop('disabled', true);
		button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

		data = new FormData();
		data.append( 'time', $( '#handover_time' ).val() );

		$.ajax({
			url: '<?php echo Url::to([$this->context->id.'/savehandovertime', 'id' => $model->id_outbound_production]) ;?>',
			type: 'post',
			data: data,
			processData: false,
			contentType: false,
			success: function (response) {
				if(response == 'success') {
					window.open("<?php echo Url::to([$this->context->id.'/exportpdf', 'id' => $model->id_outbound_production]) ?>", "_blank");
				} else {
					alert('error with message: ' + response.pesan);
				}
			},
			error: function (xhr, getError) {
				if (typeof getError === "object" && getError !== null) {
					error = $.parseJSON(getError.responseText);
					getError = error.message;
				}
				if (xhr.status != 302) {
					alert("System recieve error with code: "+xhr.status);
				}
			},
			complete: function () {
				button.prop('disabled', false);
				$('#spinRefresh').remove();
			},
		});
		*/
    });

</script>
