<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;

use common\models\Reference;
use common\models\Warehouse;
/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */

// $this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inbound Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inbound-wh-transfer-view">

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
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            
			'item_name',
			'im_code',
			'grouping',
			'req_good',
			'qty',
			
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
        pesan = '<?= Yii::$app->params['pesanRevise'] ?>';
        $('#submitForm').show();
    });
	
	$('#updateButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-wh-transfer/update', 'idOutboundWh'=>$model->id_outbound_wh]) ;?>');
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

            url = '<?php echo Url::to(['/inbound-wh-transfer/revise', 'id' => $model->id_outbound_wh]) ;?>';
            console.log(url);
            if (!form.find('.has-error').length) {

                data = new FormData();
                data.append( 'InboundWhTransfer[revision_remark]', $( '#inboundwhtransfer-revision_remark' ).val() );
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
            url: '<?php echo Url::to(['/inbound-wh-transfer/approve', 'id' => $model->id_outbound_wh]) ;?>',
            type: 'post',
			async:true,
            success: function (response) {
                $('#modal').modal('hide');
				setPopupAlert('Data has been approved.');
            }
        });
    });

	$('.uploadButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-wh-transfer/uploadsn']) ;?>?id='+$(this).attr('value'));
        $('#modalHeader').html('<h3> Upload Serial Number </h3>');
    });
	
	$('.viewButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-wh-transfer/viewdetailsn']) ;?>?idInboundPoDetail='+$(this).attr('value'));
        $('#modalHeader').html('<h3> Detail Serial Number </h3>');
    });
</script>