<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs(
"

", \yii\web\View::POS_END);
?>
<div class="instruction-wh-transfer-detail-index">
    
	<?php Pjax::begin([
			'id' => 'pjaxindexdetail', 
			'timeout' => false, 
			'enablePushState' => false, 
			'clientOptions' => ['method' => 'POST'
			// , 'backdrop' => false
			],
		]); ?>
    <?= GridView::widget([
        'id' => 'gridViewindexdetail',
        'dataProvider' => $dataProvider,
		'floatHeader'=>true,
		'floatOverflowContainer' => true,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'id_item_im',
				'value' => 'idMasterItemIm.im_code',
			],
			'req_good',
			'req_not_good',
			'req_reject',
			'req_good_dismantle',
			'req_not_good_dismantle',
			[
				'attribute' => 'sn_type',
				'value' => 'idMasterItemIm.referenceSn.description',
			],
			[
                'attribute' => 'status_listing',
                'format' => 'raw',
                'value' => function ($dataProvider) {
					if($dataProvider->status_listing == 999){
						return "<span class='label' style='background-color:{$dataProvider->statusReference->status_color}' >Not Yet Uploaded</span>";
					}else{
						return "<span class='label' style='background-color:{$dataProvider->statusReference->status_color}' >{$dataProvider->statusReference->status_listing}</span>";
					}
                },
				'visible' => $this->context->action->id == 'create',
            ],
			
            
        ],
    ]); ?>
	<?php yii\widgets\Pjax::end() ?>
   
</div>

<script>   
	
    $('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id.'/update','id'=>Yii::$app->session->get('idInstWhTr')]) ;?>');
        $('#modalHeader').html('<h3> Detail Instruksi Warehouse Transfer </h3>');
    });
    
    $('#createButton').click(function () {
		var button = $(this);
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin"></i>');
		
		// $('#modal').modal('hide').delay(1500);
		
		$.ajax({
            url: '<?php echo Url::to([$this->context->id.'/create', 'id' => $model->id_instruction_wh]) ;?>',
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
    });
    $('.viewButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
        $('#modalHeader').html('<h3> '+ $(this).attr('header') +'</h3>');
    });

</script>
