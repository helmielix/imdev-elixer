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
use common\models\InboundWhTransferDetailSn;
use common\models\InboundWhTransferDetail;
use common\models\OutboundWhTransferDetailSn;
use common\models\MasterItemIm;


/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */

// $this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inbound Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$datasession = Yii::$app->session->get('detailinbound');

$normalSn = InboundWhTransferDetailSn::find()->select('serial_number')->andWhere(['status_retagsn' => null])->asArray()->all();
$dataSN = ArrayHelper::map( OutboundWhTransferDetailSn::find()->joinWith('idOutboundWhDetail')->andWhere(['id_outbound_wh' => $model->id_inbound_wh])->andWhere(['not in', 'serial_number', $normalSn])->all(), 'serial_number', 'serial_number' );

$dataIM = ArrayHelper::map( MasterItemIm::find()->all(),'id', 'im_code' );

?>
<div class="inbound-wh-transfer-view">	
		
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
		'floatHeader'=>true,
		'floatOverflowContainer' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => 'SN Baru',
				'format' => 'raw',
				'value' => function ($model){
					return $model->serial_number.Html::hiddenInput('new_sn[]', $model->serial_number);
				},
			],
			[
				'label' => 'SN Lama',
				'format' => 'raw',
				'value' => function ($model) use ($dataSN){
					if ( $this->context->action->id == 'viewtagsnapprove' ){
						return $model->old_serial_number;
					}
					
					return Select2::widget([
						'name' => 'old_sn[]',
						'data' => $dataSN,
						'options' => [
							'placeholder' => 'Pilih SN Lama',
						],
						'pluginOptions' => [
							'allowClear' => true
						],
					]);
				},
			],
			[
				'label' => 'IM Code',
				'format' => 'raw',
				'value' => function ($model) use ($dataIM){
					if ( $this->context->action->id == 'viewtagsnapprove' ){
						if ( is_numeric($model->new_id_item_im) ){
							return MasterItemIm::findOne($model->new_id_item_im)->im_code;
						}else{
							return $model->idInboundWhDetail->idItemIm->im_code;
						}
					}
					return Select2::widget([
						'name' => 'im_code[]',
						'data' => $dataIM,
						'options' => [
							'placeholder' => 'Pilih IM Code',
						],
						'pluginOptions' => [
							'allowClear' => true
						],
					]);
				},
			],
            
        ],
    ]); ?>
	<?php yii\widgets\Pjax::end() ?>
	
	<p>
	<?php
	switch ($this->context->action->id){
		case 'retagsn':
			$action = 'Submit';
			$idaction = 'submitButton';
		break;
		case 'viewtagsnapprove':
			$action = 'Approve';
			$idaction = 'approveButton';
		break;
	}
	?>
		<?= Html::button(Yii::t('app',$action), ['id'=>$idaction,'class' => 'btn btn-success']); ?>
		<?= Html::hiddenInput('sn', '', ['id'=>'listsn']); ?>
		
    </p>	
	
</div>
<script>
	$('#approveButton').click(function(){
		var button = $(this);
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
		
		$.ajax({
            url: '<?php echo Url::to([$this->context->id.'/approveretagsn', 'id' => $model->id_inbound_wh]) ;?>',
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
	} );

	$('select[name*=old_sn]').change( function(){
		var selectIni = $(this);
		var form = $('#gridViewindexdetail-container');
		var listsn = $('#listsn');
		console.log(selectIni.val());
		
		listsnval = listsn.val();
		
		if ( listsnval.indexOf(selectIni.val()) > 0 && listsn.val() != '' ){
			selectIni.closest('td').addClass('has-error');
		}else{
			// listsn.val( listsn.val() + ';' + selectIni.val() );
			var data = '';
			form.find('select[name*=old_sn]')
				.each(function(){
					val = $(this).val();
					data = data + ';' + val;
				});
			listsn.val( data );
			
			selectIni.closest('td').removeClass('has-error');
		}
		
	});

	// $('#modal').on('hide.bs.modal', function (e) {
		// e.stopImmediatePropagation();
		// var c = confirm('Are you sure?');
		// if (c == true){
			// $('#submitButton').trigger('click');
		// }else{
			// return false;
		// }
	// });

	$('#submitButton').click(function () {
		var form = $('#gridViewindexdetail-container');
		if (form.find('.has-error').length) {
			return false;
		}
		
		data = new FormData();
		form.find('input:hidden, select')
			.each(function(){
				name = $(this).attr('name');
				val = $(this).val();
				data.append(name, val);
			});
		
		var button = $(this);
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
		
		$.ajax({
            url: '<?php echo Url::to([$this->context->id.'/retagsn', 'id' => $model->id]) ;?>',
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                if(response == 'success') {
                    $('#modal').modal('show')
						.find('#modalContent')
						.load('<?php echo Url::to([$this->context->id.'/viewtagsn', 'id' => $model->id_inbound_wh]) ;?>');
					$('#modalHeader').html('<h3>Create Tag SN</h3>');
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
		
</script>