<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

use kartik\money\MaskMoney;

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

// $this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$arrQtyDetail = '';
?>
<div class="instruction-wh-transfer-detail-index">

            
    <?php Pjax::begin([
            'id' => 'pjaxcreatedetail', 
            'timeout' => false, 
            'enablePushState' => false, 
            'clientOptions' => ['method' => 'GET', 'backdrop' => false, ]
        ]); ?>
    
    <?php 
        $arrQtyDetail = Yii::$app->session->get('countQty');
        // foreach($arrQtyDetail as $key => $value) {
        //     echo $key.'->'.$value[0], '<br>';
        // }
        // $idForm = 'saveForm';
    ?>
	
	<div class="alert hidden" id="errorSummary">Please fix these following error: <ul id="ulerrorSummary"></ul></div>
    <?= GridView::widget([
        'id' => 'gridViewcreatedetail',
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'options' => ['style' => 'overflow-x:scroll'],
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
		'responsive'=>true,
		'floatHeader'=>true,
		'floatOverflowContainer' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],			
            
			[
				'attribute' => 'item_code',
				'format' => 'raw',
			],
            [ 
                'format'=> 'raw',
                'label' => '',
                'value' => function ($model) use ($arrQtyDetail)
                    {
                        return Html::hiddenInput('item_code[]', $model->item_code);
                    },
            ],
            [
			'attribute'=>'item_desc',
            'value' =>'item_desc',
            ],
            [
                'attribute' => 'item_uom_code',
                'label' => 'UOM',
            ],
            // 'item_uom_code',
			[
                'attribute'=>'qty_request',
                'format' => 'raw',
                'label'=>'Qty Request',
                  'headerOptions' => ['style' => 'width:10%'],
                    'value' => function ($model) use ($arrQtyDetail)
                    {
                        $style = ['style'=>'width:100%','id'=>'idqtyreq'];
                       if(Yii::$app->controller->action->id == 'createdetail' && isset($arrQtyDetail[$model->item_code][0])){
                           $model->qty_request = $arrQtyDetail[$model->item_code][0];
                       }else {
                           $model->qty_request = null;
                       }
                        return Html::textInput('qty_request[]', $model->qty_request, ['class' => 'form-control input-sm']);
                    }
            ],
			
			
        ],
    ]); ?>
    <p>
        <?= Html::button('Previous', ['id'=>'prevButton','class' => 'btn btn-success','data-pjax' => false]);  ?>
        <?= Html::button('Submit', ['id'=>'submitedButton','class' => 'btn btn-success','data-pjax' => false]) ?>
    </p>

	<?php yii\widgets\Pjax::end() ?>
</div>

<script>

	<?php 
	$qString = Yii::$app->request->queryString;
	$idGrf = Yii::$app->session->get('idGrf');
    // $idGrf = null;
    if ($qString == ''){
        $goto = '/indexdetail';
    }else{
        $goto = '/view';
	}
	?>
    $(document).on('click', '#prevButton', function(event){
	// $('#prevButton').click(function () {
        // event.stopPropagation();
        // event.stopPropagation();
        // event.preventDefault();
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id.'/indexdetail','id'=>$idGrf]) ;?>');
        $('#modalHeader').html('<h3> Create Inbound PO </h3>');
    });
    
    // $(document).on('click', '#submitedButton', function(event){
    // $('#submitedButton').click(function () {
    $('.instruction-wh-transfer-detail-index').on('mousedown', '#submitedButton', function (e) {
        event.stopImmediatePropagation();
        console.log('klik');
        var form = $('#gridViewcreatedetail-container');
		data = new FormData();
        form.find('input:hidden, input:text')
            .each(function(){
                name = $(this).attr('name');
                val = $(this).val();
                data.append(name, val);
            });
		
		var button = $(this);
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
		
		$('#errorSummary').addClass('hidden');
		$('#ulerrorSummary li').remove();
		$('tr[data-key').removeClass('info');		
		
		$.ajax({
            url: '<?php echo Url::to([$this->context->id.'/createdetail', 'id' => Yii::$app->session->get('idGrf')]) ;?>',
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
			dataType: 'json',
            success: function (response) {
                if(response.status == 'success') {
                    $('#modal').modal('show')
						.find('#modalContent')
						.load('<?php echo Url::to([$this->context->id.$goto, 'id' => $idGrf]) ;?>');
					$('#modalHeader').html('<h3>Detail Barang</h3>');
                } else {
					pesan = response.pesan;
					pesan = pesan.split('\n');
					$('#errorSummary').addClass('alert-danger').removeClass('hidden');
					for(i = 0; i < pesan.length; i++){
						$('#ulerrorSummary').append('<li>'+pesan[i]+'</li>');
					}
					$('tr[data-key='+response.id+']').addClass('info');
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

    // $(document).on("pjax:send", function(e, contents) {
    //   // event.stopPropagation();
    //     // event.preventDefault();
    //     // alert($( '#qty_request' ).val());
    //     console.log('klik');
    //     var form = $('#createForm');
    //     // data = form.data("yiiActiveForm");
    //     // $.each(data.attributes, function() {
    //         // this.status = 3;
    //     // });
    //     // form.yiiActiveForm("validate");
    //     if (!form.find('.has-error').length) {
    //         data = new FormData(form[0]);
            
    //         // var button = $(this);
    //         // button.prop('disabled', true);
    //         // button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

    //         $.ajax({
    //             url: '<?php echo Url::to([$this->context->id.'/setsessiondetail']) ;?>',
    //             type: 'post',
    //             data: data,
    //             cache: false,
    //             processData: false,
    //             contentType: false,
    //             success: function (response) {
    //                 if(response == 'success') {
    //                     //if($( '#financeinvoicedocument-invoice_type' ).val() == 7011){
    //                         // $('#modal2').modal('hide');
    //                     //  var url = $('#pjax li.active a').attr('href');
    //                     //  $.pjax.reload({container:'#pjax', url: url});
    //                     // // }else{
    //                         // $('#modal').modal('show')
    //                         //  .find('#modalContent')
    //                         //  .load('<?php echo Url::to(['/inbound-po/indexdetail']) ;?>');
    //                         // $('#modalHeader').html('<h3> Inbound PO Detail </h3>');
                            
    //                     // }

    //                 } else {
    //                     alert('error with message: ' + response);
    //                 }
    //             },
    //             error: function (xhr, getError) {
    //                 if (typeof getError === "object" && getError !== null) {
    //                     error = $.parseJSON(getError.responseText);
    //                     getError = error.message;
    //                 }
    //                 if (xhr.status != 302) {
    //                     alert("System recieve error with code: "+xhr.status);
    //                 }
    //             },
    //         });
    //     };
    // })
</script>
