<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

use common\models\Reference;
/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */

// $this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inbound Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inbound-po-view">

		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				'rr_number',
				'pr_number',
				'po_number',
				'supplier',
				'rr_date',
				'tgl_sj',
				'waranty',
			],
		]) ?>
	
	
	<?php 
	Pjax::begin(['id' => 'gridpjax', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]) 
	// Pjax::begin()
	?>
	<?= GridView::widget([
        'id' => 'gridViewdetail',
		// 'pjax' =>true,
		// 'pjaxSettings'=>[
			// 'options' => [
				// 'id' => 'gridViewaja',
			// ],
			// 'neverTimeout'=>true,
			// 'beforeGrid'=>'My fancy content before.',
			// 'afterGrid'=>'My fancy content after.',
		// ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            
			'item_name',
			'im_code',
			'brand',
			'warna',
			'grouping',
			'qty',
			
			// 'id_inbound_detail',
			[
                'attribute' => 'status_listing',
                'format' => 'raw',
                'value' => function ($dataProvider) {
                    if ($dataProvider->status_listing) {
						if($dataProvider->status_listing == 999){
							return "<span class='label' style='background-color:{$dataProvider->statusReference->status_color}' >Not Yet Uploaded</span>";
						}else{
							return "<span class='label' style='background-color:{$dataProvider->statusReference->status_color}' >{$dataProvider->statusReference->status_listing}</span>";
						}
                    } else {
                        return "<span class='label' style='background-color:grey'>Open RR</span>";
                    }
                },
                // 'filter' => getFilterStatus()
            ],
			[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{create} {view} {reset}',
                'buttons'=>[
                   
                    'create' => function ($url, $model) {
                        if(($model->status_listing == 999 || $model->status_listing == 43) && $model->sn_type ==1){
							// Yii::$app->session->set('idInboundPoDetail', $model->id_inbound_po_detail);
                            return Html::a('<span style="margin:0px 2px;" class="label label-success">Upload SN</span>', '#', [
                                'title' => Yii::t('app', 'create'), 'class' => 'uploadButton', 'value'=> $model->id_inbound_detail,'idInboundPo' => $model->id_inbound_po, 'qty' => $model->qty, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }else if($model->sn_type ==2){
                        		return Html::a('<span style="margin:0px 2px;" class="label label-success">QTY Cond</span>', '#', [
                                'title' => Yii::t('app', 'create'), 'class' => 'qtycondButton', 'value'=> $model->id_inbound_detail,'idInboundPo' => $model->id_inbound_po, 'qty' => $model->qty, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        	
                        }
                    },
					
					'view' => function ($url, $model) {
                         if(($model->status_listing == 41 || $model->status_listing == 43) && $model->sn_type ==1){
							
                            return Html::a('<span style="margin:0px 2px;" class="label label-info">View</span>', '#', [
                                'title' => Yii::t('app', 'create'), 'class' => 'viewButton', 'value'=>$model->id_inbound_detail, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }else if(($model->status_listing == 41 || $model->status_listing == 43) && $model->sn_type ==2){
                            return Html::a('<span style="margin:0px 2px;" class="label label-info">View</span>', '#', [
                                'title' => Yii::t('app', 'create'), 'class' => 'viewQtycondButton', 'value'=> $model->id_inbound_detail,'idInboundPo' => $model->id_inbound_po, 'qty' => $model->qty, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }
                    },
					
					
                ],
            ],
			[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{reset}',
                'buttons'=>[
                   
					
					'reset' => function ($url, $model) {
                        if(($model->status_listing == 41 || $model->status_listing == 43) && $model->sn_type ==1){
							
                            return Html::a('<span style="margin:0px 2px;" class="fa fa-undo"></span>', '#', [
                                'title' => Yii::t('app', 'Reset'), 'class' => 'resetButton','idInboundPoDetail'=>$model->id_inbound_detail ,'value'=>$model->id_inbound_po, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }else if(($model->status_listing == 41 || $model->status_listing == 43) && $model->sn_type ==2){
                            return Html::a('<span style="margin:0px 2px;" class="fa fa-undo"></span>', '#', [
                                'title' => Yii::t('app', 'Reset'), 'class' => 'resetqtycondButton','idInboundPoDetail'=>$model->id_inbound_detail ,'value'=>$model->id_inbound_po, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }
                    },
					
                ],
            ],
			
        ],
    ]); ?>
	<?php \yii\widgets\Pjax::end(); ?>
</div>
<script>
	$('.uploadButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-po/uploadsn']) ;?>?id='+$(this).attr('value')+'&idInboundPo='+$(this).attr('idInboundPo')+'&qty='+$(this).attr('qty'));
        $('#modalHeader').html('<h3> Upload Serial Number </h3>');
    });

    $('.qtycondButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-po/qtycond']) ;?>?id='+$(this).attr('value')+'&idInboundPo='+$(this).attr('idInboundPo')+'&qty='+$(this).attr('qty'));
        $('#modalHeader').html('<h3> Upload Serial Number </h3>');
    });
	
	$('.viewButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-po/viewdetailsn']) ;?>?idInboundPoDetail='+$(this).attr('value'));
        $('#modalHeader').html('<h3> Detail Serial Number </h3>');
    });

    $('.viewQtycondButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-po/viewqtycond']) ;?>?idInboundPoDetail='+$(this).attr('value'));
        $('#modalHeader').html('<h3> Detail Serial Number </h3>');
    });
	
	$('.resetButton').click(function () {
        $.ajax({
            url:'<?php echo Url::to(['/inbound-po/resetsn']) ;?>?idInboundPoDetail='+$(this).attr('idInboundPoDetail'),
            type: 'post',
            success: function (response) {
                $('#modal').modal('show')
					.find('#modalContent')
					.load('<?php echo Url::to(['/inbound-po/viewsn' , 'id' => \Yii::$app->session->get('idInboundPo')]) ;?>');
				$('#modalHeader').html('<h3> Detail Serial Number </h3>');
				
				var url = $('#pjax li.active a').attr('href');
			   // $.pjax.reload({container:'#gridpjax', url: url});
            }
        });
    });

    $('.resetqtycondButton').click(function () {
        $.ajax({
            url:'<?php echo Url::to(['/inbound-po/resetqtycond']) ;?>?idInboundPoDetail='+$(this).attr('idInboundPoDetail'),
            type: 'post',
            success: function (response) {
                $('#modal').modal('show')
                    .find('#modalContent')
                    .load('<?php echo Url::to(['/inbound-po/viewsn' , 'id' => \Yii::$app->session->get('idInboundPo')]) ;?>');
                $('#modalHeader').html('<h3> Detail Serial Number </h3>');
                
                var url = $('#pjax li.active a').attr('href');
               // $.pjax.reload({container:'#gridpjax', url: url});
            }
        });
    });
</script>