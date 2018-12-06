<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

use kartik\money\MaskMoney;

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="instruction-wh-transfer-detail-index">

    <p>
        <?php Html::button(Yii::t('app','Add'), ['id'=>'createButton','class' => 'btn btn-success']) ?>
        
       
    </p>
	<?php
		$form = ActiveForm::begin([
           'id' => 'createDetail',
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
		]);
	?>
	<div class="alert hidden" id="errorSummary">Please fix these following error: <ul id="ulerrorSummary"></ul></div>
	<?php Pjax::begin(['id' => 'pjaxcreatedetail', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]); ?>
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
				'attribute' => 'im_code',
				'format' => 'raw',
				'value' => function ($model){
					return $model->im_code . Html::hiddenInput('im_code[]', $model->id.';'.$model->im_code, ['class' => 'im_code']);
				},
			],
			'name',
			'brand',
			// 'type',
			'warna',
			'sn_type',
			// 'stock_qty',
			[
				'attribute' => 's_good',
				'contentOptions' => ['class' => 'bg-success'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],
			[
				'attribute' => 's_not_good',
				'contentOptions' => ['class' => 'bg-warning'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],
			[
				'attribute' => 's_reject',
				'contentOptions' => ['class' => 'bg-danger'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],
			
			[
				'label' => 'Req. Good',
				'format' => 'raw',
				'value' => function ($model)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$out 	= Html::textInput('rgood[]', '', ['class' => 'form-control input-sm']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-success'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],
			[
				'label' => 'Req. Not Good',
				'format' => 'raw',
				'value' => function ($model)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$out = Html::textInput('rnotgood[]', '', ['class' => 'form-control input-sm']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-warning'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],
			[
				'label' => 'Req. Reject',
				'format' => 'raw',
				'value' => function ($model)
				{
					$out = '<div class="col-xs-12">';
					$out .= '</div>';
					$out = Html::textInput('rreject[]', '', ['class' => 'form-control input-sm']);
					return $out;
				},
				'contentOptions' => ['class' => 'bg-danger'],
				'headerOptions' => ['class' => 'kartik-sheet-style'],
				'mergeHeader' => true,
				'vAlign' => 'middle',
			],
			// 'uom',
			// 'sgood',
			// 'sngood',
			// 'sreject',
			// 'rqgood',
			// 'rqngood',
			// 'rqreject',
			// 'remgood',
			// 'remngood',
			// 'remreject',
			
        ],
    ]); ?>
	<?php yii\widgets\Pjax::end() ?>
    <p>
        <?= Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-success']);  ?>
		<?= Html::button(Yii::t('app','Submit Item'), ['id'=>'submitButton','class' => 'btn btn-success']) ?>
    </p>
	<?php ActiveForm::end(); ?>
</div>

<script>

	<?php 
	$qString = Yii::$app->request->queryString;
	$id = null;
	if ($qString == ''){
		$goto = '/indexdetail';
	}else{
		$goto = '/view';
		$id = Yii::$app->session->get('idInstWhTr');
	}
	?>
	$('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id.$goto,'id'=>$id]) ;?>');
        $('#modalHeader').html('<h3> Create Inbound PO </h3>');
    });
    
    $('#submitButton').click(function () {
        var form = $('#createDetail');
		data = new FormData(form[0]);
		data.delete('SearchMasterItemIm[im_code]');
		data.delete('SearchMasterItemIm[name]');
		data.delete('SearchMasterItemIm[brand]');
		data.delete('SearchMasterItemIm[warna]');
		data.delete('SearchMasterItemIm[sn_type]');
		
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
