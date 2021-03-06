<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\MkmMasterItem;

// $this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
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
<div class="grf-detail-index">

	<?php if(($this->context->action->id == 'view' && $model->status_listing != 6) || $this->context->action->id == 'indexdetail'  || $this->context->action->id == 'deletedetail' ){ ?>
    <p>
        <?php if(Yii::$app->controller->action->id == 'indexdetail'|| $this->context->action->id == 'deletedetail')
        echo Html::button(Yii::t('app','Add'), ['id'=>'createsButton','class' => 'btn btn-success']) ?>
    </p>
	<?php } ?>
	<?php Pjax::begin([
			'id' => 'pjaxindexdetail',
			'timeout' => false, 
			'enablePushState' => false,			
			'clientOptions' => ['method' => 'GET', 'backdrop' => false, 
			// "container" => "#pjaxindexdetail"
			],
		]); ?>
    <?= GridView::widget([
        'id' => 'gridViewindexdetail',
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'floatHeader'=>true,
		'floatOverflowContainer' => true,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {delete}',
                'buttons'=>[
                    'view' => function ($url, $model) {
                        return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>', '#', [
                            'title' => Yii::t('app', 'update'), 'class' => 'viewButton', 'value'=>Url::to(['grf/updatedetail', 'idDetail' => $model->id, 'par'=>'viewothers']), 'header'=> yii::t('app','Update Detail Barang')
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-trash"></span>', '#', [
                            'title' => Yii::t('app', 'delete'), 'class' => 'viewButton', 'value'=>Url::to(['grf/deletedetail', 'idDetail' => $model->id]), 'header'=> yii::t('app','Material GRF Vendor')
                        ]);
                    },
                ],
            ],
			
			[
				'attribute' => 'orafin_code',
				'value' => 'orafin_code',
			],
			// 'idOrafinCode.item_desc',
			[
                'header' => 'Nama Barang',
                'attribute' => 'item_desc',
                'value'=> 'idItemCode.item_desc'
            ],
            [
				'header' => 'UOM',
				'attribute' => 'item_uom_code',
                'value'=> 'idItemCode.item_uom_code'
			],
            [
                'header' => 'Qty Request',
                'attribute' => 'qty_request',
            ],

            
        ],
    ]); ?>
	<?php yii\widgets\Pjax::end() ?>
	<?php if(($this->context->action->id == 'view' && $model->status_listing != 6) || $this->context->action->id == 'indexdetail' || Yii::$app->controller->action->id == 'deletedetail'){ ?>
    <p>        
		<?php if(Yii::$app->controller->action->id == 'indexdetail'  || Yii::$app->controller->action->id == 'deletedetail')
			echo Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-primary']);  ?>
        <?php if(Yii::$app->controller->action->id == 'indexdetail'  || Yii::$app->controller->action->id == 'deletedetail')
		echo Html::button(Yii::t('app','Submit Instruction'), ['id'=>'submitButton','class' => 'btn btn-success']) ?>		
    </p>
	<?php } ?>
</div>

<script>
	// $(document).on('ready pjax:end', function(event) {
	  // $(event.target).initializeMyPlugin()
	// })
	// $(document).on("pjax:send", function(e, contents) {
	//    var $contentBeforePut = $(contents);

	//    if(1==1) {
	// 	   console.log('success replace pjaxindexdetail '+$contentBeforePut);
	// 	   // here I want to prevent put html content, I tried with:
	// 	   return false; 
	//    }
	// })
    $('#createsButton').click(function (event) {
        event.stopImmediatePropagation();
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php 
            $par = null;
            if (basename(Yii::$app->request->pathInfo) == 'view'){
                $par = 'view';
            }
            echo Url::to([$this->context->id.'/createdetail']) ;?>');
        $('#modalHeader').html('<h3> Create Detail Grf</h3>');
    });
    
	
    $('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id.'/update','id'=>Yii::$app->session->get('idGrf')]) ;?>');
        $('#modalHeader').html('<h3> Update GRF Others </h3>');
    });
    
    $('#submitButton').click(function () {
		var button = $(this);
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
		
		$.ajax({
            url: '<?php echo Url::to([$this->context->id.'/submit', 'id' => Yii::$app->session->get('idGrf')]) ;?>',
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
