<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
// use kartik\detail\DetailView;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\OutboundGrf */

$this->title = $model->id_instruction_grf;
$this->params['breadcrumbs'][] = ['label' => 'Outbound Grf', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outbound-grf-view">

	<div class="row">
		<h1 class='text-center'>SURAT JALAN</h1>
		<h4 class='text-center'>No : <?= $model->no_sj ?></h4>
		<br>
		<div class="col-sm-12">
			<?= DetailView::widget([
				'model' => $model,
				'options' => ['class' => 'small table table-striped table-bordered detail-view'],
				'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
				'attributes' => [
					
					 [
                        'attribute' => 'grf_number',
                        'value' => $model->grf_number,
                        // 'visible' => is_string($model->no_sj),
                    ],
                    [
                        'attribute' => 'requestor',
                        // 'value' => $model->idInstructionGrf->idGrf->requestorName->description,
                        // 'visible' => is_string($model->no_sj),
                    ],
                    // [
                    //     'attribute' => 'id_division',
                    //      'value' => $model->idInstructionGrf->idGrf->idDivision->nama,
                    //     // 'visible' => is_string($model->no_sj),
                    // ],
                    'pic',
                    'incoming_date',
					
					[
						'label' => 'Forwarder',
						'value' => $model->forwarder0->description,
					],
					'plate_number',
					'driver',
					'print_time',
					[
						'attribute' => 'handover_time',
						'format' => 'raw',
						'value' => function($model){
							return '................';
							
							if ( $this->context->action->id == 'viewprintsj' ){
								return TimePicker::widget([
									'name' => 'handover_time',
									'size' => 'sm',
									'options' => [
										'id' => 'handover_time',
									],
									'pluginOptions' => [
										'minuteStep' => 1,
										'showSeconds' => true,
										'showMeridian' => false
									]
								]);
							}else{
								return $model->handover_time;
							}
						},
					],
				],
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
	
	<?= $this->render('indexgrfdetail', [
		'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>
	
	<?php if($this->context->action->id != 'view'){ ?>
	<p> 
        <?php if((Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 25))
            echo Html::button(Yii::t('app','Revise'), ['id'=>'reviseButton','class' => 'btn btn-warning']); ?>
        <?php if(Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 25)
            echo Html::button(Yii::t('app','Approve'), ['id'=>'approveButton','class' => 'btn btn-success']); ?>
        
		
    </p>
	<?php } ?>	

	<div id="revision" style="display:none">
		<?= Html::textArea('revision_remark', '', ['id' => 'revision_remark', 'class' => 'form-control']) ?>
		<?= Html::button(\Yii::t('app','Submit Remark'), ['id'=>'submitremarkButton','class' => 'btn btn-primary']) ?>	
	</div>
</div>

<script>
$('#reviseButton').click(function(){
	selectedAction = 'reviseverify';
    $('#revision').show();
});

$('#submitremarkButton').click(function(){
	if (selectedAction == 'reviseverify' || selectedAction == 'reviseapprove') {
		var resp = confirm("Do you want to revise this item?");
	}
	
	if (resp == false){
		return false;
	}
	
	if (selectedAction == 'reviseverify') url = '<?php echo Url::to([$this->context->id.'/reviseoutbound', 'id' => $model->id_instruction_grf]) ;?>';
	
	var button = $(this);
	button.prop('disabled', true);
	button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
	
	data = new FormData();
    data.append( 'OutboundGrf[revision_remark]', $( '#revision_remark' ).val() );
	
	$.ajax({
		url: url,
		type: 'post',
		data: data,
		processData: false,
		contentType: false,
		success: function (response) {
			if(response == 'success') {
				setPopupAlert('<?= Yii::$app->params['pesanNeedRevise'] ?>');
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

$('#approveButton').click(function(){
	var button = $(this);
	button.prop('disabled', true);
	button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
	
	$.ajax({
		url: '<?php echo Url::to([$this->context->id.'/approve', 'id' => Yii::$app->session->get('idInstructionGrf')]) ;?>',
		type: 'post',
		processData: false,
		contentType: false,
		success: function (response) {
			if(response == 'success') {
				setPopupAlert('<?= Yii::$app->params['pesanApproved'] ?>');
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
		
		data.append( 'OutboundGrf[forwarder]', $( '#outboundgrf-forwarder' ).val() );
		data.append( 'OutboundGrf[plate_number]', $( '#outboundgrf-plate_number' ).val() );
		data.append( 'OutboundGrf[driver]', $( '#outboundgrf-driver' ).val() );
		
		$.ajax({
		url: '<?php echo Url::to([$this->context->id.'/submit', 'id' => Yii::$app->session->get('idInstructionGrf')]) ;?>',
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
$('#submitSjButton').click(function () {
		var button = $(this);
		// var myForm = document.getElementById('createForm');
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
		// $('#modal').modal('hide').delay(1500);
        data = new FormData();
		data.append( 'OutboundGrf[plate_number]', $( '#outboundgrf-plate_number' ).val() );
		data.append( 'OutboundGrf[forwarder]', $( '#outboundgrf-forwarder' ).val() );
		data.append( 'OutboundGrf[driver]', $( '#outboundgrf-driver' ).val() );
		$.ajax({
            url: '<?php echo Url::to([$this->context->id.'/submitsj', 'id' => $model->id_instruction_grf]) ;?>',
            type: 'post',
            data: data,
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
    $('.viewButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
        $('#modalHeader').html('<h3> '+ $(this).attr('header') +'</h3>');
    });
</script>