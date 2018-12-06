<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

use common\models\MasterItemIm;
use common\models\InboundPoDetail;

// $this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="inbound-po-detail-index">

   
	<?php \yii\widgets\Pjax::begin(['id' => 'pjax', 'timeout' => 5000, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]); ?>
	
    <?= GridView::widget([
        'id' => 'gridView',
		'options' => ['style' => 'overflow-x:scroll'],
        'dataProvider' => $dataProvider,
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
                'label' => 'Grouping',
                'value' => function($model){
					$modelItem = MasterItemIm::find()->where(['orafin_code'=>$model->orafin_code])->one();
					if($modelItem){
						return $modelItem->grouping;						
					}
				}
            ],
			[
                'attribute' => 'qty',
                'label' => 'QTY RR',
            ],
            [
                'label' => 'SN/Non',
                'value' => function($model){
					$modelItem = MasterItemIm::find()->where(['orafin_code'=>$model->orafin_code])->one();
					if($modelItem){
						return $modelItem->referenceSn->description;						
					}
				}
            ],
			[
                'label' => 'Status',
				'format' => 'raw',
				'value' => function($model){
					if(InboundPoDetail::find()->where(['and',['id_inbound_po'=>$model->id_inbound],['orafin_code'=>$model->orafin_code]])->exists()){
						return "<span class='label label-success'  >Closed</span>";
					}else if(!MasterItemIm::find()->where(['orafin_code'=>$model->orafin_code])->exists() ){
						return "<span class='label label-danger' >Not Registered</span>";
					}		
					else{ 
						return "<span class='label label-primary'>Open</span>";
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
										'title' => Yii::t('app', 'create'), 'class' => 'updatesButton','idInboundPo'=>$model->id_inbound,'orafinCode'=>$model->orafin_code, 'rrNumber'=>$model->rr_number, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
									]);
								}else{
									return Html::a('<span style="margin:0px 2px;" class="label label-success">Choose</span>', '#', [
										'title' => Yii::t('app', 'create'), 'class' => 'createsButton', 'value'=>$model->orafin_code, 'value2'=>$model->rr_number, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
									]);
								}
							}	
							
                    },
                ],
            ],
        ],
    ]); ?>
	
    <p>
        <?= Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-success']) ?>
        <?= Html::button(Yii::t('app','Submit'), ['id'=>'submitButton','class' => 'btn btn-success']) ?>
    </p>
	<?php yii\widgets\Pjax::end() ?>
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
                .load('<?php echo Url::to(['/inbound-po/createdetail']) ;?>?orafinCode='+$(this).attr('value')+'&rrNumber='+$(this).attr('value2'));
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
                .load('<?php echo Url::to(['/inbound-po/updatedetail']) ;?>?idInboundPo='+$(this).attr('idInboundPo')+'&orafinCode='+$(this).attr('orafinCode')+'&rrNumber='+$(this).attr('rrNumber'));
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
        $('#modal').modal('hide');
		var url = $('#pjax li.active a').attr('href');
		$.pjax.reload({container:'#pjax', url: url});
    });
    $('.viewButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
        $('#modalHeader').html('<h3> '+ $(this).attr('header') +'</h3>');
    });

</script>
