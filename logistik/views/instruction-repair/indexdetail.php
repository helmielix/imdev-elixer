<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs(
// "$(document).on('ready pjax:success', function() {
		// // $('.modalButton').click(function(e){
		   // // e.preventDefault(); //for prevent default behavior of <a> tag.
		   // // var tagname = $(this)[0].tagName;
		   // // $('#editModalId').modal('show').find('.modalContent').load($(this).attr('href'));
		// // });
		// console.log('ready pjax:success indexdetail');
		// $.pjax.reload({container:'#pjaxindexdetail',timeout: false});
	// });
	"
	// $(document).on('ready pjax:end', function(event) {
	  // $(event.target).initializeMyPlugin()
	// })
");
?>
<div id="fragmentpjax" class="hidden">
hellooo world
</div>
<div class="instruction-wh-transfer-detail-index">

	<?php if($this->context->action->id == 'view' || $this->context->action->id == 'indexdetail' || $this->context->action->id == 'deletedetail'){ ?>
    <p>
        <?= Html::button(Yii::t('app','Add'), ['id'=>'createButton','class' => 'btn btn-success']) ?>
    </p>
	<?php } ?>
	<?php Pjax::begin([
			'id' => 'pjaxindexdetail',
			'timeout' => false, 
			'enablePushState' => false,			
			'clientOptions' => ['method' => 'POST', 'backdrop' => false, 
			"container" => "#pjaxindexdetail"
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
            [
                'attribute' => 'name',
                'value' => 'idMasterItemIm.name',
            ],
            [
                'attribute' => 'brand',
                'value' => 'idMasterItemIm.brand',
            ],
            [
                'attribute' => 'type',
                'value' => 'idMasterItemIm.type',
            ],
            [
                'attribute' => 'warna',
                'value' => 'idMasterItemIm.warna',
            ],
            [
                'attribute' => 'sn_type',
                'value' => 'idMasterItemIm.sn_type',
            ],
            [
                'attribute' => 's_good',
                'value' => 'idMasterItemIm.s_good',
            ],
            // [
            //     'attribute' => 's_not_good',
            //     'value' => 'idMasterItemIm.s_not_good',
            // ],
            [
                'attribute' => 's_reject',
                'value' => 'idMasterItemIm.s_reject',
            ],

            'req_reject',
            'rem_reject',
            
        ],
    ]); ?>
	<?php yii\widgets\Pjax::end() ?>
	<?php if($this->context->action->id == 'view' || $this->context->action->id == 'indexdetail'){ ?>
    <p>        
		<?php if(Yii::$app->controller->action->id == 'indexdetail')
			echo Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-primary']);  ?>
		<?= Html::button(Yii::t('app','Submit Instruction'), ['id'=>'submitButton','class' => 'btn btn-success']) ?>		
    </p>
	<?php } ?>
</div>

<script>
	// $(document).on('ready pjax:end', function(event) {
	  // $(event.target).initializeMyPlugin()
	// })
	$(document).on("pjax:send", function(e, contents) {
	   var $contentBeforePut = $(contents);

	   if(1==1) {
		   console.log('success replace pjaxindexdetail '+$contentBeforePut);
		   // here I want to prevent put html content, I tried with:
		   return false; 
	   }
	})
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
            .load('<?php echo Url::to([$this->context->id.'/update','id'=>Yii::$app->session->get('idInstRep')]) ;?>');
        $('#modalHeader').html('<h3> Detail Instruksi Warehouse Transfer </h3>');
    });
    
    $('#submitButton').click(function () {
		var button = $(this);
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
		
		$.ajax({
            url: '<?php echo Url::to([$this->context->id.'/submit', 'id' => Yii::$app->session->get('idInstRep')]) ;?>',
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
