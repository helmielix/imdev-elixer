<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\OutboundWhTransfer */

$this->title = $model->id_instruction_wh;
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
					'idInstructionWh.instruction_number',
					'idInstructionWh.whDestination.nama_warehouse',
					// 'forwarder0.description',
					[
						'label' => 'Forwarder',
						'value' => function($model){
							if( is_numeric($model->forwarder) ){
								return $model->forwarder0->description;
							}else{
								return '-';
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
					'plate_number',
					'driver',
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
	
	<?= $this->render('indexdetail_sn_outbound', [
		'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>
	
	<?php if($this->context->action->id != 'view'){ ?>
	<p> 
        <?php if(Yii::$app->controller->action->id == 'viewoutbound' )
            echo Html::button(Yii::t('app','Create'), ['id'=>'createButton','class' => 'btn btn-success']); ?>
        <?php if((Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5))
            echo Html::button(Yii::t('app','Revise'), ['id'=>'reviseButton','class' => 'btn btn-warning']); ?>
        <?php if((Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5))
            echo Html::button(Yii::t('app','Reject'), ['id'=>'rejectButton','class' => 'btn btn-danger']); ?>
    </p>
	<?php } ?>	

</div>
<script>
	$('#returnButton').click(function () {
        $.ajax({
            url: '<?php echo Url::to(['/inbound-wh-transfer/returntoic', 'id' => $model->id_instruction_wh]) ;?>',
            type: 'post',
            success: function (response) {
                $('#modal').modal('hide');
               // setPopupAlert('<?= Yii::$app->params['pesanApproved'] ?>');
            }
        });
    });
	$('#createButton').click(function () {
		var button = $(this);
		button.prop('disabled', true);
		button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
		
        $.ajax({
            url: '<?php echo Url::to([$this->context->id.'/create', 'idOutboundWh' => $model->id_instruction_wh]) ;?>',
            type: 'post',
            success: function (response) {
				if (response == 'success'){
					$('#modal').modal('show')
						.find('#modalContent')
						.load('<?php echo Url::to([$this->context->id.'/viewinbound', 'id' => $model->id_instruction_wh]) ;?>');
					$('#modalHeader').html('<h3> Input Inbound Warehouse Transfer </h3>');
				}else {
                    alert('error with message: ' + response);
                }
                
               // setPopupAlert('<?= Yii::$app->params['pesanApproved'] ?>');
            },
			complete: function () {
				button.prop('disabled', false);
				$('#spinRefresh').remove();
			},
        });
    });
</script>