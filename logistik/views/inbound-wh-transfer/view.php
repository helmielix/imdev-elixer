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
					'label' => 'Nomor Surat Jalan'
				],
				'instruction_number',
				[
					'attribute' => 'wh_destination',
					'value' => function($model){
						return Warehouse::findOne($model->wh_destination)->nama_warehouse;
					},
					'label' => 'Warehouse Asal'
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
					[
						'attribute' => 'arrival_date',
						'format' => 'raw',
						'value' => function ($model){
								return $model->arrival_date;
							if($model->arrival_date){
							}else{
								return DatePicker::widget([
									'model' => $model,
									'attribute' => 'arrival_date',
									'inline' => false,
									'options' => ['id'=>'arrival_date-id'],
										'clientOptions' => [
											'autoclose' => true,
											'format' => 'yyyy-mm-dd'
										]
								]);
							}
							
						},
					],
				],
			]) ?>

		</div>
	</div>

	<div class="alert hidden" id="errorSummary">Please fix these following error: <ul id="ulerrorSummary"></ul></div>
	<?php
	Pjax::begin(['id' => 'pjaxviewdetail', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']])
	// Pjax::begin()
	?>
	<?= GridView::widget([
        'id' => 'gridViewdetail',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
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
				'value' => function ($model) use ($datasession){
					$val = '';
					if (isset($datasession[$model->id_item_im])){
						$val = $datasession[$model->id_item_im];
					}else{
						$val = $model->qty_detail;
					}
					// return $model->status_listing;
					// return $val;
					// if($model->status_listing==36){
					// 	return $val.Html::hiddenInput('im_code[]', $model->id_item_im.';'.$model->im_code.';'.$model->id_detail.';'.$model->id_outbound_wh_detail, ['class' => 'im_code']);

					// }else{
						$out = $val.Html::hiddenInput('req_qty[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'qty_detail', 'qtydetail' => $model->qty_detail]);
						return $out.Html::hiddenInput('im_code[]', $model->id_item_im.';'.$model->im_code.';'.$model->id_detail.';'.$model->id_outbound_wh_detail, ['class' => 'im_code']);
					// }
				},
			],
			[
				'attribute' => 'delta',
				'value' => function ($model) use ($datasession){
					$val = 0;
					if (isset($datasession[$model->id_item_im])){
						$val = $datasession[$model->id_item_im];
					}else{
						$val = $model->qty_detail;
					}
					return $model->req_qty - $val;
				},
			],
			[
				'attribute' => 'status_listing',
				'value' => function($model){
					$sr = StatusReference::findOne($model->status_listing);
					return $sr->status_listing;
				},
				'filter' => ArrayHelper::map( StatusReference::find()->andWhere(['id' => [31, 36]])->all(),'id','status_listing'  ),
			],

        ],
    ]); ?>
	<?php Pjax::end(); ?>

	<p>
		<?php if(Yii::$app->controller->action->id == 'viewinbound' && $model->revision_remark == '' && $model->status_listing != 1)
            echo Html::button(Yii::t('app','Report to IC'), ['id'=>'reportButton','class' => 'btn btn-warning']); ?>
		<?php if(Yii::$app->controller->action->id == 'viewinbound' && $model->status_listing == '52')
            echo Html::button(Yii::t('app','Input Inbound'), ['id'=>'inputButton','class' => 'btn btn-success']); ?>
        <?php if(Yii::$app->controller->action->id == 'viewinbound' && ($model->status_listing == 31 || $model->status_listing == 50))
            echo Html::button(Yii::t('app','Update'), ['id'=>'updateButton','class' => 'btn btn-primary']); ?>

        <?php if(Yii::$app->controller->action->id == 'view' && $model->status_listing != 6)
            echo Html::button(Yii::t('app','Update'), ['id'=>'updateButton','class' => 'btn btn-primary']); ?>

        <?php if(Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5)
            echo Html::button(Yii::t('app','Approve'), ['id'=>'approveButton','class' => 'btn btn-success']); ?>
        <?php if(Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5)
            echo Html::button(Yii::t('app','Revise'), ['id'=>'reviseButton','class' => 'btn btn-warning']); ?>



    </p>
	<?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'id' => 'submitForm',
        'layout' => 'horizontal',
        'options' => [
            'style' => 'display:none;'
        ],
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-1',
                'offset' => 'col-sm-offset-1',
                'wrapper' => 'col-sm-6',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]);
	$model->revision_remark = '';
	?>

    <br />
    <?= $form->field($model, 'revision_remark')->textarea(['rows' => '5']) ?>
    <?= Html::button(\Yii::t('app','Submit Remark'), ['id'=>'submitButton','class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>

</div>
<script>
	$('table').on('blur', '.input-sm', function(){
		var input = $(this);
		var currentRow = input.closest('tr');

		var val = parseInt( input.val() );

		iditem = currentRow.find('td:eq(6)').find('.im_code').val();
		iditem = iditem.split(';');

		stock = currentRow.find('td:eq(5)').text();

		count = stock - val;
		if (count < 0){
			alert('<?= $model->getAttributeLabel('qty_detail') ?> more than Request Qty.');
			input.val(stock);
			val = stock;
			count = stock - val;
		}else if (isNaN(count)){
			val = 0;
			input.val(val);
			currentRow.find('td:eq(7)').text(stock);
			return false;
		}

		currentRow.find('td:eq(7)').text(count);

		$.post( '<?= Url::to([$this->context->id.'/setsessiondetail']) ?>', {id: iditem[0], val: val });
	});

	$('#reportButton').click(function () {
        selectedAction = 'report';
        pesan = '<?= Yii::$app->params['pesanReporttoIC'] ?>';
        $('#submitForm').show();
    });

	$('#updateButton').click(function () {
		$('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(["/inbound-wh-transfer/update", 'idOutboundWh' => $model->id_outbound_wh]) ;?>');
        $('#modalHeader').html('<h3> Input Inbound Warehouse Transfer </h3>');
        return false;

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

	$('#submitButton').click(function () {
        var resp = confirm("Do you want to report item that not received?");


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
        $.ajax({
            url: '<?php echo Url::to(['/inbound-wh-transfer/approve', 'id' => $model->id_outbound_wh]) ;?>',
            type: 'post',
			async:true,
            success: function (response) {
                $('#modal').modal('hide');
				setPopupAlert('Data has been approved.');
            }
        });
    });

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
