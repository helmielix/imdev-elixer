<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

use common\models\Reference;
use common\models\StatusReference;
use common\models\OrafinViewMkmPrToPay;
/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */

// $this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inbound Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

function filterstatusdetail(){
    $filter = ArrayHelper::map(StatusReference::find()->andWhere(['id' => [41, 43]])->all(), 'id', 'status_listing');
    $filter[999] = 'Not Yet Uploaded';
    return $filter;
}

?>
<div class="inbound-po-view">

		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				'rr_number',
				'pr_number',
				'po_number',
				'supplier',
				 [
                    'label' => 'Tanggal RR',
                    'value' => function($model){
                        //return $model->rr_number; // tes
                        return OrafinViewMkmPrToPay::find()->where(['=', 'rcv_no', $model->rr_number])
                                ->one()->rcv_date;
                    }
                ],
                'no_sj',
				'tgl_sj',
                'waranty',
                [
                    'attribute' => 'id_warehouse',
                    'value' => function($model){
                        return $model->idWarehouse->nama_warehouse;
                    }
                ],
                [
                    'label' => 'Inputted By',
                    'value' => function($model){
                        return $model->createdBy->username;
                    }
                ],
                [
                    'label' => 'Verified By',
                    'value' => function($model){
                        if($model->verifiedBy){
                            return $model->verifiedBy->username;
                        }
                        
                    }
                ],
                [
                    'label' => 'Approved By',
                    'value' => function($model){
                        if($model->approvedBy){
                            return $model->approvedBy->username;
                        }
                        
                    }
                ],
			],
		]) ?>
    <div class="row">
        <div class="col-sm-offset-7">
            <label>Mac Address
                <?= Html::checkBox('macAddressCheckbox', '', ['id' => 'checkboxMacaddr']) ?>
            </label>
            <?= Html::a(Yii::t('app','Download Template'), [$this->context->id.'/downloadfile', 'id'=>'template'], ['id'=>'templateButton','class' => 'btn btn-primary btn-sm', 'data-method' => 'post']) ?>
            <div class="text-danger">*Check "Mac Address" for Template with Mac Address Column</div>
        </div>
    </div>

    
	
	<?php 
	Pjax::begin(['id' => 'gridpjax', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']]) 
	// Pjax::begin()
	?>
	<?= GridView::widget([
        'id' => 'gridViewdetail',
        // 'options' => [
        //     'style'=>'overflow-: scroll',
        // ],
		// 'pjax' =>tue,
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
			[
                'attribute' => 'grouping',
                'value' => function($model){
                    return Reference::findOne($model->grouping)->description;
                },
                'filter' => ArrayHelper::map(Reference::find()->andWhere(['table_relation' => 'grouping'])->all(), 'id', 'description'),
            ],
            [
                'attribute' => 'brand',
                'value' => function($model){
                    return Reference::findOne($model->brand)->description;
                },
                'filter' => ArrayHelper::map(Reference::find()->andWhere(['table_relation' => 'brand'])->all(), 'id', 'description'),
            ],
            [
                'attribute' => 'warna',
                'label' => 'Color',
                'value' => function($model){
                    return Reference::findOne($model->warna)->description;
                },
                'filter' => ArrayHelper::map(Reference::find()->andWhere(['table_relation' => 'warna'])->all(), 'id', 'description'),
            ],
            [
                'attribute' => 'type',
                'value' => function($model){
                    return Reference::findOne($model->type)->description;
                },
                'filter' => ArrayHelper::map(Reference::find()->andWhere(['table_relation' => 'item_type'])->all(), 'id', 'description'),
            ],
			'qty',
            'qty_good',
            'qty_not_good',
            'qty_reject',
			
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
                'filter' => filterstatusdetail(),

            ],
			[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{create} {view} {reset}',
                'buttons'=>[
                   
                    'create' => function ($url, $model) {
                        if(($model->status_listing == 999 || $model->status_listing == 43) && $model->sn_type ==1){
							// Yii::$app->session->set('idInboundPoDetail', $model->id_inbound_po_detail);
                            return Html::a('<span style="margin:0px 2px;" class="label label-success">Upload SN</span>', '#', [
                                'title' => Yii::t('app', 'create'), 'data-pjax' => false, 'class' => 'uploadButton', 'value'=> $model->id_inbound_detail,'idInboundPo' => $model->id_inbound_po, 'qty' => $model->qty, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }else if(($model->status_listing == 999 || $model->status_listing == 43) && $model->sn_type ==2){
                        		return Html::a('<span style="margin:0px 2px;" class="label label-success">QTY Cond</span>', '#', [
                                'title' => Yii::t('app', 'create'), 'data-pjax' => false,'class' => 'qtycondButton', 'value'=> $model->id_inbound_detail,'idInboundPo' => $model->id_inbound_po, 'qty' => $model->qty, 'header'=> yii::t('app','Detail Qty Condition')
                            ]);
                        	
                        }
                    },
					
					'view' => function ($url, $model) {
                         if(($model->status_listing == 41 || $model->status_listing == 43) && $model->sn_type ==1){
							
                            return Html::a('<span style="margin:0px 2px;" class="label label-info">View</span>', '#', [
                                'title' => Yii::t('app', 'create'), 'data-pjax' => false,'class' => 'viewsButton', 'value'=>$model->id_inbound_detail, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }else if(($model->status_listing == 41 || $model->status_listing == 43) && $model->sn_type ==2){
                            return Html::a('<span style="margin:0px 2px;" class="label label-info">View</span>', '#', [
                                'title' => Yii::t('app', 'create'),'data-pjax' => false, 'class' => 'viewQtycondButton', 'value'=> $model->id_inbound_detail,'idInboundPo' => $model->id_inbound_po, 'qty' => $model->qty, 'header'=> yii::t('app','Detail Qty Condition')
                            ]);
                        }
                    },
					
					
                ],
            ],
			[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{reset}',
                'buttons'=>[
                   

					'reset' => function ($url, $searchModel) use ($model){
                        if(($searchModel->status_listing == 41 || $searchModel->status_listing == 43 ) && $searchModel->sn_type ==1 && $model->status_listing !=42){
							
                            return Html::a('<span style="margin:0px 2px;" class="label label-danger">Reset</span>', '#', [
                                'title' => Yii::t('app', 'Reset'),'data-pjax' => false, 'class' => 'resetButton','idInboundPoDetail'    =>$searchModel->id_inbound_detail ,'value'=>$searchModel->id_inbound_po, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }else if(($searchModel->status_listing == 41 || $searchModel->status_listing == 43) && $searchModel->sn_type ==2 && $model->status_listing !=42){
                            return Html::a('<span style="margin:0px 2px;" class="label label-danger">Reset</span>', '#', [
                                'title' => Yii::t('app', 'Reset'),'data-pjax' => false, 'class' => 'resetqtycondButton','idInboundPoDetail'=>$searchModel->id_inbound_detail ,'value'=>$searchModel->id_inbound_po, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }
                    },
					
                ],
            ],
			
        ],
    ]); ?>
	<?php \yii\widgets\Pjax::end(); ?>
     <?php if(Yii::$app->controller->action->id == 'viewsn' && $model->status_listing != 42 )
     echo Html::button(Yii::t('app','Submit'), ['id'=>'submitButton','class' => 'btn btn-success']) ?>
</div>
<script>
    $('#checkboxMacaddr').click(function(){
        var url = '<?= Url::to([$this->context->id.'/downloadfile']) ?>';
        
        if ( $('#checkboxMacaddr').is(':checked') ){
            url = url + '?id=templatemac';
        }else{
            url = url + '?id=template';
        }
        
        $('#templateButton').attr('href', url);
    });
	// $('.uploadButton').click(function () {
    $(document).on('click', '.uploadButton', function(event){
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-po/uploadsn']) ;?>?id='+$(this).attr('value')+'&idInboundPo='+$(this).attr('idInboundPo')+'&qty='+$(this).attr('qty'));
        $('#modalHeader').html('<h3> Upload Serial Number </h3>');
    });

    // $('.qtycondButton').click(function () {
    $('#gridViewdetail-container').on('click', '.qtycondButton', function(event){ 
        event.stopImmediatePropagation();
        console.log(event.isImmediatePropagationStopped() + ' hallo');
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-po/qtycond']) ;?>?id='+$(this).attr('value')+'&idInboundPo='+$(this).attr('idInboundPo')+'&qty='+$(this).attr('qty'));
        $('#modalHeader').html('<h3> Detail Qty Condition </h3>');
    });
	
	// $('.viewButton').click(function () {
    $(document).on('click', '.viewsButton', function(event){
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-po/viewdetailsn']) ;?>?idInboundPoDetail='+$(this).attr('value'));
        $('#modalHeader').html('<h3> Detail Serial Number </h3>');
    });

    // $('.viewQtycondButton').click(function () {//
    $(document).on('click', '.viewQtycondButton', function(event){
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-po/viewqtycond']) ;?>?idInboundPoDetail='+$(this).attr('value'));
        $('#modalHeader').html('<h3> Detail Qty Condition </h3>');
    });
	
	// $('.resetButton').click(function () {
    $('#gridViewdetail-container').on('click', '.resetButton', function(event){   
        event.stopImmediatePropagation();
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

    // $('.resetqtycondButton').click(function () {
    $('#gridViewdetail-container').on('click', '.resetqtycondButton', function(event){
        event.stopImmediatePropagation();
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

    $('#submitButton').click(function () {
        $.ajax({
            url:'<?php echo Url::to(['/inbound-po/submitsn']) ;?>',
            type: 'post',
            success: function (response) {
                $('#modal').modal('hide')
                
                var url = $('#pjax li.active a').attr('href');
               // $.pjax.reload({container:'#gridpjax', url: url});
            }
        });
    });

    $('#downloadButton').click(function () {
        var form = $('#containerdownload-container');
        data = new FormData();
        form.find('input:checkbox')
            .each(function(){
                name = $(this).attr('name');
                val = $(this).val();
                data.append(name, val);
            });
        $.ajax({
            url:'<?php echo Url::to(['/inbound-po/downloadfile', 'id' => 'template']) ;?>',
            data: data,
            type: 'post',
            processData: false,
            contentType: false,
            success: function (response) {
                // alert($('#checkboxMacaddr').val());
                // $('#modal').modal('hide')
                
                // var url = $('#pjax li.active a').attr('href');
               // $.pjax.reload({container:'#gridpjax', url: url});
            }
        });
    });
</script>
