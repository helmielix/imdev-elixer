<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\widgets\Pjax;
use common\models\Reference;

use common\models\MkmMasterItem;
use common\models\MasterItemIm;
use common\models\OrafinViewMkmPrToPay;

/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */
/* @var $form yii\widgets\ActiveForm */
$arrQtyDetail = '';
?>


<div class="inbound-po-form-detail">

		<?php if (Yii::$app->controller->action->id == 'updatedetail'):
            $arrQtyDetail = Yii::$app->session->get('countQty');
            // $idForm = 'saveForm';
            ?>
            
        <?php endif; ?>
	<?php 
		Pjax::begin(['id' => 'gridpjax', 'timeout' => 5000, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']]) 
		// Pjax::begin()
	?>
    <?php $form = ActiveForm::begin([
		'enableClientValidation' => true,
        'id' => 'createForm',
        'options' => ['data-pjax' => true ],
        'layout' => 'horizontal',
		'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-4',
                'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-6',
                'error' => '',
                'hint' => '',
            ],
        ],
	]); ?>
	
		<?php echo Html::hiddenInput('idInboundPo', Yii::$app->session->get('idInboundPo'));
         ?>
		
		<?= $form->field($modelOrafin, 'orafin_code')->textInput(['disabled'=>true]); ?>
		
		<?= $form->field($modelOrafin, 'orafin_name')->textArea(['disabled'=>true]); ?>
		
		<?= $form->field($modelOrafin, 'qty')->textInput(['disabled'=>true]);?>
		
		<?= $form->field($modelIm->referenceSn, 'description')->textInput(['disabled'=>true])->label('SN / Non SN');?>
		
	

    
	
		<?php function getFilterStatus() {
			if(Yii::$app->controller->action->id == 'index')
				return [
					1 => 'Inputted',
					2 => 'Revised',
					3 => 'Need Revise',
					6 => 'Rejected',
				];
			if(Yii::$app->controller->action->id == 'indexverify')
				return [
					1 => 'Inputted',
					2 => 'Revised',
					4 => 'Verified',
				];
			if(Yii::$app->controller->action->id == 'indexapprove')
				return [
					5 => 'Approved',
					4 => 'Verified'
				];
			if(Yii::$app->controller->action->id == 'indexoverview')
				return [
					1 => 'Inputted',
					2 => 'Revised',
					3 => 'Need Revise',
					5 => 'Approved',
					4 => 'Verified',
					6 => 'Rejected',
				];
			} ; ?>
			
			<?= GridView::widget([
				'dataProvider' => $dataProvider,
				'filterModel' => $searchModel,
				'id' => 'gridViewdetail',
				'columns' => [
					 ['class' => 'kartik\grid\SerialColumn'],
					
					
					[
						'attribute' => 'im_code',
						'label' => 'IM Code'
					],
					[
						'attribute' => 'grouping',
						'value' => function($model){
							return $model->itemIm->referenceGrouping->description;
						},
						'filter' => Arrayhelper::map(Reference::find()->andWhere(['table_relation' => 'grouping'])->all(), 'id', 'description'),
					],
					[
						'attribute' => 'brand',
						'value' => function($model){
							return $model->itemIm->referenceBrand->description;
						},
						'filter' => Arrayhelper::map(Reference::find()->andWhere(['table_relation' => 'brand'])->all(), 'id', 'description'),
					],
					[
						'attribute' => 'warna',
						'label' => 'Color',
						'value' => function($model){
							return $model->itemIm->referenceWarna->description;
						},
						'filter' => Arrayhelper::map(Reference::find()->andWhere(['table_relation' => 'warna'])->all(), 'id', 'description'),
					],
					[
						'attribute' => 'type',
						'value' => function($model){
							return $model->itemIm->referenceType->description;
						},
						'filter' => ArrayHelper::map(Reference::find()->andWhere(['table_relation' => 'item_type'])->all(), 'id', 'description'),
					],
					'qty',
					'qty_good',
					'qty_not_good',
					'qty_reject',
					// [
					// 	'attribute'=>'req_good_qty',
					// 	'format' => 'raw',
					// 	'label'=>'Qty',
					// 	 //  'headerOptions' => ['style' => 'width:10%'],
					// 		// 'value' => function ($model) use ($arrQtyDetail)
					// 		// {
					// 		// 	$style = ['style'=>'width:100%','id'=>'idreqgoodqty'];
								
					// 		// 		if(Yii::$app->controller->action->id == 'updatedetail' && isset($arrQtyDetail[$model->im_code][0])){
					// 		// 		   $model->req_good_qty = $arrQtyDetail[$model->im_code][0];
					// 		// 	   }else {
					// 		// 		   $model->req_good_qty = null;
					// 		// 	   }
									
					// 		// 	if(Yii::$app->controller->action->id != 'viewdetail'){
					// 		// 		return Html::textInput('req_good_qty[]', $model->req_good_qty);
					// 		// 	}else{
					// 		// 		return $model->req_good_qty;
					// 		// 	}
							   
					// 		// }
					// ],
				
				],
			]); ?>
		
		<div class="form-group">
