<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

use common\models\Reference;
/* @var $this yii\web\View */
/* @var $model instruction\models\InstructionGrf */

// $this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instruction Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instruction-grf-view">

		<?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				'grf_number',
				'wo_number',
				'requestor',
				'grf_type',
				'division',
				'id_region',
                'pic',
                // [
                //     'attribute' => 'id_warehouse',
                //     'value' => function($model){
                //         return $model->idWarehouse->nama_warehouse;
                //     }
                // ]
			],
		]) ?>
	<div class="row" id="containerdownload">
        <div class="col-sm-offset-7">
            <label>Mac Address
                <?= Html::checkBox('macAddressCheckbox', '', ['id' => 'checkboxMacaddr']) ?>
            </label>
            <?= Html::button(Yii::t('app','Download Template'), ['id'=>'downloadButton','class' => 'btn btn-success']) ?>
        </div>
    </div>
	
	<?php 
	Pjax::begin(['id' => 'gridpjax', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]) 
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
            
			// 'im_code',
			'im_code',
			'brand',
			'warna',
			'grouping',
			// 'qty',
            'qty_good',
            'qty_noot_good',
            'qty_reject',
			
			// 'id_Instruction_detail',
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
							// Yii::$app->session->set('idInstructionGrfDetail', $model->id_instruction_grf_detail);
                            return Html::a('<span style="margin:0px 2px;" class="label label-success">Upload SN</span>', '#', [
                                'title' => Yii::t('app', 'create'), 'data-pjax' => false, 'class' => 'uploadButton', 'value'=> $model->id_instruction_detail,'idInstructionGrf' => $model->id_instruction_grf, 'qty' => $model->qty, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }else if($model->sn_type ==2){
                        		return Html::a('<span style="margin:0px 2px;" class="label label-success">QTY Cond</span>', '#', [
                                'title' => Yii::t('app', 'create'), 'data-pjax' => false,'class' => 'qtycondButton', 'value'=> $model->id_instruction_detail,'idInstructionPo' => $model->id_instruction_grf, 'qty' => $model->qty, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        	
                        }
                    },
					
					'view' => function ($url, $model) {
                         if(($model->status_listing == 41 || $model->status_listing == 43) && $model->sn_type ==1){
							
                            return Html::a('<span style="margin:0px 2px;" class="label label-info">View</span>', '#', [
                                'title' => Yii::t('app', 'create'), 'data-pjax' => false,'class' => 'viewButton', 'value'=>$model->id_instruction_detail, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }else if(($model->status_listing == 41 || $model->status_listing == 43) && $model->sn_type ==2){
                            return Html::a('<span style="margin:0px 2px;" class="label label-info">View</span>', '#', [
                                'title' => Yii::t('app', 'create'),'data-pjax' => false, 'class' => 'viewQtycondButton', 'value'=> $model->id_instruction_detail,'idInstructionGrf' => $model->id_instruction_grf, 'qty' => $model->qty, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
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
                                'title' => Yii::t('app', 'Reset'),'data-pjax' => false, 'class' => 'resetButton','idInstructionGrfDetail'=>$model->id_instruction_detail ,'value'=>$model->id_instruction_grf, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }else if(($model->status_listing == 41 || $model->status_listing == 43) && $model->sn_type ==2){
                            return Html::a('<span style="margin:0px 2px;" class="fa fa-undo"></span>', '#', [
                                'title' => Yii::t('app', 'Reset'),'data-pjax' => false, 'class' => 'resetqtycondButton','idInstructionGrfDetail'=>$model->id_instruction_detail ,'value'=>$model->id_instruction_grf, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }
                    },
					
                ],
            ],
			
        ],
    ]); ?>
	<?php \yii\widgets\Pjax::end(); ?>
    <?= Html::button(Yii::t('app','Submit'), ['id'=>'submitButton','class' => 'btn btn-success']) ?>
</div>
<script>
	// $('.uploadButton').click(function () {
    $(document).on('click', '.uploadButton', function(event){
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/instruction-grf/uploadsn']) ;?>?id='+$(this).attr('value')+'&idInstructionGrf='+$(this).attr('idInstructionGrf')+'&qty='+$(this).attr('qty'));
        $('#modalHeader').html('<h3> Upload Serial Number </h3>');
    });

    // $('.qtycondButton').click(function () {
    $(document).on('click', '.qtycondButton', function(event){ 
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/instruction-grf/qtycond']) ;?>?id='+$(this).attr('value')+'&idInstructionGrf='+$(this).attr('idInstructionGrf')+'&qty='+$(this).attr('qty'));
        $('#modalHeader').html('<h3> Upload Serial Number </h3>');
    });
	
	// $('.viewButton').click(function () {
    $(document).on('click', '.viewButton', function(event){
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/instruction-grf/viewdetailsn']) ;?>?idInstructionGrfDetail='+$(this).attr('value'));
        $('#modalHeader').html('<h3> Detail Serial Number </h3>');
    });

    // $('.viewQtycondButton').click(function () {//
    $(document).on('click', '.viewQtycondButton', function(event){
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/instruction-grf/viewqtycond']) ;?>?idInstructionGrfDetail='+$(this).attr('value'));
        $('#modalHeader').html('<h3> Detail Serial Number </h3>');
    });
	
	// $('.resetButton').click(function () {
    $(document).on('click', '.resetButton', function(event){   
        $.ajax({
            url:'<?php echo Url::to(['/instruction-grf/resetsn']) ;?>?idInstructionGrfDetail='+$(this).attr('idInstructionPoDetail'),
            type: 'post',
            success: function (response) {
                $('#modal').modal('show')
					.find('#modalContent')
					.load('<?php echo Url::to(['/instruction-grf/viewsn' , 'id' => \Yii::$app->session->get('idInstructionGrf')]) ;?>');
				$('#modalHeader').html('<h3> Detail Serial Number </h3>');
				
				var url = $('#pjax li.active a').attr('href');
			   // $.pjax.reload({container:'#gridpjax', url: url});
            }
        });
    });

    // $('.resetqtycondButton').click(function () {
    $(document).on('click', '.resetqtycondButton', function(event){
        $.ajax({
            url:'<?php echo Url::to(['/instruction-grf/resetqtycond']) ;?>?idInstructionGrfDetail='+$(this).attr('idInstructionGrfDetail'),
            type: 'post',
            success: function (response) {
                $('#modal').modal('show')
                    .find('#modalContent')
                    .load('<?php echo Url::to(['/instruction-grf/viewsn' , 'id' => \Yii::$app->session->get('idInstructionPo')]) ;?>');
                $('#modalHeader').html('<h3> Detail Serial Number </h3>');
                
                var url = $('#pjax li.active a').attr('href');
               // $.pjax.reload({container:'#gridpjax', url: url});
            }
        });
    });

    $('#submitButton').click(function () {
        $.ajax({
            url:'<?php echo Url::to(['/instruction-grf/submitsn']) ;?>',
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
            url:'<?php echo Url::to(['/instruction-grf/downloadfile', 'id' => 'template']) ;?>',
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