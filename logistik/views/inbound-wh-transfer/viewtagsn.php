<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;

use common\models\Reference;
use common\models\StatusReference;
use common\models\Warehouse;
use common\models\InboundWhTransferDetailSn;
use common\models\InboundWhTransferDetail;
use common\models\OutboundWhTransferDetail;

/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */

// $this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inbound Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$datasession = Yii::$app->session->get('detailinbound');

?>
<div class="inbound-wh-transfer-view">

	<div class='row'>
		<div class='col-sm-6'>
		<?= DetailView::widget([
			'model' => $model,
			'options' => ['class' => 'small table table-striped table-bordered detail-view'],
			'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
			'attributes' => [
				[
					'attribute' => 'no_sj',
					'label' => 'No. Surat Jalan'
				],
				'instruction_number',
				[
					'attribute' => 'wh_destination',
					'value' => function($model){
						return Warehouse::findOne($model->wh_destination)->nama_warehouse;
					},
					'label' => 'Warehouse Origin'
				],
				[
					'attribute' => 'forwarder',
					'value' => function($model){
						if( is_numeric($model->idOutboundWh->forwarder) ){
							return $model->idOutboundWh->forwarder0->description;
						}else{
							return '-';
						}
					},
				],

			],
		]) ?>
		</div>
		<div class='col-sm-6'>
			<?= DetailView::widget([
				'model' => $model,
				'options' => ['class' => 'small table table-striped table-bordered detail-view'],
				'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
				'attributes' => [
					'plate_number',
					'driver',
					'arrival_date:date',

				],
			]) ?>

		</div>
	</div>

	<div class="row">
		<div class="col-sm-offset-8">
			<label>Mac Address
				<?= Html::checkBox('macAddressCheckbox', '', ['id' => 'checkboxMacaddr']) ?>
			</label>
			<?= Html::a(Yii::t('app','Download Template'), ['outbound-wh-transfer/downloadfile', 'id'=>'template'], ['id'=>'templateButton','class' => 'btn btn-primary btn-sm', 'data-method' => 'post']) ?>
			<div class="small text-danger">Check "Mac Address" for Template with Mac Address Column</div>
		</div>
	</div>

	<div class="alert hidden" id="errorSummary">Please fix these following error: <ul id="ulerrorSummary"></ul></div>
	<?php Pjax::begin([
			'id' => 'pjaxindexdetail',
			'timeout' => false,
			'enablePushState' => false,
			'clientOptions' => ['method' => 'GET'
			// , 'backdrop' => false
			],
		]); ?>
    <?= GridView::widget([
        'id' => 'gridViewindexdetail',
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'floatHeader'=>true,
		'floatOverflowContainer' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'item_name',

			],
			[
				'attribute' => 'im_code',

			],
			[
				'attribute' => 'brand',

			],
			[
				'attribute' => 'qty_good',
				'enableSorting' => false,
			],
			[
				'attribute' => 'qty_not_good',
				'enableSorting' => false,
			],
			[
				'attribute' => 'qty_reject',
				'enableSorting' => false,
			],
			[
				'attribute' => 'qty_dismantle',
				'enableSorting' => false,
			],
			[
				'attribute' => 'qty_revocation',
				'enableSorting' => false,
			],
			[
				'attribute' => 'qty_good_rec',
				'enableSorting' => false,
			],
			[
				'attribute' => 'qty_good_for_recond',
				'enableSorting' => false,
			],
			
			[
				'attribute' => 'sn_type',
				'value' => function ($model){
					return Reference::findOne($model->sn_type)->description;
				},
				'filter' => ArrayHelper::map(Reference::find()->andWhere(['table_relation' => 'sn_type'])->all(), 'id_grouping', 'description'),
			],
			[
                'attribute' => 'status_tagsn',
				'label' => 'Status',
                'format' => 'raw',
                'value' => function ($dataProvider) {
					return "<span class='label' style='background-color:".StatusReference::findColor($dataProvider->status_tagsn)."' >".StatusReference::findText($dataProvider->status_tagsn)."</span>";
                },
				'filter' => ArrayHelper::map(StatusReference::find()->andWhere(['id' => [44, 41] ])->all(), 'id', 'status_listing'),

            ],
            [
            	'label' => 'Qty Terima',
            	'format' => 'raw',
            	'value' => function($dataProvider){
            		return $dataProvider->qty_detail;
            	},
            ],
			[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{create} {view} {restore}',
                'buttons'=>[
                    'create' => function ($url, $model) {
                        if($model->status_tagsn == 999 || $model->status_tagsn == 44){
							$label = 'Upload SN';
							$link = '/uploadsn';
							if ($model->sn_type == 2){
								$label = 'QTY Cond';
								$link = '/qtycond';
							}
                            return Html::a('<span style="margin:0px 2px;" class="label label-success">'.$label.'</span>', '#', [
                                'title' => Yii::t('app', 'upload'), 'class' => 'viewButton', 'value'=> Url::to([$this->context->id.$link, 'id' => $model->id_inbound_detail, 'idInboundWh' => Yii::$app->session->get('idInboundWh')]), 'idInboundWh' => $model->id_inbound_detail, 'header'=> yii::t('app','Upload SN')
                            ]);
                        }
                    },

                    'view' => function ($url, $model) {
                        if(($model->status_tagsn == 42 /* || $model->status_tagsn == 44 */)){
                            return Html::a('<span style="margin:0px 2px;" class="label label-info">View</span>', '#', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/viewdetailsn', 'idInboundWhDetail' => $model->id_inbound_detail]), 'header'=> yii::t('app','Detail Serial Number')
                            ]);
                        }
                    },

					'restore' => function ($url, $model){
						if(($model->status_tagsn == 42 || $model->status_tagsn == 44)){
							$count = InboundWhTransferDetailSn::find()->andWhere(['id_inbound_wh_detail' => $model->id_inbound_detail])->count();
							if ($model->sn_type == 2){
								$count = InboundWhTransferDetail::find()->select([new \yii\db\Expression('qty_good + qty_not_good + qty_reject + qty_dismantle + qty_revocation + qty_good_rec + qty_good_for_recond as qty_good')])->andWhere(['id' => $model->id_inbound_detail])->one();
								$count = $count->qty_good;
							}
							if ($count == 0){
								return '';
							}
                            return Html::a('<span style="margin:0px 2px;" class="label label-danger">Reset</span>', '#', [
                                'title' => Yii::t('app', 'Reset'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/resetsn', 'idInboundWhDetail' => $model->id_inbound_detail]), 'header'=> yii::t('app','Create Tag SN')
                            ]);
                        }
					},
                ],
				'visible' => $this->context->action->id != 'exportpdf' && $this->context->action->id != 'viewprintsj',
            ],
			[
				// 'label' => 'Status Tag SN',
				'attribute' => 'status_sn_need_approve',
				// 'visible' => $model->status_sn_need_approve != ''
				// function ($model){
					// return 1 == 1;
					// return $model->status_sn_need_approve != '';
				// }

			],


        ],
    ]); ?>
	<?php yii\widgets\Pjax::end() ?>

	<p>
		<?= Html::button(Yii::t('app','Submit SN'), ['id'=>'submitButton','class' => 'btn btn-success']); ?>
    </p>

