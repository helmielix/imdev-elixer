<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;

use common\models\Reference;
use common\models\StatusReference;
use common\models\Warehouse;
use common\models\OutboundWhTransferDetailSn;
use common\models\InboundWhTransferDetailSn;

/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */

// $this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inbound Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@commonpath/js/popup_alert.js',['depends' => [\yii\web\JqueryAsset::className()]]);

$datasession = Yii::$app->session->get('detailreport');
$status = $dataProvider->getModels();
if ( count($status) > 0 ){
	$status_report = $status[0]->status_report;
}else{
	$status_report = 5;
}

?>
<div class="inbound-wh-transfer-view">

	<div class='row'>
		<div class='col-sm-12'>
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
						return Warehouse::findOne($model->idOutboundWh->idInstructionWh->wh_destination)->nama_warehouse;
					},
					'label' => 'Warehouse Tujuan'
				],
				[
					'attribute' => 'forwarder',
					'value' => function ($model){
						if( is_numeric($model->idOutboundWh->forwarder) ){
							return $model->idOutboundWh->forwarder0->description;
						}else{
							return '-';
						}
					},
				],
				'plate_number',
				'driver',
				'arrival_date:date',
				'revision_remark:ntext',
			],
		]) ?>
		</div>

	</div>

	<div class="alert hidden" id="errorSummary">Please fix these following error: <ul id="ulerrorSummary"></ul></div>
	<?php
	Pjax::begin(['id' => 'pjaxviewdetail', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']]) ;
	// Pjax::begin()

	?>
	<?= GridView::widget([
        'id' => 'gridViewdetail',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

			'item_name',
			'im_code',
			'brand',
			[
				'attribute' => 'sn_type',
				'value' => function ($model){
					return Reference::findOne($model->sn_type)->description;
				},
				'filter' => ArrayHelper::map( Reference::find()->andWhere(['table_relation' => 'sn_type'])->all(),'id','description'  ),
			],
			'req_qty',

			[
				'attribute' => 'qty_detail',
				'format' => 'raw',
				'value' => function ($model) use (&$status){
					$status = $model->status_report;
					return $model->qty_detail;
					// $val = '';
					// if (isset($datasession[$model->id_item_im])){
						// $val = $datasession[$model->id_item_im];
					// }else{
						// $val = $model->qty_detail;
					// }
					// $out = Html::textInput('req_qty[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'qty_detail', 'qtydetail' => $model->qty_detail]);
					// return $out.Html::hiddenInput('im_code[]', $model->id_item_im.';'.$model->im_code.';'.$model->id_detail.';'.$model->id_outbound_wh_detail, ['class' => 'im_code']);
				},
			],
			[
				'attribute' => 'delta',
				'value' => function ($model) use ($datasession){
					return $model->delta;
					// $val = 0;
					// if (isset($datasession[$model->id_item_im])){
						// $val = $datasession[$model->id_item_im];
					// }else{
						// $val = $model->qty_detail;
					// }
					// return $model->req_qty - $val;
				},
			],

			[
				'label' => 'Adj. Stock Good',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$val = '';
					if (isset($datasession[$model->id_inbound_detail]['adjsgood[]'])){
						$val = $datasession[$model->id_inbound_detail]['adjsgood[]'];
					}
					$disabled = false;
					if ($model->sn_type == 1){ // SN
						$disabled = true;
					}
					$out = Html::textInput('adjsgood[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'adjsgood', 'disabled' => $disabled]);
					return $out;
				},
				'visible' => $this->context->action->id == 'viewreport',
			],
			[
				'label' => 'Adj. Stock Not Good',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$val = '';
					if (isset($datasession[$model->id_inbound_detail]['adjsnotgood[]'])){
						$val = $datasession[$model->id_inbound_detail]['adjsnotgood[]'];
					}
					$disabled = false;
					if ($model->sn_type == 1){ // SN
						$disabled = true;
					}
					$out = Html::textInput('adjsnotgood[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'adjsnotgood', 'disabled' => $disabled]);
					return $out;
				},
				'visible' => $this->context->action->id == 'viewreport',
			],
			[
				'label' => 'Adj. Stock Reject',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$val = '';
					if (isset($datasession[$model->id_inbound_detail]['adjsreject[]'])){
						$val = $datasession[$model->id_inbound_detail]['adjsreject[]'];
					}
					$disabled = false;
					if ($model->sn_type == 1){ // SN
						$disabled = true;
					}
					$out = Html::textInput('adjsreject[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'adjsreject', 'disabled' => $disabled]);
					return $out;
				},
				'visible' => $this->context->action->id == 'viewreport',
			],
			[
				'label' => 'Adj. Stock Good Dismantle',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$val = '';
					if (isset($datasession[$model->id_inbound_detail]['adjsgooddismantle[]'])){
						$val = $datasession[$model->id_inbound_detail]['adjsgooddismantle[]'];
					}
					$disabled = false;
					if ($model->sn_type == 1){ // SN
						$disabled = true;
					}
					$out = Html::textInput('adjsgooddismantle[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'adjsgooddismantle', 'disabled' => $disabled]);
					return $out;
				},
				'visible' => $this->context->action->id == 'viewreport',
			],
			[
				'label' => 'Adj. Stock Not Good Dismantle',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$val = '';
					if (isset($datasession[$model->id_inbound_detail]['adjsnotgooddismantle[]'])){
						$val = $datasession[$model->id_inbound_detail]['adjsnotgooddismantle[]'];
					}
					$disabled = false;
					if ($model->sn_type == 1){ // SN
						$disabled = true;
					}
					$out = Html::textInput('adjsnotgooddismantle[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'adjsnotgooddismantle', 'disabled' => $disabled]);
					return $out;
				},
				'visible' => $this->context->action->id == 'viewreport',
			],
			[
				'label' => 'Adj. Stock Barang SN',
				'format' => 'raw',
				'contentOptions' => ['style' => 'width:20%'],
				'value' => function ($model) use ($datasession)
				{
					$dataInboundSN = ArrayHelper::index( InboundWhTransferDetailSn::find()
							->select([new \yii\db\Expression("case when old_serial_number is null then serial_number else old_serial_number end as serial_number"),])
							->andWhere(['id_inbound_wh_detail' => $model->id_inbound_detail])
							->all(), 'serial_number');
					$dataSN = ArrayHelper::map( OutboundWhTransferDetailSn::find()
							->andWhere(['id_outbound_wh_detail' => $model->id_outbound_wh_detail])
							->andWhere(['not in', 'serial_number', $dataInboundSN])
							->all() ,'serial_number', 'serial_number');

					$val = [];
					if (isset($datasession[$model->id_inbound_detail]['adjssn[]'])){
						$val = $datasession[$model->id_inbound_detail]['adjssn[]'];
					}
					$disabled = true;
					if ($model->sn_type == 1){ // SN
						$disabled = false;
					}
					// $out = Html::textInput('adjssn[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'adjssn', 'disabled' => $disabled]);
					// return $out;
					return Select2::widget([
						'name' => 'adjssn[]',
						'value' => $val, // initial value
						// 'value' => ['b'], // initial value
						// 'value' => ['red', 'green'], // initial value
						'data' => $dataSN,
						'options' => [
							'multiple' => true,
							'placeholder' => 'Pilih IM Code',
							'class' => 'form-control input-sm',
							'dataim' => 'adjssn',
							'disabled' => $disabled
						],
						'pluginOptions' => [
							// 'allowClear' => true,
							'tokenSeparators' => [',', ' '],
						],
						'pluginEvents' => [
							'change' => "function(){
								var select = $(this);
								var currentRow = select.closest('tr');
								if ( select.val() ){
									var val = select.val().length;
								}else{
									var val = 0;
								}

								iditem = currentRow.find('td:eq(15)').find('.id_detail').val();
								iditem = iditem.split(';');
								var type = select.attr('name');
								var delta = currentRow.find('td:eq(7)').html();

								deltaadj = delta - val;

								currentRow.find('td:eq(14)').text(deltaadj);

								$.ajax({
									url: '".Url::to([$this->context->id.'/setsessionreport'])."',
									type: 'post',

									data: {id: iditem, val: select.val() , type: type},
									success: function (result){
										console.log(result);
										if (result != 'success'){
											alert(result);
											input.val(0);
										}
									},

								});

								console.log( select.val() );
							}",
						],
					]);
				},
				'visible' => $this->context->action->id == 'viewreport',
			],

			[
				'label' => 'D. Adjust',
				'format' => 'raw',
				'value' => function($model) use ($datasession){
					$val = 0;
					if (isset($datasession[$model->id_inbound_detail]['dadjust'])){
						$val = $datasession[$model->id_inbound_detail]['dadjust'];
					}
					$rem = $model->delta - $val;
					return $rem;
				},
				'visible' => $this->context->action->id == 'viewreport',
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'template'=>'{report}',
                'buttons'=>[
                    'report' => function ($url, $model) {
						return Html::hiddenInput('id_detail[]', $model->id_inbound_detail.';'.$model->id_outbound_wh_detail, ['class' => 'id_detail'])
						.Html::button(Yii::t('app','Report to AMD'), ['id'=>'repButton','class' => 'btn btn-xs btn-warning reportButton', 'sn_type' => $model->sn_type])
						// Html::a('<span class="label label-warning">Report to AMD</span>', '#', [
							// 'title' => Yii::t('app', 'Report to AMD'), 'class' => 'reportButton', 'value'=>Url::to(['instruction-wh-transfer/reporttoamd','id' => $model->id_outbound_wh_detail]), 'header'=> yii::t('app','Detail Instruction Warehouse Transfer')  , 'sn_type' => $model->sn_type
						// ])
						;
                    },
                ],
			],


        ],
    ]); ?>
	<?php Pjax::end(); ?>

	<p>
		<?php if(Yii::$app->controller->action->id == 'viewreportverify' && $status_report == 31 )
            echo Html::button(Yii::t('app','Verify'), ['id'=>'verifyButton','class' => 'btn btn-success']); ?>
		<?php if(Yii::$app->controller->action->id == 'viewreportapprove' && $status_report == 4 )
            echo Html::button(Yii::t('app','Approve'), ['id'=>'approveButton','class' => 'btn btn-success']); ?>
		<?php if(Yii::$app->controller->action->id == 'viewreport' && $status_report == 5 )
            echo Html::button(Yii::t('app','Close'), ['id'=>'closeButton','class' => 'btn btn-default']); ?>


    </p>

