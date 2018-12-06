<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\OutboundWhTransfer */

$this->title = 'Create Outbound Wh Transfer';
$this->params['breadcrumbs'][] = ['label' => 'Outbound Wh Transfers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="outbound-wh-transfer-create">

	<div class="row">
		<div class="col-sm-6">
			<?= DetailView::widget([
				'model' => $model,
				'options' => ['class' => 'small table table-striped table-bordered detail-view'],
				'attributes' => [
					'idInstructionGrf.idGrf.grf_number',
					'idInstructionGrf.idGrf.wo_number',
					'idInstructionGrf.idGrf.requestor',
					'idInstructionGrf.idGrf.id_division',
					'idInstructionGrf.idGrf.pic',
					'incoming_date',
					
				],
			]) ?>
		</div>
		<div class="col-sm-6">
			<?= DetailView::widget([
				'model' => $model,
				'options' => ['class' => 'small table table-striped table-bordered detail-view'],
				'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
				'attributes' => [
					[	'label' => 'Inputed By Ic',
						'attribute' => 'created_by',
						// 'value'=> '',
					],
					[	'label' => 'Approve By Ic',
						'attribute' => 'created_by',
						// 'value'=> '',
					],
					// ['label' => 'Approve By Ic',
					// ],
				],
			]) ?>
		</div>
		<div class="col-sm-6">
			<?= DetailView::widget([
				'model' => $model,
				'options' => ['class' => 'small table table-striped table-bordered detail-view'],
				'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
				'attributes' => [
					// 'idInstructionWh.grf_number',
				],
			]) ?>
		</div>
		<div class="col-sm-12">
			<?php if(Yii::$app->controller->action->id == 'view' && $model->status_listing != 6)
				echo Html::button(Yii::t('app','Update'), ['id'=>'updateButton','class' => 'btn btn-primary']); ?>
			<?php if(Yii::$app->controller->action->id == 'view' && ($model->status_listing == 1 || $model->status_listing == 6 || $model->status_listing == 7))
				echo Html::button(Yii::t('app','Delete'), ['id'=>'deleteButton','class' => 'btn btn-danger']); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-offset-7">
			<label>Mac Address
				<?= Html::checkBox('macAddressCheckbox', '', ['id' => 'checkboxMacaddr']) ?>
			</label>
			<?= Html::a(Yii::t('app','Download Template'), [$this->context->id.'/downloadfile', 'id'=>'template'], ['id'=>'templateButton','class' => 'btn btn-primary btn-sm', 'data-method' => 'post']) ?>
			<?= Html::a(Yii::t('app','Print Instruction'), [$this->context->id.'/downloadfile', 'id'=>'instruction'], ['id'=>'instructionButton','class' => 'btn btn-primary btn-sm', 'data-method' => 'post']) ?>
		</div>
	</div>
	<hr>
	
	<?= $this->render('indexgrfdetail', [
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
$('#checkboxMacaddr').click(function(){
	var url = '<?= Url::to([$this->context->id.'/downloadfile']) ?>';
	
	if ( $('#checkboxMacaddr').is(':checked') ){
		url = url + '?id=templatemac';
	}else{
		url = url + '?id=template';
	}
	
	$('#templateButton').attr('href', url);
});
// $('#templateButton').click(function(){
	// var button = $(this);
	// button.prop('disabled', true);
	// button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
	
	// var url = '<?= Url::to([$this->context->id.'/downloadfile']) ?>';
	
	// if ( $('#checkboxMacaddr').is(':checked') ){
		// url = url + '?id=templatemac';
	// }else{
		// url = url + '?id=template';
	// }
	
	// return false;
	
// });

$('#submitButton').click(function () {
	var button = $(this);
	button.prop('disabled', true);
	button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
	
	$.ajax({
		url: '<?php echo Url::to([$this->context->id.'/submitsn', 'id' => $model->id_instruction_grf]) ;?>',
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
});
</script>