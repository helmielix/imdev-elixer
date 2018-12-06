<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="instruction-wh-transfer-detail-index">

    <p>
        <?= Html::button(Yii::t('app','Add'), ['id'=>'createButton','class' => 'btn btn-success']) ?>
    </p>
	<?php Pjax::begin([
			'id' => 'pjaxindexdetail', 
			'timeout' => false, 
			'enablePushState' => false, 
			'clientOptions' => ['method' => 'POST', 'backdrop' => false],
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
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {delete}',
                'buttons'=>[
                    'delete' => function ($url, $model) {
                        return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-trash"></span>', '#', [
                            'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/deletedetail', 'id' => $model->id]), 'header'=> yii::t('app','GRF Detail')
                        ]);
                    },
					
                    'update' => function ($url, $model) {
                        return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>', '#', [
                            'title' => Yii::t('app', 'update'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/updatedetail', 'idDetail'=> $model->id]), 'header'=> yii::t('app','Update Detail Warehouse Transfers Instruction')
                        ]);
                    },
                ],
            ],
			
			[
				'attribute' => 'id_item_im',
				'value' => 'idMasterItemIm.im_code',
			],
			'req_good',
			'req_not_good',
			'req_reject',
            
        ],
    ]); ?>
	<?php yii\widgets\Pjax::end() ?>
    <p>        
		<?php if(Yii::$app->controller->action->id == 'indexdetail')
			echo Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-success']);  ?>
		<?= Html::button(Yii::t('app','Submit Instruction'), ['id'=>'submitButton','class' => 'btn btn-success']) ?>
    </p>
</div>

<script>
    $('#createButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php 
			$par = null;
			if (basename(Yii::$app->request->pathInfo) == 'view'){
				$par = 'view';
			}
			echo Url::to([$this->context->id.'/createdetail', 'par' => $par]) ;?>');
        $('#modalHeader').html('<h3> Create Detail Instruksi Warehouse Transfer</h3>');
    });
	
    $('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id.'/update','id'=>Yii::$app->session->get('idInstWhTr')]) ;?>');
        $('#modalHeader').html('<h3> Detail Instruksi Warehouse Transfer </h3>');
    });
    
    $('#submitButton').click(function () {
		var button = $(this);
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
		
		$.ajax({
            url: '<?php echo Url::to([$this->context->id.'/submit', 'id' => Yii::$app->session->get('idInstWhTr')]) ;?>',
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
