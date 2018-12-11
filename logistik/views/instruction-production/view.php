<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\InstructionWhTransfer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instruction Wh Transfers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instruction-wh-transfer-view">    

	<div class="row">
		<div class="col-sm-6">
			<?= DetailView::widget([
				'model' => $model,
				'options' => ['class' => 'small table table-striped table-bordered detail-view'],
				'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
				'attributes' => [
					'instruction_number',
					'target_produksi:date',
					[
						'attribute' => 'id_warehouse',
						'value' => function($model){
							return $model->idWarehouse->nama_warehouse;
						}
					],
					// 'id_warehouse',
					[
		                'attribute'=>'file_attachment',
		                'format'=>'raw',
						'value' => function($searchModel){
							if ($this->context->action->id == 'exportpdf' || $this->context->action->id == 'exportinstruction'){
								return basename($searchModel->file_attachment);
							}else{
								return Html::a(basename($searchModel->file_attachment), ['downloadfile','id' => $searchModel->id, 'relation' => 'instruction'], $options = ['target'=>'_blank', 'data' => [
				                        'method' => 'post',
				                        'params' => [
				                            'data' => 'file_attachment',
				                        ]
				                    ]]);
							}
						},
		            ],
				],
			]) ?>
		</div>
		<div class="col-sm-6">
			<?= DetailView::widget([
				'model' => $model,
				'options' => ['class' => 'small table table-striped table-bordered detail-view'],
				'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
				'attributes' => [
					'created_by',
					// 'file_attachment',
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
	
	<hr>
	
	<h3>Detail Warehouse Transfers Instruction</h3>
	<?= $this->render('indexdetail', [
		'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>
	
	<?php if($this->context->action->id != 'view'){ ?>
	<p> 
        <?php if((Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5))
            echo Html::button(Yii::t('app','Reject'), ['id'=>'rejectButton','class' => 'btn btn-danger']); ?>
        <?php if((Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5) || 
				(Yii::$app->controller->action->id == 'viewinstruction' && $model->status_listing == 5))
            echo Html::button(Yii::t('app','Revise'), ['id'=>'reviseButton','class' => 'btn btn-warning']); ?>
        <?php if(Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5)
            echo Html::button(Yii::t('app','Approve'), ['id'=>'approveButton','class' => 'btn btn-success']); ?>
		<?php if((Yii::$app->controller->action->id == 'viewinstruction' && $model->status_listing == 5))
            echo Html::button(Yii::t('app','Create'), ['id'=>'createoutButton','class' => 'btn btn-success']); ?>
		
    </p>
	<?php } ?>	
	
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
    ]); ?>
		<div class="form-group field-instructionwhtransfer-revision_remark">
			<label class="control-label col-sm-2" for="instructionwhtransfer-revision_remark">Revision Remark</label>
			<div class="col-sm-6">
			<?= Html::textArea('InstructionWhTransfer[revision_remark]','',['rows' => '5', 'class' => 'form-control', 'id' => 'instruction-wh-transfer-revision_remark']) ?>
			</div>
		</div>
        <br />
        <?= Html::button(\Yii::t('app','Submit Remark'), ['id'=>'revisionButton','class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>

</div>

<script>
$('#revisionButton').click(function(){
	var resp = confirm("Do you want to revise this item?");
	
	if (resp == 0){
		return false;
	}
	
	var form = $('#submitForm');
	data = form.data("yiiActiveForm");
	$.each(data.attributes, function() {
		this.status = 3;
	});
	form.yiiActiveForm("validate");
	
	data = new FormData();
	data.append( 'InstructionWhTransfer[revision_remark]', $( '#instruction-wh-transfer-revision_remark' ).val() );
	var button = $(this);
	button.prop('disabled', true);
	button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
	
	$.ajax({
		url: '<?= Url::to([$this->context->id.'/reviseinstruction', 'id' => $model->id]) ?>',
		type: 'post',
		data: data,
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

$('#reviseButton').click(function(){
	$('#submitForm').show();
});

$('#createoutButton').click(function() {
	$('#modal').modal('show')
		.find('#modalContent')
		.load('<?php echo Url::to([$this->context->id.'/create', 'id' => $model->id, 'act' => 'view']) ;?>');
	$('#modalHeader').html('<h3> Create Tag SN</h3>');
});

$('#updateButton').click(function () {
	$('#modal').modal('show')
		.find('#modalContent')
		.load('<?php echo Url::to([$this->context->id.'/update', 'id' => $model->id]) ;?>');
	$('#modalHeader').html('<h3> Update Warehouse Transfer Instruction</h3>');
});

$('#deleteButton').click(function () {
	var resp = confirm("Do you want to delete this item???");
	if (resp == true) {
		$.ajax({
			 url: '<?php echo Url::to([$this->context->id.'/delete', 'id' => $model->id]) ;?>',
			type: 'post',
			success: function (response) {
				$('#modal').modal('hide');
				setPopupAlert('<?= Yii::$app->params['pesanDelete'] ?>');
			}
		});
	}else {
		return false;
	}
});

$('#approveButton').click(function () {
	var button = $(this);
	button.prop('disabled', true);
	button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
	
	$.ajax({
		url: '<?php echo Url::to([$this->context->id.'/approve', 'id' => $model->id]) ;?>',
		type: 'post',
		success: function (response) {
			$('#modal').modal('hide');
			setPopupAlert('<?= Yii::$app->params['pesanApproved'] ?>');
		},
		complete: function () {
			button.prop('disabled', false);
			$('#spinRefresh').remove();
		},
	});
});
</script>
