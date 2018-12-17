<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\DetailView;

use kartik\money\MaskMoney;

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Reference;

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);

$datasession = Yii::$app->session->get('detailinstruction');

$this->registerCss('
.bg-dismantle{
	background-color: #FDFEFD;
}
');
?>
<div class="instruction-grf-detail-index">
	 <div class="row">
        <div>
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'small table table-striped table-bordered detail-view'],
                'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                'attributes' => [
                    [
        
		                'attribute' => 'orafin_code',
		                'value' => $model->idGrf->idGrfDetail->orafin_code,
                    ],

                    [
        
		                'attribute' => 'name',
		                // 'value' => $model->idGrf->idGrfDetail->idOrafinCode->name,
		                'value' => $model->idGrf->idGrfDetail->idOrafinCode->name,
                    ],
                    
                    [
        
		                'attribute' => 'qty_request',
		                'value' => $model->idGrf->idGrfDetail->qty_request,
                    ],

                    [
		                'header' => 'SN/Non',
		                'attribute' => 'sn_type',
		                // 'value'=> $model->idGrf->idGrfDetail->idOrafinCode->referenceSn->description,
		                'value'=> $model->idGrf->idGrfDetail->im_code,
		            ],
                ],
            ]) ?>
        </div>
    </div>

    <p>
        <?php Html::button(Yii::t('app','Add'), ['id'=>'createButton','class' => 'btn btn-success']) ?>
    </p>	
	<div class="alert hidden" id="errorSummary">Please fix these following error: <ul id="ulerrorSummary"></ul></div>
	<?php Pjax::begin([
			'id' => 'pjaxcreatedetail', 
			'timeout' => false, 
			'enablePushState' => false, 
			'clientOptions' => ['method' => 'GET', 'backdrop' => false, ]
		]); ?>
    <?= GridView::widget([
        'id' => 'gridViewcreatedetail',
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'options' => ['style' => 'overflow-x:scroll'],
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
		// 'responsive'=>true,
		'floatHeader'=>true,
		'floatOverflowContainer' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],			
            
			[
				'attribute' => 'orafin_code',
				// 'format' => 'raw',
				// 'value' => function ($modelitem){
				// 	return $modelitem->im_code . Html::hiddenInput('im_code[]', $modelitem->id.';'.$modelitem->im_code, ['class' => 'im_code']);
				// },
			],
			// [
			// 	'attribute' => 'name',
			// 	'value' => 'idGrf.idGrfDetail.idOrafinCode.name',
			// ],
			'name',
			[
				'attribute' => 'brand',
				'value' => 'brand',
			],
			// 'type',
			'warna',
			[
			'attribute'=>'sn_type',
			'value' => 'sn_type',

			],
			// 'qty_request',
			
			
			[
				'label' => 'Qty. Good',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$val = '';
					if (isset($datasession[$model->id]['qtygood'])){
						$val = $datasession[$model->id]['qtygood'];
					}
					$out 	= Html::textInput('qtygood[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'qtygood']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-success'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],
			[
				'label' => 'Qty. Not Good',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$val = '';
					if (isset($datasession[$model->id]['qtynootgood'])){
						$val = $datasession[$model->id]['qtynootgood'];
					}
					$out = Html::textInput('qtynootgood[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'qtynootgood']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-warning'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],
			[
				'label' => 'qty. Reject',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$val = '';
					if (isset($datasession[$model->id]['qtyreject'])){
						$val = $datasession[$model->id]['qtyreject'];
					}
					$out = Html::textInput('qtyreject[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'qtyreject']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-danger'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],
			[
				'label' => 'Qty. Dismantle Good',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$val = '';
					if (isset($datasession[$model->id]['qtydismantlegood'])){
						$val = $datasession[$model->id]['qtydismantlegood'];
					}
					$out 	= Html::textInput('qtydismantlegood[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'qtydismantlegood']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-dismantle'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],
			[
				'label' => 'Qty. Dismantle Ng',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$val = '';
					if (isset($datasession[$model->id]['qtydismantleng'])){
						$val = $datasession[$model->id]['qtydismantleng'];
					}
					$out = Html::textInput('qtydismantleng[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'qtydismantleng']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-info'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],
			[
				'label' => 'Qty. Good Reconditional',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$val = '';
					if (isset($datasession[$model->id]['qtygoodrec'])){
						$val = $datasession[$model->id]['qtygoodrec'];
					}
					$out = Html::textInput('qtygoodrec[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'qtygoodrec']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-success'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],
	
			
			
        ],
    ]); ?>
	<?php yii\widgets\Pjax::end() ?>
    <p>
        <?= Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-success']);  ?>
		<?= Html::button(Yii::t('app','Submit Item'), ['id'=>'submitButton','class' => 'btn btn-success']) ?>
    </p>	
</div>

<script>
	// $('.input-sm').on('blur', function(){
	// 	var input = $(this);
	// 	var currentRow = input.closest("tr"); 
		
		
	// 	data_im = input.attr('dataim');
	// 	var val = input.val();
	// 	switch(data_im){
	// 		default:
	// 			col = 6;
	// 			scol = 16;
	// 			data_im = 'qtygood';
	// 		break;
	// 		case 'qtynootgood':
	// 			col = 7;
	// 			scol = 17;
	// 		break;
	// 		case 'qtyreject':
	// 			col = 8;
	// 			scol = 18;
	// 		break;
	// 		case 'qtydismantlegood':
	// 			col = 9;
	// 			scol = 19;
	// 		break;
	// 		case 'qtydismantleng':
	// 			col = 10;
	// 			scol = 20;
	// 		break;case 'qtydismantlrec':
	// 			col = 10;
	// 			scol = 20;
	// 		break;
	// 	}
	// 	iditem = currentRow.find('td:eq(1)').find('.im_code').val();
	// 	iditem = iditem.split(';');		
		
	// 	// update current stok from server
	// 	data = {id: iditem[0]};		
		
	// 	$.ajax({
 //            url: '<?= Url::to([$this->context->id.'/currentstock']) ?>',
 //            type: 'post',
 //            data: data,
	// 		dataType: 'json',
 //            success: function (result) {
 //    //             currentRow.find('td:eq(6)').html(result.s_good);
	// 			// currentRow.find('td:eq(7)').html(result.s_not_good);
	// 			// currentRow.find('td:eq(8)').html(result.s_reject);
	// 			// currentRow.find('td:eq(9)').html(result.s_good_dismantle);
	// 			// currentRow.find('td:eq(10)').html(result.s_not_good_dismantle);
 //            },
 //            complete: function () {
 //                stock = currentRow.find('td:eq('+col+')').text();
				
	// 			count = stock - val;
	// 			if (count < 0){
	// 				alert('Stock is not enough. revert to maximal stock.');
	// 				input.val(stock);
	// 				val = stock;
	// 				count = stock - val;
	// 			}
	// 			currentRow.find('td:eq('+scol+')').text(count);
				
	// 			$.post( '<?= Url::to([$this->context->id.'/setsessiondetail']) ?>', {id: iditem[0], val: val, type: data_im });
 //            },
 //        });
		
		
	// });

	<?php 
	$qString = Yii::$app->request->queryString;
	$id = null;
	
	if ($qString == 'par=indexdetail'){
		$goto = '/indexdetail';
	}else{
		$goto = '/view';
		$id = Yii::$app->session->get('idGrf');
	}
	?>
	$('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id.$goto,'id'=>$id]) ;?>');
        $('#modalHeader').html('<h3> Create Instruction Grf </h3>');
    });
    
    $('#submitButton').click(function () {
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
						.load('<?php echo Url::to([$this->context->id.$goto, 'id' => $id]) ;?>');
					$('#modalHeader').html('<h3> Create Detail Instruksi Grf</h3>');
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

</script>
