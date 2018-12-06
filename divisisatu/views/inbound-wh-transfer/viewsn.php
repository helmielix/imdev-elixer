<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

use common\models\Reference;
use common\models\Warehouse;
/* @var $this yii\web\View */
/* @var $model inbound\models\InboundWh */

// $this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inbound Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inbound-po-view">

		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				[
					'attribute' => 'no_sj',
					'label' => 'No. Surat Jalan'
				],
				'arrival_date:date',
				[
					'attribute' => 'wh_origin',
					'value' => function($model){
						return Warehouse::findOne($model->wh_origin)->nama_warehouse;
					},
					'label' => 'Warehouse Origin'
				],
				[
					'attribute' => 'wh_destination',
					'value' => function($model){
						return Warehouse::findOne($model->wh_destination)->nama_warehouse;
					},
					'label' => 'Warehouse Origin'
				],
			],
		]) ?>
	
	
	<?php 
	Pjax::begin(['id' => 'pjax', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]) 
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
			'grouping',
			'qty',
			
			// 'id_inbound_detail',
			[
                'attribute' => 'status_listing',
                'format' => 'raw',
                'value' => function ($dataProvider) {
                    if ($dataProvider->status_listing) {
						if($dataProvider->status_listing == 999){
							return "<span class='label' style='background-color:{$dataProvider->statusListing->status_color}' >Not Yet Uploaded</span>";
						}else{
							return "<span class='label' style='background-color:{$dataProvider->statusListing->status_color}' >{$dataProvider->statusListing->status_listing}</span>";
						}
                    } else {
                        return "<span class='label' style='background-color:grey'>Open RR</span>";
                    }
                },
                'filter' => false
            ],
			[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{create} {view} {reset}',
                'buttons'=>[
                   
                    'create' => function ($url, $model) {
                        if($model->status_listing == 999 || $model->status_listing == 43){
							// Yii::$app->session->set('idInboundWhDetail', $model->id_outbound_wh_detail);
                            return Html::a('<span style="margin:0px 2px;" class="label label-success">Upload SN</span>', '#', [
                                'title' => Yii::t('app', 'create'), 'class' => 'uploadButton', 'value'=> $model->id_inbound_detail,'idInboundWh' => $model->id_inbound_wh, 'qty' => $model->qty, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }
                    },
					
					'view' => function ($url, $model) {
                         if($model->status_listing == 41 || $model->status_listing == 43){
							
                            return Html::a('<span style="margin:0px 2px;" class="label label-info">View</span>', '#', [
                                'title' => Yii::t('app', 'create'), 'class' => 'viewButton', 'value'=>$model->id_inbound_detail, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
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
                        if($model->status_listing == 41 || $model->status_listing == 43){
							
                            return Html::a('<span style="margin:0px 2px;" class="fa fa-undo"></span>', '#', [
                                'title' => Yii::t('app', 'Reset'), 'class' => 'resetButton','idInboundWhDetail'=>$model->id_inbound_detail ,'value'=>$model->id_outbound_wh, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
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
            .load('<?php echo Url::to(['inbound-wh-transfer/uploadsn']) ;?>?id='+$(this).attr('value')+'&idInboundWh='+$(this).attr('idInboundWh')+'&qty='+$(this).attr('qty'));
        $('#modalHeader').html('<h3> Upload Serial Number </h3>');
    });
	
	$('.viewButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['inbound-wh-transfer/viewdetailsn']) ;?>?idInboundWhDetail='+$(this).attr('value'));
        $('#modalHeader').html('<h3> Detail Serial Number </h3>');
    });
	
	$('.resetButton').click(function () {
        $.ajax({
            url:'<?php echo Url::to(['inbound-wh-transfer/resetsn']) ;?>?idInboundWhDetail='+$(this).attr('idInboundWhDetail'),
            type: 'post',
            success: function (response) {
                $('#modal').modal('show')
					.find('#modalContent')
					.load('<?php echo Url::to(['inbound-wh-transfer/viewsn' , 'id' => \Yii::$app->session->get('idInboundWh')]) ;?>');
				$('#modalHeader').html('<h3> Detail Serial Number </h3>');
				
				var url = $('#pjax li.active a').attr('href');
			   // $.pjax.reload({container:'#gridpjax', url: url});
            }
        });
    });
</script>