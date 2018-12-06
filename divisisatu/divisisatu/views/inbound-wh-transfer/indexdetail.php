<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;

use common\models\MasterItemIm;
use common\models\InboundWhTransferDetail;

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$arrQtyDetail = '';
?>
<div class="inbound-po-detail-index">

		<?php //if (Yii::$app->session->get('countQty') != NULL):
            $arrQtyDetail = Yii::$app->session->get('countQty');
            // $idForm = 'saveForm';
            ?>


	<?php $form = ActiveForm::begin([
        'id' => 'createForm',
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

	<?php echo Html::hiddenInput('idOutboundWh', Yii::$app->session->get('idOutboundWh'));
         ?>

	<?php \yii\widgets\Pjax::begin(['id' => 'pjax']); ?>

    <?= GridView::widget([
        'id' => 'gridView',
		'options' => ['style' => 'overflow-x:scroll'],
        'dataProvider' => $dataProvider,
        'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


			[
				'format'=> 'raw',
				'label' => '',
				'value' => function ($model) use ($arrQtyDetail)
					{
						return Html::hiddenInput('orafinCode[]', $model->orafin_code);
					},
			],


			[
                'attribute' => 'item_name',
                'label' => 'Nama Barang',
            ],

			'im_code',


            'brand',
			'req_good',
			[
				'format'=> 'raw',
				'label' => '',
				'value' => function ($model) use ($arrQtyDetail)
					{
						return Html::hiddenInput('req_good[]', $model->req_good);
					},
			],
			[
				'attribute'=>'arrived_good',
				'format' => 'raw',
				'label'=>'QTY Terima',
				  'headerOptions' => ['style' => 'width:10%'],
					'value' => function ($model) use ($arrQtyDetail)
					{
						$style = ['style'=>'width:100%','id'=>'idarrivedgood'];
					   if(isset($arrQtyDetail[$model->im_code][0])){
						   $model->qty = $arrQtyDetail[$model->im_code][0];
					   }else {
						   $model->qty = null;
					   }
						return Html::textInput('qty[]', $model->qty);
					}
			],
			[
				'format'=> 'raw',
				'label' => '',
				'value' => function ($model) use ($arrQtyDetail)
					{
						return Html::hiddenInput('item[]', $model->id_item_im);
					},
			],
        ],
    ]); ?>

	<?php yii\widgets\Pjax::end() ?>
	<div class="row">
		<div class="col-sm-7">
            <?php switch ($this->context->action->id) {
                case 'createdetail':
                    $actionText = 'Create';
                    break;
                case 'updatedetail':
                    $actionText = 'Update';
                    break;
            } ?>
            <?= Html::button($actionText, ['id'=>'createButton','class' => 'btn btn-success']) ?>
            <?= Html::button('Submitting...', ['id'=>'loadingButton','class' => 'btn btn-secondary', 'style'=>'display:none']) ?>
           </div>
	</div>


    <?php ActiveForm::end(); ?>
</div>

<script>
    $('#createButton').click(function () {
		// console.log($( '#inboundwhtransferdetail-qty' ).val());

		var form = $('#createForm');
		data = form.data("yiiActiveForm");
		$.each(data.attributes, function() {
			this.status = 3;
		});
		form.yiiActiveForm("validate");
		if (!form.find('.has-error').length) {
			data = new FormData(form[0]);
			// data.append( 'InboundWhTransferDetail[im_code]', $( '#inboundwhtransferdetail-im_code' ).val() );
			//data.append( 'InboundWhTransferDetail[qty]', $( '#inboundwhtransferdetail-qty' ).val() );

            var button = $(this);
            button.prop('disabled', true);
            button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

			$.ajax({
				url: '<?php echo Url::to(['/inbound-wh-transfer/'.$this->context->action->id]) ;?>',
				type: 'post',
				data: data,
				contentType:false,
				processData:false,
				success: function (response) {
					if(response == 'success') {
						//if($( '#financeinvoicedocument-invoice_type' ).val() == 7011){
							$('#modal').modal('hide');
							// var url = $('#pjax li.active a').attr('href');
							// $.pjax.reload({container:'#pjax', url: url});
						// }else{
							// $('#modal').modal('show')
							 // .find('#modalContent')
							 // .load('<?php echo Url::to(['/inbound-po/index']) ;?>');
							// $('#modalHeader').html('<h3> Inbound WH Trasnfer </h3>');
							// var url = $('#pjax li.active a').attr('href');
							// $.pjax.reload({container:'#pjax', url: url});
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

	$('.updateButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-po/updatedetail']) ;?>?idInboundPo='+$(this).attr('idInboundPo')+'&orafinCode='+$(this).attr('orafinCode')+'&rrNumber='+$(this).attr('rrNumber'));
        $('#modalHeader').html('<h3> Update Detail Inbound PO </h3>');
    });

    $('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['inbound-wh-transfer/update','idOutboundWh'=>Yii::$app->session->get('idOutboundWh')]) ;?>');
        $('#modalHeader').html('<h3> Create Inbound WH </h3>');
    });
    $('#uploadButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-po/uploaddetail']) ;?>');
        $('#modalHeader').html('<h3> Upload Material GRF Vendor </h3>');
    });
    $('#submitButton').click(function () {
        $('#modal').modal('hide');
		var url = $('#pjax li.active a').attr('href');
		$.pjax.reload({container:'#pjax', url: url});
    });
    $('.viewButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
        $('#modalHeader').html('<h3> '+ $(this).attr('header') +'</h3>');
    });

</script>
