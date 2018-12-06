<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\OutboundRepairTransfer */

$this->title = $model->id_instruction_repair;
$this->params['breadcrumbs'][] = ['label' => 'Outbound Wh Transfers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outbound-wh-transfer-view">

	<div class="row">
		<div class="col-sm-6">
			<?= DetailView::widget([
				'model' => $model,
				'options' => ['class' => 'small table table-striped table-bordered detail-view'],
				'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
				'attributes' => [
					'no_sj',
					[
						'label' => 'Nomor Instruksi',
						'value' => 'idInstructionRepair.instruction_number',
					],
					[
						'label' => 'Target Pengiriman',
						'value' => 'idInstructionRepair.target_pengiriman:date',
					],
					
					
					// 'idInstructionRepair.wh_origin',
					// 'idInstructionRepair.wh_destination',
					// 'idInstructionRepair.grf_number',
				],
			]) ?>
		</div>
		<div class="col-sm-6">
			<?= $this->render('_form', [
				'model' => $model,
			]) ?>
		</div>
		<div class="col-sm-12">
			<?php if(Yii::$app->controller->action->id == 'view' && $model->status_listing != 6)
				//echo Html::button(Yii::t('app','Update'), ['id'=>'updateButton','class' => 'btn btn-primary']); ?>
			<?php if(Yii::$app->controller->action->id == 'view' && ($model->status_listing == 1 || $model->status_listing == 6 || $model->status_listing == 7))
				//echo Html::button(Yii::t('app','Delete'), ['id'=>'deleteButton','class' => 'btn btn-danger']); ?>
		</div>
	</div>

	<hr>
	
	<?= $this->render('indexdetail_sn', [
		'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>
	
	<?php if($this->context->action->id != 'view'){ ?>
	<p> 
        <?php if(Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5)
            echo Html::button(Yii::t('app','Approve'), ['id'=>'approveButton','class' => 'btn btn-success']); ?>
        <?php if((Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5))
            echo Html::button(Yii::t('app','Revise'), ['id'=>'reviseButton','class' => 'btn btn-warning']); ?>
        <?php if((Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5))
            echo Html::button(Yii::t('app','Reject'), ['id'=>'rejectButton','class' => 'btn btn-danger']); ?>
    </p>
	<?php } ?>	

</div>

<script>
$('#submitButton').click(function () {
	var button = $(this);
	button.prop('disabled', true);
	button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
	
	// proses send form
	var form = $('#createForm');
   	data = form.data("yiiActiveForm");
   	$.each(data.attributes, function() {
   		this.status = 3;
   	});
   	form.yiiActiveForm("validate");
   	if (!form.find('.has-error').length) {
		data = new FormData();
		
		data.append( 'OutboundRepairTransfer[forwarder]', $( '#outboundwhtransfer-forwarder' ).val() );
		data.append( 'OutboundRepairTransfer[plate_number]', $( '#outboundwhtransfer-plate_number' ).val() );
		data.append( 'OutboundRepairTransfer[driver]', $( '#outboundwhtransfer-driver' ).val() );
		
		$.ajax({
		url: '<?php echo Url::to([$this->context->id.'/submit', 'id' => Yii::$app->session->get('idInstWhTr')]) ;?>',
		type: 'post',
		processData: false,
		contentType: false,
		success: function (response) {
			if(response == 'success') {
				$('#modal').modal('hide');
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
	};
	
});
</script>