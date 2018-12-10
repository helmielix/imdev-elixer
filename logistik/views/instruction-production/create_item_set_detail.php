<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

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
<div class="instruction-wh-transfer-detail-index">

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
		// 'options' => ['style' => 'overflow-x:scroll'],
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
		// 'responsive'=>true,
		'floatHeader'=>true,
		'floatOverflowContainer' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],			
            
			[
				'attribute' => 'im_code',
				'format' => 'raw',
				'value' => function ($model){
					return $model->im_code . Html::hiddenInput('im_code[]', $model->id.';'.$model->im_code, ['class' => 'im_code']);
				},
			],
			[
				'attribute' => 'name',
				'value' => 'name',
			],
			// 'name',
			[
				'attribute' => 'brand',
				'value' => 'referenceBrand.description',
			],
			[
				'attribute' => 'type',
				'value' => 'referenceType.description',
			],
			[
				'attribute' => 'warna',
				'value' => 'referenceWarna.description',
			],
			
			[
				'attribute' => 'sn_type',
				'value' => 'referenceSn.description',
				'filter' => ArrayHelper::map(Reference::find()->andWhere(['table_relation' => 'sn_type'])->all(), 'id_grouping', 'description'),
			],
			[
				'attribute' => 's_good',
				'contentOptions' => ['class' => 'bg-warning'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],
			[
				'attribute' => 's_good_dismantle',
				'contentOptions' => ['class' => 'bg-warning'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],
			[
				'attribute' => 's_good_rec',
				'contentOptions' => ['class' => 'bg-warning'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],
			
			
			[
				'label' => 'Req. Good',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$val = '';
					if (isset($datasession[$model->id]['rgood'])){
						$val = $datasession[$model->id]['rgood'];
					}
					$out 	= Html::textInput('rgood[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'rgood']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-success'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],
			
			[
				'label' => 'Req. Good Dismantle',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$val = '';
					if (isset($datasession[$model->id]['rgooddismantle'])){
						$val = $datasession[$model->id]['rgooddismantle'];
					}
					$out 	= Html::textInput('rgooddismantle[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'rgooddismantle']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-info'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],

			[
				'label' => 'Req. Good Recond',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$val = '';
					if (isset($datasession[$model->id]['rgoodrec'])){
						$val = $datasession[$model->id]['rgoodrec'];
					}
					$out 	= Html::textInput('rgoodrec[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'rgoodrec']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-danger'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],
			
			// [
			// 	'label' => 'Rem. Good',
			// 	'format' => 'raw',
			// 	'value' => function($model) use ($datasession){
			// 		$val = 0;
			// 		// if(isset($datasession[$model->id]['update'])){
			// 			// $val = 0;
			// 		// }else 
			// 			if (isset($datasession[$model->id]['rgood'])){
			// 			$val = $datasession[$model->id]['rgood'];
			// 		}
			// 		$rem = $model->req_good - $val;
			// 		return $rem;
			// 	},
			// 	'contentOptions' => ['class' => 'bg-success'],
			// 	'headerOptions' => ['class' => 'kartik-sheet-style'],
			// 	'mergeHeader' => true,
			// 	'vAlign' => 'middle',
			// ],
			
			// [
			// 	'label' => 'Rem. Good Dismantle',
			// 	'format' => 'raw',
			// 	'value' => function($model) use ($datasession){
			// 		$val = 0;
			// 		if (isset($datasession[$model->id]['rgooddismantle'])){
			// 			$val = $datasession[$model->id]['rgooddismantle'];
			// 		}
			// 		$rem = $model->req_good_dismantle - $val;
			// 		return $rem;
			// 	},
			// 	'contentOptions' => ['class' => 'bg-dismantle'],
			// 	'headerOptions' => ['class' => 'kartik-sheet-style'],
			// 	'mergeHeader' => true,
			// 	'vAlign' => 'middle',
			// ],
			
			
			
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
	$('table').on('blur', '.input-sm', function(){
		var input = $(this);
		var currentRow = input.closest("tr"); 
		
		
		data_im = input.attr('dataim');
		var val = input.val();
		switch(data_im){
			default:
				col = 6;
				scol = 16;
				data_im = 'rgood';
			break;
			case 'rnotgood':
				col = 7;
				scol = 17;
			break;
			case 'rreject':
				col = 8;
				scol = 18;
			break;
			case 'rgooddismantle':
				col = 9;
				scol = 19;
			break;
			case 'rnotgooddismantle':
				col = 10;
				scol = 20;
			break;
		}
		iditem = currentRow.find('td:eq(1)').find('.im_code').val();
		iditem = iditem.split(';');		
		
		// update current stok from server
		data = {id: iditem[0]};		
		
		$.ajax({
            url: '<?= Url::to([$this->context->id.'/currentstock']) ?>',
            type: 'post',
            data: data,
			dataType: 'json',
            success: function (result) {
                currentRow.find('td:eq(6)').html(result.req_good);
				currentRow.find('td:eq(7)').html(result.req_dis_good);
				currentRow.find('td:eq(8)').html(result.s_reject);
				currentRow.find('td:eq(9)').html(result.req_good_dismantle);
				currentRow.find('td:eq(10)').html(result.req_dis_good_dismantle);
            },
            complete: function () {
                stock = currentRow.find('td:eq('+col+')').text();
				
				count = stock - val;
				if (count < 0){
					alert('Stock is not enough. revert to maximal stock.');
					input.val(stock);
					val = stock;
					count = stock - val;
				}else if ( isNaN(count) ){
					val = 0;
					input.val(val);
					currentRow.find('td:eq('+scol+')').text(stock);
					return false;
				}
				currentRow.find('td:eq('+scol+')').text(count);
				
				$.post( '<?= Url::to([$this->context->id.'/setsessiondetail']) ?>', {id: iditem[0], val: val, type: data_im });
            },
        });
		
		
	});

	<?php 
	$qString = Yii::$app->request->queryString;
	$id = null;
	
	// if ($qString == 'par=indexdetail'){
	// 	$goto = '/indexdetail';
	// }else{
		$goto = '/update-item-set';
		$id = Yii::$app->session->get('idInstProdDetail');
	// }
	?>
	$('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id.$goto,'idDetail'=>$id]) ;?>');
        $('#modalHeader').html('<h3> Create Inbound PO </h3>');
    });
    
    // $('#submitButton').click(function () {
    $('.instruction-wh-transfer-detail-index').on('mousedown', '#submitButton', function (e) {
		e.preventDefault();
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
            url: '<?php echo Url::to([$this->context->id.'/createdetail', 'id' => Yii::$app->session->get('idInstWhTr')]) ;?>',
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
					$('#modalHeader').html('<h3>Detail Instruksi Warehouse Transfer</h3>');
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