<label class='control-label col-sm-4'> </label>
        <div class='col-sm-6 pull-right'>
            <?php switch ($this->context->action->id) {
                case 'createdetail':
                    $actionText = 'Create';
                    break;
                case 'updatedetail':
                    $actionText = 'Update';
                    break;

            } ?>
            <?php 
            	if($this->context->action->id == 'createdetail' || $this->context->action->id == 'updatedetail'){
            ?> 
	            <?= Html::button($actionText, ['id'=>'createdButton','class' => 'btn btn-success', 'data-pjax' => false]) ?>
	            <?= Html::button('Submitting...', ['id'=>'loadingButton','class' => 'btn btn-secondary', 'style'=>'display:none','data-pjax' => false]) ?>
            <?php }?>
        </div>
</div>
	<p>	
		<?php 
			if($this->context->action->id == 'viewdetail'){
				echo Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-success']);
			}else if($this->context->action->id == 'viewdetailverify'){
				echo Html::button(Yii::t('app','Previous'), ['id'=>'previousVerButton','class' => 'btn btn-success']);
			}else if($this->context->action->id == 'viewdetailapprove'){
				echo Html::button(Yii::t('app','Previous'), ['id'=>'previousAppButton','class' => 'btn btn-success']);
			}
		?>
	</p>
</div>
        


    <?php ActiveForm::end(); ?>
<?php \yii\widgets\Pjax::end(); ?>

<script>
	$('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['inbound-po/view','id'=>$idInboundPo]) ;?>');
        $('#modalHeader').html('<h3> Create Inbound PO </h3>');
    });

    $('#previousVerButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['inbound-po/viewverify','idInbouncPo'=>Yii::$app->session->get('idInbounPo')]) ;?>');
        $('#modalHeader').html('<h3> Create Inbound PO </h3>');
    });

    $('#previousAppButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['inbound-po/viewapprove','idInbouncPo'=>Yii::$app->session->get('idInbounPo')]) ;?>');
        $('#modalHeader').html('<h3> Create Inbound PO </h3>');
    });
	// $('#createButton').click(function () {

	// $(document).on('click', '#createdButton', function(event){
	$('#createdButton').click( function(event){
		event.stopPropagation();
		// event.preventDefault();
		console.log('klik');
		var form = $('#createForm');
		data = form.data("yiiActiveForm");
		$.each(data.attributes, function() {
			this.status = 3;
		});
		form.yiiActiveForm("validate");
		if (!form.find('.has-error').length) {
			data = new FormData(form[0]);
			data.append( 'InboundPoDetail[im_code]', $( '#inboundpodetail-im_code' ).val() );
			data.append( 'InboundPoDetail[qty]', $( '#inboundpodetail-qty' ).val() );
			
            var button = $(this);
            button.prop('disabled', true);
            button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

			$.ajax({
				url: '<?php echo Url::to(['/inbound-po/'.$this->context->action->id,'orafinCode'=>$modelOrafin->orafin_code,'rrNumber'=>$modelOrafin->rr_number, 'maxQty' => $modelOrafin->qty]) ;?>',
				type: 'post',
				data: data,
				cache: false,
				processData: false,
				contentType: false,
				success: function (response) {
					if(response == 'success') {
						//if($( '#financeinvoicedocument-invoice_type' ).val() == 7011){
							// $('#modal2').modal('hide');
						// 	var url = $('#pjax li.active a').attr('href');
						// 	$.pjax.reload({container:'#pjax', url: url});
						// // }else{
							$('#modal').modal('show')
							 .find('#modalContent')
							 .load('<?php echo Url::to(['/inbound-po/indexdetail']) ;?>');
							$('#modalHeader').html('<h3> Inbound PO Detail </h3>');
							
						// }

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
		};

	});

</script>