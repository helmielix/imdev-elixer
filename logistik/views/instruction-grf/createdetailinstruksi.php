<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

use kartik\money\MaskMoney;

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

use common\models\Reference;

use yii\widgets\DetailView;


$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);

$datasession = Yii::$app->session->get('detailinstruction');

$this->registerCss('
.bg-request{
	background-color: #FDFEFD;
}
');

// echo "<!-- ".var_dump($datasession)." -->";
?>
<div class="instruction-wh-transfer-detail-index">
	<div class="row">
        <div>
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'small table table-striped table-bordered detail-view'],
                'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                'attributes' => [
                    [
        
		                'attribute' => 'orafin_code',
		                // 'value' => $model->idGrf->idGrfDetail->orafin_code,
                    ],

                    [
        
		                'attribute' => 'name',
		                // 'value' => $model->idGrf->idGrfDetail->idOrafinCode->name,
		                'value' => $model->idOrafinCode->name,
                    ],
                    
                    [
        
		                'attribute' => 'qty_request',
		                'contentOptions' => ['id' => 'qty_request'],
		                // 'value' => $model->idGrf->idGrfDetail->qty_request,
                    ],

                    [
		                'header' => 'SN/Non',
		                'attribute' => 'sn_type',
		                'value'=> $model->idOrafinCode->referenceSn->description,
		                // 'value'=> $model->idGrf->idGrfDetail->im_code,
		            ],
                ],
            ]) ?>
        </div>
    </div>
    
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
			'name',
			[
				'attribute' => 'brand',
				'value' => 'referenceBrand.description',
				 'filter' => Arrayhelper::map(Reference::find()->andWhere(['table_relation' => 'brand'])->all(), 'id', 'description'),
			],
			// 'type',
			[
				'attribute' => 'warna',
				'value' => 'referenceWarna.description',
				 'filter' => Arrayhelper::map(Reference::find()->andWhere(['table_relation' => 'warna'])->all(), 'id', 'description'),
			],
			
			[
				'attribute' => 'sn_type',
				'value' => 'referenceSn.description',
				'filter' => ArrayHelper::map(Reference::find()->andWhere(['table_relation' => 'sn_type'])->all(), 'id_grouping', 'description'),
			],
			// 'stock_qty',
			[
				'attribute' => 's_good',
				'contentOptions' => ['class' => 'bg-success'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
				'value' => function ($model) use ($datasession){
					// digunakan saat update detail, untuk menambah stock dengan request dalam tampilan awal
					// untuk perhitungan remaining
					if(isset($datasession[$model->id]['update'])){
						$model->s_good += $datasession[$model->id]['rgood'];
					}
					return $model->s_good;
				},
			],
			[
				'attribute' => 's_not_good',				
				'format' => 'raw',
				'contentOptions' => ['class' => 'bg-success'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
				'value' => function ($model) use ($datasession){
					// digunakan saat update detail, untuk menambah stock dengan request dalam tampilan awal
					// untuk perhitungan remaining
					if(isset($datasession[$model->id]['update'])){
						$model->s_not_good += $datasession[$model->id]['rnotgood'];
					}
					return $model->s_not_good;
				},
			],
			[
				'attribute' => 's_reject',
				'contentOptions' => ['class' => 'bg-success'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
				'value' => function ($model) use ($datasession){
					// digunakan saat update detail, untuk menambah stock dengan request dalam tampilan awal
					// untuk perhitungan remaining
					if(isset($datasession[$model->id]['update'])){
						$model->s_reject += $datasession[$model->id]['rreject'];
					}
					return $model->s_reject;
				},
			],
			[
				'attribute' => 's_dismantle',
				'contentOptions' => ['class' => 'bg-success'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
				'value' => function ($model) use ($datasession){
					// digunakan saat update detail, untuk menambah stock dengan request dalam tampilan awal
					// untuk perhitungan remaining
					if(isset($datasession[$model->id]['update'])){
						$model->s_dismantle += $datasession[$model->id]['rdismantle'];
					}
					return $model->s_dismantle;
				},
			],
			[
				'attribute' => 's_revocation',
				'contentOptions' => ['class' => 'bg-success'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
				'value' => function ($model) use ($datasession){
					// digunakan saat update detail, untuk menambah stock dengan request dalam tampilan awal
					// untuk perhitungan remaining
					if(isset($datasession[$model->id]['update'])){
						$model->s_revocation += $datasession[$model->id]['rrevocation'];
					}
					return $model->s_revocation;
				},
			],
			[
				'attribute' => 's_good_rec',
				'contentOptions' => ['class' => 'bg-success'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
				'value' => function ($model) use ($datasession){
					// digunakan saat update detail, untuk menambah stock dengan request dalam tampilan awal
					// untuk perhitungan remaining
					if(isset($datasession[$model->id]['update'])){
						$model->s_good_rec += $datasession[$model->id]['rgoodrec'];
					}
					return $model->s_good_rec;
				},
			],
			[
				'attribute' => 's_good_for_recond',
				'contentOptions' => ['class' => 'bg-success'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
				'value' => function ($model) use ($datasession){
					// digunakan saat update detail, untuk menambah stock dengan request dalam tampilan awal
					// untuk perhitungan remaining
					if(isset($datasession[$model->id]['update'])){
						$model->s_good_for_recond += $datasession[$model->id]['rgoodforrecond'];
					}
					return $model->s_good_for_recond;
				},
			],
			
			[
				'label' => 'Req. Good',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$val = '';
					// untuk menyimpan data request jika ada sorting/filtering pada tampilan
					if (isset($datasession[$model->id]['rgood'])){
						$val = $datasession[$model->id]['rgood'];
					}
					$out 	= Html::textInput('rgood[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'rgood']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-request'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
			],
			[
				'label' => 'Req. Not Good',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$val = '';
					// untuk menyimpan data request jika ada sorting/filtering pada tampilan
					if (isset($datasession[$model->id]['rnotgood'])){
						$val = $datasession[$model->id]['rnotgood'];
					}
					$out = Html::textInput('rnotgood[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'rnotgood']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-request'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
			],
			[
				'label' => 'Req. Reject',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$val = '';
					// untuk menyimpan data request jika ada sorting/filtering pada tampilan
					if (isset($datasession[$model->id]['rreject'])){
						$val = $datasession[$model->id]['rreject'];
					}
					$out = Html::textInput('rreject[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'rreject']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-request'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
			],
			[
				'label' => 'Req. Dismantle',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$val = '';
					// untuk menyimpan data request jika ada sorting/filtering pada tampilan
					if (isset($datasession[$model->id]['rdismantle'])){
						$val = $datasession[$model->id]['rdismantle'];
					}
					$out 	= Html::textInput('rdismantle[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'rdismantle']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-request'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
			],
			[
				'label' => 'Req. Revocation',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$val = '';
					// untuk menyimpan data request jika ada sorting/filtering pada tampilan
					if (isset($datasession[$model->id]['rrevocation'])){
						$val = $datasession[$model->id]['rrevocation'];
					}
					$out = Html::textInput('rrevocation[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'rrevocation']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-request'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
			],
			[
				'label' => 'Req. Good recondition',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$val = '';
					// untuk menyimpan data request jika ada sorting/filtering pada tampilan
					if (isset($datasession[$model->id]['rgoodrec'])){
						$val = $datasession[$model->id]['rgoodrec'];
					}
					$out = Html::textInput('rgoodrec[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'rgoodrec']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-request'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
			],
			[
				'label' => 'Req. Good for recondition',
				'format' => 'raw',
				'value' => function ($model) use ($datasession)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$val = '';
					// untuk menyimpan data request jika ada sorting/filtering pada tampilan
					if (isset($datasession[$model->id]['rgoodforrecond'])){
						$val = $datasession[$model->id]['rgoodforrecond'];
					}
					$out = Html::textInput('rgoodforrecond[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'rgoodforrecond']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-request'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
			],
			[
				'label' => 'Rem. Good',
				'format' => 'raw',
				'value' => function($model) use ($datasession){
					$val = 0;
					// if(isset($datasession[$model->id]['update'])){
						// $val = 0;
					// }else 
					if (isset($datasession[$model->id]['rgood'])){
						$val = $datasession[$model->id]['rgood'];
					}
					$rem = $model->s_good - $val;
					return $rem;
				},
				'contentOptions' => ['class' => 'bg-info'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
			],
			[
				'label' => 'Rem. Not Good',
				'format' => 'raw',
				'value' => function($model) use ($datasession){
					$val = 0;
					if (isset($datasession[$model->id]['rnotgood'])){
						$val = $datasession[$model->id]['rnotgood'];
					}
					$rem = $model->s_not_good - $val;
					return $rem;					
				},
				'contentOptions' => ['class' => 'bg-info'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
			],
			[
				'label' => 'Rem. Reject',
				'format' => 'raw',
				'value' => function($model) use ($datasession){
					$val = 0;
					if (isset($datasession[$model->id]['rreject'])){
						$val = $datasession[$model->id]['rreject'];
					}
					$rem = $model->s_reject - $val;
					return $rem;
				},
				'contentOptions' => ['class' => 'bg-info'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
			],
			[
				'label' => 'Rem. Dismantle',
				'format' => 'raw',
				'value' => function($model) use ($datasession){
					$val = 0;
					if (isset($datasession[$model->id]['rdismantle'])){
						$val = $datasession[$model->id]['rdismantle'];
					}
					$rem = $model->s_dismantle - $val;
					return $rem;
				},
				'contentOptions' => ['class' => 'bg-info'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
			],
			[
				'label' => 'Rem. Revocation',
				'format' => 'raw',
				'value' => function($model) use ($datasession){
					$val = 0;
					if (isset($datasession[$model->id]['rrevocation'])){
						$val = $datasession[$model->id]['rrevocation'];
					}
					$rem = $model->s_revocation - $val;
					return $rem;
				},
				'contentOptions' => ['class' => 'bg-info'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
			],
			[
				'label' => 'Rem. Good recondition',
				'format' => 'raw',
				'value' => function($model) use ($datasession){
					$val = 0;
					if (isset($datasession[$model->id]['rgoodrec'])){
						$val = $datasession[$model->id]['rgoodrec'];
					}
					$rem = $model->s_good_rec - $val;
					return $rem;
				},
				'contentOptions' => ['class' => 'bg-info'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
			],
			[
				'label' => 'Rem. Good for recondition',
				'format' => 'raw',
				'value' => function($model) use ($datasession){
					$val = 0;
					if (isset($datasession[$model->id]['rgoodforrecond'])){
						$val = $datasession[$model->id]['rgoodforrecond'];
					}
					$rem = $model->s_good_for_recond - $val;
					return $rem;
				},
				'contentOptions' => ['class' => 'bg-info'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
				'enableSorting' => false,
			],
			
			
        ],
    ]); ?>
	<?php yii\widgets\Pjax::end() ?>
    <p>
        <?= Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-success']);  ?>
        <?= Html::button(Yii::t('app','Revise to User'), ['id'=>'revisegrfButton','class' => 'btn btn-warning']);  ?>
		<?= Html::button(Yii::t('app','Submit Item'), ['id'=>'submitButton','class' => 'btn btn-success']) ?>
    </p>	
</div>

<script>
	// $('.input-sm').on('blur', function(){
	$('#pjaxcreatedetail').on('blur', '.input-sm', function(){
		var input = $(this);
		var currentRow = input.closest("tr"); 
		
		
		data_im = input.attr('dataim');
		var val = input.val();
		
		switch(data_im){
			default:
				col = 6;
				scol = 20;
				data_im = 'rgood';
			break;
			case 'rnotgood':
				col = 7;
				scol = 21;
			break;
			case 'rreject':
				col = 8;
				scol = 22;
			break;
			case 'rdismantle':
				col = 9;
				scol = 23;
			break;
			case 'rrevocation':
				col = 10;
				scol = 24;
			break;
			case 'rgoodrec':
				col = 11;
				scol = 25;
			break;
			case 'rgoodforrecond':
				col = 12;
				scol = 26;
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
                currentRow.find('td:eq(6)').html(result.s_good);
				currentRow.find('td:eq(7)').html(result.s_not_good);
				currentRow.find('td:eq(8)').html(result.s_reject);
				currentRow.find('td:eq(9)').html(result.s_dismantle);
				currentRow.find('td:eq(10)').html(result.s_revocation);
				currentRow.find('td:eq(11)').html(result.s_good_rec);
				currentRow.find('td:eq(12)').html(result.s_good_for_recond);

				console.log(result.s_good_for_recond+' total request');
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
	
	if ($qString == 'par=indexdetail'){
		$goto = '/indexdetail';
	}else{
		$goto = '/indexdetail';
		$id = Yii::$app->session->get('idGrf');
	}
	?>
	$('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id.$goto,'id'=>$id]) ;?>');
        $('#modalHeader').html('<h3> Create Inbound PO </h3>');
    });

    $('#revisegrfButton').click(function () {
    	var button = $(this);
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
        $.ajax({
            url: '<?= Url::to([$this->context->id.'/revisegrf', 'id' => Yii::$app->session->get('idGrf') ]) ?>',
            type: 'post',            			
            success: function (result) {
                $('#modal').modal('hide');
                alert('Date has been revise to user.');
            },
            complete: function () {
                button.prop('disabled', false);
                $('#spinRefresh').remove();
            },
        });
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
            url: '<?php echo Url::to([$this->context->id.'/createdetail', 'orafinCode' => $model->orafin_code, 'id' => Yii::$app->session->get('idGrf')]) ;?>',
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
