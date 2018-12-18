<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

use common\models\MasterItemIm;
use common\models\InboundPoDetail;
use yii\helpers\ArrayHelper;
use common\models\Reference;

// $this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="inbound-po-detail-index">

   <?php 
   $dataProvider->setTotalCount(count($dataProvider->getModels())) ;
   $dataProvider->setPagination( new \yii\data\Pagination(['totalCount' => count($dataProvider->getModels())]) ) ;
   ?>
    
	<?php Pjax::begin([
            'id' => 'pjaxcreatedetail', 
            'timeout' => false, 
            'enablePushState' => false, 
            'clientOptions' => ['method' => 'GET', 'backdrop' => false, ]
        ]); ?>
	
    <?= GridView::widget([
        'id' => 'gridView',
		'options' => ['style' => 'overflow-x:scroll'],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'orafin_name',
                'contentOptions' => ['style' => 'width:30%'],
            ],
			[
                'attribute' => 'orafin_code',
                // 'value' => 'itemIm.name',
            ],
			
			[
                'attribute' => 'grouping',
                // 'label' => 'Grouping',
                'value' => function($model){
					$modelItem = MasterItemIm::find()->where(['orafin_code'=>$model->orafin_code])->one();
					if($modelItem){
						return $modelItem->referenceGrouping->description;						
					}
				},
                'filter' => Arrayhelper::map(Reference::find()->andWhere(['table_relation' => 'grouping'])->all(), 'id', 'description'),
            ],
			[
                'attribute' => 'qty',
                'label' => 'QTY RR',
            ],
            [
                'attribute' => 'sn_type',
                'label' => 'SN/Non',
                'value' => function($model){
					$modelItem = MasterItemIm::find()->where(['orafin_code'=>$model->orafin_code])->one();
					if($modelItem){
						return $modelItem->referenceSn->description;						
					}
				},
                'filter' => Arrayhelper::map(Reference::find()->andWhere(['table_relation' => 'sn_type'])->all(), 'id', 'description'),
            ],
            [
                'attribute' => 'uom',
                // 'label' => 'Grouping',
                'value' => function($model){
                    $modelItem = MasterItemIm::find()->where(['orafin_code'=>$model->orafin_code])->one();
                    if($modelItem){
                        return $modelItem->referenceUom->description;                      
                    }
                },
                'filter' => Arrayhelper::map(Reference::find()->andWhere(['table_relation' => 'uom'])->all(), 'id', 'description'),
            ],
			[
                'label' => 'Status',
				'format' => 'raw',
				'value' => function($model){
                    if(!MasterItemIm::find()->where(['orafin_code'=>$model->orafin_code])->exists() )
                    {
                        return "<span class='label label-danger' >Not Registered</span>";
                    }
                    else
                    {
                        $modelInbound = InboundPoDetail::find()->select(['SUM(qty) as qty','qty_rr'])->where(['and',['id_inbound_po'=>$model->id_inbound],['orafin_code'=>$model->orafin_code]])->groupBy(['qty_rr'])->one();
                        if($modelInbound){
                            if($modelInbound->qty == $modelInbound->qty_rr){
                                return "<span class='label label-success'  >Closed</span>";
                            }  else{ 
                                return "<span class='label label-primary'>Open</span>";
                            }   
                        }else{ 
                                return "<span class='label label-primary'>Open</span>";
                            }
                    }                    
				}
            ],
			[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{create}',
                'buttons'=>[
                    'create' => function ($url, $model) {
							if(!MasterItemIm::find()->where(['orafin_code'=>$model->orafin_code])->exists() ){
								return "";
							}else{
								if(InboundPoDetail::find()->where(['and',['id_inbound_po'=>$model->id_inbound],['orafin_code'=>$model->orafin_code]])->exists()){
									return Html::a('<span style="margin:0px 2px;" class="label label-success">Choose</span>', '#update', [
										'title' => Yii::t('app', 'create'), 'class' => 'updatesButton','idInboundPo'=>$model->id_inbound,'orafinCode'=>$model->orafin_code, 'rrNumber'=>$model->rr_number,'qtyRr'=>$model->qty, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
									]);
								}else{
									return Html::a('<span style="margin:0px 2px;" class="label label-success">Choose</span>', '#', [
										'title' => Yii::t('app', 'create'), 'class' => 'createsButton', 'value'=>$model->orafin_code, 'value2'=>$model->rr_number,'value3'=>$model->qty, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
									]);
								}
							}	
							
                    },
                ],
            ],
        ],
    ]); ?>
    <?php yii\widgets\Pjax::end() ?>
	
    <p>
        <?= Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-success']) ?>
        <?= Html::button(Yii::t('app','Submit'), ['id'=>'submitButton','class' => 'btn btn-success']) ?>
    </p>
	
</div>

<script>  
        $('.createsButton').click(function (event) {
		// $(document).on('click' , '.createsButton', function(event){
            event.stopImmediatePropagation();    
            // event.preventDefault();    
            // $('#modal').modal('hide');
			// console.log($(this).attr('value'));
			// alert($(this).attr('orafincode'));
			
			$('#modal').modal('show')
                .find('#modalContent')
                .load('<?php echo Url::to(['/inbound-po/createdetail']) ;?>?orafinCode='+$(this).attr('value')+'&rrNumber='+$(this).attr('value2')+'&qtyRr='+$(this).attr('value3'));
            $('#modalHeader').html('<h3> Create Detail Inbound PO </h3>');

        });
		
		function showcreate(orafin, rr){
			$('#modal').modal('show')
                .find('#modalContent')
                .load('<?php echo Url::to(['/inbound-po/createdetail']) ;?>?orafinCode='+orafin+'&rrNumber='+rr);
            $('#modalHeader').html('<h3> Create Detail Inbound PO </h3>');
		}
        
        $('.updatesButton').click(function (event) {
            event.stopImmediatePropagation();  
			
			// console.log($(this).attr('orafincode'));
			// alert($(this).attr('orafincode'));
			
			// return false;
            // $('#modal').modal('hide');
            $('#modal').modal('show')
                .find('#modalContent')
                .load('<?php echo Url::to(['/inbound-po/updatedetail']) ;?>?idInboundPo='+$(this).attr('idInboundPo')+'&orafinCode='+$(this).attr('orafinCode')+'&rrNumber='+$(this).attr('rrNumber')+'&qtyRr='+$(this).attr('qtyRr'));
            $('#modalHeader').html('<h3> Update Detail Inbound PO </h3>');
            // event.stopPropagation();
        });
    
	
    $('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['inbound-po/update','idInbouncPo'=>Yii::$app->session->get('idInbouncPo')]) ;?>');
        $('#modalHeader').html('<h3> Create Inbound PO </h3>');
    });
    $('#uploadButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-po/uploaddetail']) ;?>');
        $('#modalHeader').html('<h3> Upload Material GRF Vendor </h3>');
    });

    $('#submitButton').click(function () {
        var resp = confirm("Do you want to submit this item?");
        
        if(resp == true){
            $.ajax({
                url: '<?php echo Url::to(['/inbound-po/submit', 'id' => $model->id]) ;?>',
                type: 'post',
                success: function (response) {
                    $('#modal').modal('hide');
                }
            });
        }else {
            return false;
        }
    });

    $('.viewButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
        $('#modalHeader').html('<h3> '+ $(this).attr('header') +'</h3>');
    });

</script>
