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
$datasession = Yii::$app->session->get('detailinstruction');
?>
<div id="fragmentpjax" class="hidden">
hellooo world
</div>
<div class="instruction-wh-transfer-detail-index">

	<?php if($this->context->action->id == 'indexdetail'){ ?>
    <p>
        <?= Html::button(Yii::t('app','Add Set Item'), ['id'=>'createSetButton','class' => 'btn btn-success']) ?>
        <?= Html::button(Yii::t('app','Add Supporting Item'), ['id'=>'createSupportButton','class' => 'btn btn-success']) ?>
    </p>
	<?php } ?>
	<?php Pjax::begin([
			'id' => 'pjaxindexdetail',
			'timeout' => false, 
			'enablePushState' => false,			
			'clientOptions' => ['method' => 'GET', 'backdrop' => false, 
			"container" => "#pjaxindexdetail"
			],
		]); ?>
    <?= GridView::widget([
        'id' => 'gridViewcreatedetail',
        'dataProvider' => $dataProvider,
		'floatHeader'=>true,
		'floatOverflowContainer' => true,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {delete} {view}',
                'buttons'=>[
                    'view' => function($url, $model){
                        if(Yii::$app->controller->action->id == 'indexdetail'){
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#view?id='.$model->id.'&header=Detail_Material_GRF_Vendor_IKO', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['instruction-production/viewdetail','id' => $model->id]), 'header'=> yii::t('app','Detail Material GRF Vendor IKO')
                            ]);
                        }else{
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#view?id='.$model->id.'&header=Detail_Material_GRF_Vendor_IKO', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['instruction-production/viewdetail','id' => $model->id,'par'=>'viewdetail']), 'header'=> yii::t('app','Detail Material GRF Vendor IKO')
                            ]);
                         
                        }
                     },   
                    'delete' => function ($url, $model) {
                        if(Yii::$app->controller->action->id == 'indexdetail')
                        return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-trash"></span>', '#', [
                            'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/deletedetail', 'id' => $model->id]), 'header'=> yii::t('app','GRF Detail')
                        ]);
                    },
					
                    'update' => function ($url, $model) {
                        if(Yii::$app->controller->action->id == 'indexdetail')
                        return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>', '#', [
                            'title' => Yii::t('app', 'update'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/updatedetail', 'idDetail'=> $model->id]), 'header'=> yii::t('app','Update Detail Warehouse Transfers Instruction')
                        ]);
                    },
                ],
            ],
			// 'target_produksi',
            [
                'attribute' => 'id_item_im',
                'format' => 'raw',
                'value' => function ($model){
                    return $model->idParameterMasterItem->idMasterItemIm->im_code . Html::hiddenInput('im_code[]', $model->id.';'.$model->idParameterMasterItem->idMasterItemIm->im_code, ['class' => 'im_code']);
                },
            ],
            [
                'attribute' => 'id_item_im',
                'label' => 'Target Produksi',
                'value' => 'idParameterMasterItem.idMasterItemIm.name'
            ],

			// [
			// 	'attribute' => 'id_item_im',
   //              'label' => "IM Code",
			// 	'value' => 'idParameterMasterItem.idMasterItemIm.im_code',
			// ],
            'qty',
            [
                'label' => 'Qty. Declare',
                'format' => 'raw',
                'value' => function ($model) use ($datasession)
                {
                    $out = '<div class="col-xs-12">';
                    $out .= '</div>';
                    $val = '';
                    if (isset($datasession[$model->id]['qtydeclare'])){
                        $val = $datasession[$model->id]['qtydeclare'];
                    }
                    $out    = Html::textInput('qtydeclare[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'qtydeclare']);
                    return $out;
                },
                'contentOptions' => ['class' => 'bg-danger'],
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'mergeHeader' => true,
                'vAlign' => 'middle',
            ],
			// 'req_good',
			// 'req_not_good',
			// 'req_reject',
            
        ],
    ]); ?>
	<?php yii\widgets\Pjax::end() ?>
    <p>        
		<?php if(Yii::$app->controller->action->id == 'indexdetail' || Yii::$app->controller->action->id == 'viewdetail-declare'){
			echo Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-primary']); 
        
		echo Html::button(Yii::t('app','Submit Instruction'), ['id'=>'submitButton','class' => 'btn btn-success']); }?>		
    </p>
	
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
    $('#createSetButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php 
			$par = null;
			if (basename(Yii::$app->request->pathInfo) == 'view'){
				$par = 'view';
			}
			echo Url::to([$this->context->id.'/create-item-set', 'par' => $par]) ;?>');
        $('#modalHeader').html('<h3> Create Detail Instruksi Warehouse Transfer</h3>');
    });

    $('#createSupportButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php 
            $par = null;
            if (basename(Yii::$app->request->pathInfo) == 'view'){
                $par = 'view';
            }
            echo Url::to([$this->context->id.'/create-supporting-item', 'par' => $par]) ;?>');
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
            url: '<?php echo Url::to([$this->context->id.'/submit', 'id' => Yii::$app->session->get('idInstProd')]) ;?>',
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