</div>
<script>
	$('#closeButton').click( function(){
		$('#modal').modal('hide');
	} );

	$('table').on('blur', '.input-sm', function(){
		var input = $(this);
		var val = input.val();
		var currentRow = input.closest('tr');
		var type = input.attr('name');

		iditem = currentRow.find('td:eq(15)').find('.id_detail').val();
		iditem = iditem.split(';');

		adjsgood = currentRow.find('input[name^=adjsgood]').val() || 0;
		adjsnotgood = currentRow.find('input[name^=adjsnotgood]').val() || 0;
		adjsreject = currentRow.find('input[name^=adjsreject]').val() || 0;
		adjsgooddismantle = currentRow.find('input[name^=adjsgooddismantle]').val() || 0;
		adjsnotgooddismantle = currentRow.find('input[name^=adjsnotgooddismantle]').val() || 0;

		total = parseInt(adjsgood) + parseInt(adjsnotgood) + parseInt(adjsreject) + parseInt(adjsgooddismantle) + parseInt(adjsnotgooddismantle);

		deltaawal = currentRow.find('td:eq(7)').text();

		count = deltaawal - total;

		if (count < 0){
			alert('Adjustment more than Delta.');
			input.val(0);
			$(this).trigger('blur');
			return false;
		}else if (isNaN(count) || isNaN(val)){
			input.val(0);
			$(this).trigger('blur');
			return false;
		}

		var button = currentRow.find('.reportButton');
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

		$.ajax({
			url: '<?= Url::to([$this->context->id.'/setsessionreport']) ?>',
			type: 'post',
			data: {id: iditem, val: val , type: type},

			success: function (result){
				console.log(result);
				if (result != 'success'){
					alert(result);
					input.val(0);
				}
			},
			complete: function() {
				if (input.val() != 0){
					currentRow.find('td:eq(14)').text(count);
				}else{
					adjsgood = currentRow.find('input[name^=adjsgood]').val() || 0;
					adjsnotgood = currentRow.find('input[name^=adjsnotgood]').val() || 0;
					adjsreject = currentRow.find('input[name^=adjsreject]').val() || 0;
					adjsgooddismantle = currentRow.find('input[name^=adjsgooddismantle]').val() || 0;
					adjsnotgooddismantle = currentRow.find('input[name^=adjsnotgooddismantle]').val() || 0;

					total = parseInt(adjsgood) + parseInt(adjsnotgood) + parseInt(adjsreject) + parseInt(adjsgooddismantle) + parseInt(adjsnotgooddismantle);

					count = deltaawal - total;

					currentRow.find('td:eq(14)').text(count);
				}
				button.prop('disabled', false);
				$('#spinRefresh').remove();
			},
		});

		return false;
	});

	// $('.reportButton').click(function () {
	$('#pjaxviewdetail').on('click', '.reportButton', function(){
        var button = $(this);
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

		var currentRow = button.closest('tr');

		var sn_type = button.attr('sn_type');
		data = new FormData();
		data.append('sn_type', sn_type);
		id_detail = currentRow.find('input[name^=id_detail]').val();
		im_code = currentRow.find('td:eq(2)').text();
		data.append('id_detail', id_detail);
		if (sn_type == 1){
			currentRow.find('select')
				.each(function(){
					name = $(this).attr('name');
					val = $(this).val();
					data.append(name, val);
				});

		}else{
			// non SN
			currentRow.find('input[name^=adjs]')
				.each(function(){
					name = $(this).attr('name');
					val = $(this).val();
					data.append(name, val);
				});

		}

		$.ajax({
			url : '<?= Url::to(['/instruction-wh-transfer/reporttoamd', 'id'=>$model->id_outbound_wh]) ?>',
			type : 'post',
			data: data,
			processData: false,
			contentType: false,
			success: function (response) {
				if(response == 'success') {
					setPopupAlert('<?= Yii::$app->params['pesanReporttoAMD'] ?> for IM Code '+ im_code);
				} else {
					alert('error with message: ' + response);
				}
				$.pjax.reload({push: false, container: "#pjaxviewdetail"
					, url: "<?= Url::to(['/instruction-wh-transfer/viewreport', 'id' => $model->id_outbound_wh]) ?>"
					, timeout : false
				});
				// $.pjax.reload({container: '#pjaxviewdetail', timeout: false});
			},
			complete: function () {
				button.prop('disabled', false);
				$('#spinRefresh').remove();
			},
		});

		console.log(sn_type);
    });

	$('#updateButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-wh-transfer/update', 'idOutboundWh'=>$model->id_outbound_wh]) ;?>');
        $('#modalHeader').html('<h3> Update Detail Inbound PO </h3>');
    });

	$('#submitButton').click(function () {
		var resp = confirm("Do you want to revise this item?");


        if (resp == true) {
            console.log('aa');
            console.log(selectedAction);
            var form = $('#gridViewdetail-container');
            data = new FormData();
			form.find('input:hidden, input:text')
				.each(function(){
					name = $(this).attr('name');
					val = $(this).val();
					data.append(name, val);
				});
			if ( $( '#inboundwhtransfer-revision_remark' ).val() == '' ){
				alert('Revision remark can not be blank');
				return false;
			}
            data.append( 'InboundWhTransfer[revision_remark]', $( '#inboundwhtransfer-revision_remark' ).val() );

            url = '<?php echo Url::to(['/inbound-wh-transfer/reporttoic', 'id' => $model->id_outbound_wh]) ;?>';
            console.log(url);
            if (!form.find('.has-error').length) {
				var button = $(this);
				button.prop('disabled', true);
				button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

                $.ajax({
                    url: url,
                    type: 'post',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if(response == 'success') {
                            $('#modal').modal('hide');
                            setPopupAlert(pesan);
                        } else {
                            alert('error with message: ' + response);
                        }
                    },
					complete: function () {
						button.prop('disabled', false);
						$('#spinRefresh').remove();
					},
				});
            };
        } else {
            return false;
        }
    });

	$('#inputButton').click(function () {
		var form = $('#gridViewdetail-container');
		data = new FormData();
		data.append('arrival_date', $('#arrival_date-id').val() );
		form.find('input:hidden, input:text')
			.each(function(){
				name = $(this).attr('name');
				val = $(this).val();
				console.log(name);
				console.log(val);
				data.append(name, val);
			});

		var button = $(this);
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

		$('#errorSummary').addClass('hidden');
		$('#ulerrorSummary li').remove();
		$('tr[data-key').removeClass('info');

		$.ajax({
            url: '<?php echo Url::to([$this->context->id.'/createdetail', 'idOutboundWh' => $model->id_outbound_wh]) ;?>',
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

	$('#approveButton').click(function () {

		var button = $(this);
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

		$.ajax({
            url: '<?php echo Url::to(['/inbound-wh-transfer/approve', 'id' => $model->id_outbound_wh]) ;?>',
            type: 'post',
			async:true,
            success: function (response) {

                if(response == 'success') {
                    $('#modal').modal('hide');
					setPopupAlert('Data has been approved.');

                } else {
                    alert('error with message: ' + response);
                }
            },
            complete: function () {
                button.prop('disabled', false);
                $('#spinRefresh').remove();
            },
        });
    });

	$('#verifyButton').click( function(){
		var button = $(this);
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

		$.ajax({
            url: '<?php echo Url::to(['/inbound-wh-transfer/verify', 'id' => $model->id_outbound_wh]) ;?>',
            type: 'post',
			async:true,
            success: function (response) {

                if(response == 'success') {
                    $('#modal').modal('hide');
					setPopupAlert('Data has been verify.');

                } else {
                    alert('error with message: ' + response);
                }
            },
            complete: function () {
                button.prop('disabled', false);
                $('#spinRefresh').remove();
            },
        });
	} );

	$('.uploadButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-wh-transfer/uploadsn']) ;?>?id='+$(this).attr('value'));
        $('#modalHeader').html('<h3> Upload Serial Number </h3>');
    });

	$('.viewButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-wh-transfer/viewdetailsn']) ;?>?idInboundPoDetail='+$(this).attr('value'));
        $('#modalHeader').html('<h3> Detail Serial Number </h3>');
    });
</script>
