<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;

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
                        return "<span class='label' style='background-color:{$dataProvider->statusReference->status_color}' >{$dataProvider->statusReference->status_listing}</span>";
                    } else {
                        return "<span class='label' style='background-color:grey'>Open RR</span>";
                    }
                },
                // 'filter' => getFilterStatus()
            ],
			// [
                // 'class' => 'yii\grid\ActionColumn',
                // 'template'=>'{create} {view}',
                // 'buttons'=>[
                   
                    // 'create' => function ($url, $model) {
                        // if($model->status_listing == 999 ){
							// // Yii::$app->session->set('idInboundPoDetail', $model->id_inbound_po_detail);
                            // return Html::a('<span style="margin:0px 2px;" class="label label-success">Upload SN</span>', '#', [
                                // 'title' => Yii::t('app', 'create'), 'class' => 'uploadButton', 'value'=> $model->id_inbound_detail, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            // ]);
                        // }
                    // },
					
					// 'view' => function ($url, $model) {
                         // if($model->status_listing == 41 ){
							
                            // return Html::a('<span style="margin:0px 2px;" class="label label-danger">View</span>', '#', [
                                // 'title' => Yii::t('app', 'create'), 'class' => 'viewButton', 'value'=>$model->id_inbound_detail, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            // ]);
                        // }
                    // },
					
                // ],
            // ],
			
        ],
    ]); ?>
	
	<p>
        <?php if(Yii::$app->controller->action->id == 'view' && $model->status_listing != 6)
            echo Html::button(Yii::t('app','Update'), ['id'=>'updateButton','class' => 'btn btn-primary']); ?>
        
        <?php if(Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5)
            echo Html::button(Yii::t('app','Approve'), ['id'=>'approveButton','class' => 'btn btn-success']); ?>
        <?php if(Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5)
            echo Html::button(Yii::t('app','Revise'), ['id'=>'reviseButton','class' => 'btn btn-warning']); ?>
        
           

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
	<?php \yii\widgets\Pjax::end(); ?>
</div>
<script>
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

	$('.uploadButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-po/uploadsn']) ;?>?id='+$(this).attr('value'));
        $('#modalHeader').html('<h3> Upload Serial Number </h3>');
    });
	
	$('.viewButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-po/viewdetailsn']) ;?>?idInboundPoDetail='+$(this).attr('value'));
        $('#modalHeader').html('<h3> Detail Serial Number </h3>');
    });
</script>