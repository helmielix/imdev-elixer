<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

use common\models\Reference;
use common\models\MasterItemIm;
use common\models\InboundPoDetail;
use common\models\OrafinViewMkmPrToPay;
/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */

// $this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inbound Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inbound-po-view">
    <?php 
        $label = '';
        if(Yii::$app->controller->action->id == 'view' || Yii::$app->controller->action->id == 'viewverify'){
            $label = 'Inputted By';
        }else if(Yii::$app->controller->action->id == 'viewapprove'){
            $label = 'Verified By';
        }
    ?>
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
                    'label' => 'Warehouse Tujuan',
                    'value' => function($model){
                        if($model->idWarehouse){
                            return $model->idWarehouse->nama_warehouse;
                        }
                    }
                ],
                [
                    'attribute' => 'file_attachment',
                    'value' => function($model){
                        return Html::a(basename($model->file_attachment), ['downloadfile','id' => $model->id], $options = ['target'=>'_blank', 'data' => [
                                'method' => 'post',
                                'params' => [
                                    'data' => 'file_attachment',
                                ]
                            ]]);
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Inputted By',
                    'value' => function($model){
                        return $model->createdBy->username;
                    }
                ],[
                    'label' => 'Verified By',
                    'value' => function($model){
                        if($model->verifiedBy){
                            return $model->verifiedBy->username;
                        }
                        
                    },
                    'visible' => ($model->status_listing > 3),
                ],[
                    'label' => 'Approved By',
                    'value' => function($model){
                        if($model->approvedBy){
                            return $model->approvedBy->username;
                        }
                        
                    },
                    'visible' => ($model->status_listing > 4),
                ],
                'revision_remark:ntext'
			],
		]) ?>
	
	<?php 
        Pjax::begin(['id' => 'gridpjax', 'timeout' => 5000, 'enablePushState' => false, 'clientOptions' => ['method' => 'get']]) 
        // Pjax::begin()
    ?>
	
	<?= GridView::widget([
        'id' => 'gridViewdetailnew',
        'options' => ['style' => 'overflow-x:scroll'],
		// 'pjax' =>true,
		// 'pjaxSettings'=>[
		// 	'options' => [
		// 		'id' => 'gridViewaja',
		// 	],
		// 	'neverTimeout'=>true,
  //           'method' => 'post'
		// ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
             ['class' => 'yii\grid\SerialColumn'],
             // 'id_inbound',
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
                'value' => function($model){
                    if($model->grouping)
                    return Reference::findOne($model->grouping)->description;
                },
                'filter' => Arrayhelper::map(Reference::find()->andWhere(['table_relation' => 'grouping'])->all(), 'id', 'description'),
            ],
            [
                'attribute' => 'qty_rr',
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
            // 'id_item_im',
			[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
                'buttons'=>[
                    'view' => function ($url, $model) {
                        $viewurl = '';
                            if(Yii::$app->controller->action->id == 'indextagsn') $viewurl = 'viewsn';
                            if(Yii::$app->controller->action->id == 'view') $viewurl = 'viewdetail';
                            if(Yii::$app->controller->action->id == 'viewapprove') $viewurl = 'viewdetailapprove';
                            if(Yii::$app->controller->action->id == 'viewverify') $viewurl = 'viewdetailverify';
                            if(Yii::$app->controller->action->id == 'viewoverview') $viewurl = 'viewdetailoverview';

                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#view', [
                                        'title' => Yii::t('app', 'view'), 'class' => 'viewsButton','idInboundPo'=>$model->id_inbound,'url'=>$viewurl,'orafinCode'=>$model->orafin_code, 'rrNumber'=>$model->rr_number, 'idItemIm' => $model->id_item_im, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                                    ]);
                      
                    },
                    
                ],
            ],
        ],
    ]); ?>