</div>
<script>
	$('#checkboxMacaddr').click(function(){
		var url = '<?= Url::to(['outbound-wh-transfer/downloadfile']) ?>';

		if ( $('#checkboxMacaddr').is(':checked') ){
			url = url + '?id=templatemac';
		}else{
			url = url + '?id=template';
		}

		$('#templateButton').attr('href', url);
	});

	$('#updateButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-wh-transfer/update', 'idInboundWh'=>$model->id_inbound_detail]) ;?>');
        $('#modalHeader').html('<h3> Update Detail Inbound PO </h3>');
    });

	$('#submitButton').click(function () {
		var button = $(this);
		button.prop('disabled', true);
		button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

		$.ajax({
			url: '<?php echo Url::to([$this->context->id.'/submitsn', 'id' => Yii::$app->session->get('idInboundWh')]) ;?>',
			type: 'post',
			processData: false,
			contentType: false,
			success: function (response) {
				if(response == 'success') {
					$('#modal').modal('hide');
				} else {
					alert('error with message: ' + response);
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

    });

	$('#inputButton').click(function () {
		var form = $('#gridViewdetail-container');
		data = new FormData();
		data.append('arrival_date', $('#arrival_date-id').val() );
		form.find('input:hidden, input:text')
			.each(function(){
				name = $(this).attr('name');
				val = $(this).val();
				data.append(name, val);
			});

		var button = $(this);
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

		$('#errorSummary').addClass('hidden');
		$('#ulerrorSummary li').remove();
		$('tr[data-key').removeClass('info');

		$.ajax({
            url: '<?php echo Url::to([$this->context->id.'/createdetail', 'idInboundWh' => $model->id_inbound_detail]) ;?>',
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
			dataType: 'json',
            success: function (response) {
                if(response.status == 'success') {
                    $('#modal').modal('hide');
                } else {
                    alert('error with message: ' + response.pesan);
					// pesan = response.pesan;
					// pesan = pesan.split('\n');
					// $('#errorSummary').addClass('alert-danger').removeClass('hidden');
					// for(i = 0; i < pesan.length; i++){
						// $('#ulerrorSummary').append('<li>'+pesan[i]+'</li>');
					// }
					// $('tr[data-key='+response.id+']').addClass('info');
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
	});

	$('.viewButton').click(function () {

        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
        $('#modalHeader').html($(this).attr('header'));
    });
</script>