<?php \yii\widgets\Pjax::end(); ?>
	
	<p>
        <?php if(Yii::$app->controller->action->id == 'view' && $model->status_listing != 6 && ($model->status_listing != 5 && $model->status_listing != 4) )
            echo Html::button(Yii::t('app','Update'), ['id'=>'updateButton','class' => 'btn btn-primary']); ?>
        <?php if(Yii::$app->controller->action->id == 'view' && $model->status_listing != 6 && ($model->status_listing != 5 && $model->status_listing != 4))
            echo Html::button(Yii::t('app','Delete'), ['id'=>'deleteButton','class' => 'btn btn-danger']); ?>
        
        <?php if((Yii::$app->controller->action->id == 'viewapprove' ) && $model->status_listing != 5 )
            echo Html::button(Yii::t('app','Approve'), ['id'=>'approveButton','class' => 'btn btn-success']); ?>
        <?php if(Yii::$app->controller->action->id == 'viewverify' && $model->status_listing != 4)
            echo Html::button(Yii::t('app','Revise'), ['id'=>'reviseButton','class' => 'btn btn-warning']); ?>
        <?php if((Yii::$app->controller->action->id == 'viewverify' ) && $model->status_listing != 43 && $model->status_listing != 4 )
            echo Html::button(Yii::t('app','Verify'), ['id'=>'verifyButton','class' => 'btn btn-success']); ?>
        
        
           

    </p> 
	<?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'id' => 'submitForm',
        'layout' => 'horizontal',
        'options' => [
            'style' => 'display:none;'
        ],
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-1',
                'offset' => 'col-sm-offset-1',
                'wrapper' => 'col-sm-6',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>

    <br />
    <?= $form->field($model, 'revision_remark')->textarea(['rows' => '5']) ?>
    <?= Html::button(\Yii::t('app','Submit Remark'), ['id'=>'submitButton','class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
	
</div>
<script>
    $('#modalContent').on('click', '.viewsButton', function(event){ 
    // $('.viewsButton').click(function (event) {
            event.stopImmediatePropagation();  
            var url = '';
            if($(this).attr('url') == 'viewdetail'){
                url = '<?php echo Url::to(['/inbound-po/viewdetail']) ;?>';
            }else if($(this).attr('url') == 'viewdetailverify'){
                url = '<?php echo Url::to(['/inbound-po/viewdetailverify']) ;?>';
            }else if($(this).attr('url') == 'viewdetailapprove'){
                url = '<?php echo Url::to(['/inbound-po/viewdetailapprove']) ;?>';
            }else if($(this).attr('url') == 'viewdetailoverview'){
                url = '<?php echo Url::to(['/inbound-po/viewdetailoverview']) ;?>';
            }
            console.log(url);
            // return false;
            $('#modal').modal('show')
                .find('#modalContent')
                .load(url+'?idInboundPo='+$(this).attr('idInboundPo')+'&orafinCode='+$(this).attr('orafinCode')+'&rrNumber='+$(this).attr('rrNumber')+'&idItemIm='+$(this).attr('idItemIm'));
            $('#modalHeader').html('<h3> View Detail Inbound PO </h3>');
            // event.stopPropagation();
        });
	$('#reviseButton').click(function () {
        selectedAction = 'revise';
       // pesan = '<?= Yii::$app->params['pesanRevise'] ?>';
        $('#submitForm').show();
    });
	
	$('#updateButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-po/update', 'idInboundPo'=>$model->id]) ;?>');
        $('#modalHeader').html('<h3> Update Detail Inbound PO </h3>');
    });

    $('#deleteButton').click(function () {
        var resp = confirm("Do you want to delete this item?");
        
        if(resp == true){
            $.ajax({
                url: '<?php echo Url::to(['/inbound-po/delete', 'id' => $model->id]) ;?>',
                type: 'post',
                success: function (response) {
                    $('#modal').modal('hide');
                }
            });
        }else {
            return false;
        }
    });
	
	$('#submitButton').click(function () {
        if (selectedAction == 'revise') {
            var resp = confirm("Do you want to revise this item?");
        } else if (selectedAction == 'reject'){
            var resp = confirm("Do you want to reject this item?");
        }

        if (resp == true) {
            console.log('aa');
            console.log(selectedAction);
            var form = $('#submitForm');
            data = form.data("yiiActiveForm");
            $.each(data.attributes, function() {
                this.status = 3;
            });
            form.yiiActiveForm("validate");

            if (selectedAction == 'revise') url = '<?php echo Url::to(['/inbound-po/revise', 'id' => $model->id]) ;?>';
            
            if (!form.find('.has-error').length) {

                data = new FormData();
                data.append( 'InboundPo[revision_remark]', $( '#inboundpo-revision_remark' ).val() );
                $.ajax({
                    url: url,
                    type: 'post',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if(response == 'success') {
                            $('#modal').modal('hide');
                            setPopupAlert(pesan);
                        } else {
                            alert('error with message: ' + response);
                        }
                    }
                });
            };
        } else {
            return false;
        }
    });
	
	$('#approveButton').click(function () {
        $.ajax({
            url: '<?php echo Url::to(['/inbound-po/approve', 'id' => $model->id]) ;?>',
            type: 'post',
            success: function (response) {
                $('#modal').modal('hide');
               // setPopupAlert('<?= Yii::$app->params['pesanApproved'] ?>');
            }
        });
    });
    $('#verifyButton').click(function () {
        $.ajax({
            url: '<?php echo Url::to(['/inbound-po/verify', 'id' => $model->id]) ;?>',
            type: 'post',
            success: function (response) {
                $('#modal').modal('hide');
               // setPopupAlert('<?= Yii::$app->params['pesanApproved'] ?>');
            }
        });
    });

	$('.uploadButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-po/uploadsn']) ;?>?id='+$(this).attr('value'));
        $('#modalHeader').html('<h3> Upload Serial Number </h3>');
    });
	
	$('.viewButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-po/createdetail']) ;?>?idInboundPoDetail='+$(this).attr('value'));
        $('#modalHeader').html('<h3> Detail Serial Number </h3>');
    });
    $('#modal').removeAttr('tabindex');
</script>
