<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use dosamigos\datepicker\DatePicker;

use common\models\Reference;
use common\models\StatusReference;
use common\models\Warehouse;
/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */

// $this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inbound Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$datasession = Yii::$app->session->get('detailinbound');

?>
<div class="inbound-wh-transfer-view">

	<div class='row'>
		<div class='col-sm-12'>
		<?= DetailView::widget([
			'model' => $model,
			'options' => ['class' => 'small table table-striped table-bordered detail-view'],
			'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
			'attributes' => [
				[
					'label' => 'Nama Material',
					'value' => function($model){
						// return $model->idItemIm->idMasterItemIm->name;
						return $model->idItemIm->name;
					},
				],
				[
					'label' => 'IM Code',
					'value' => function($model){
						// return $model->idItemIm->idMasterItemIm->im_code;
						return $model->idItemIm->im_code;
					},
				],
				[
					'label' => 'Grouping Barang',
					'value' => function($model){
						// return $model->idItemIm->idMasterItemIm->grouping;
						return $model->idItemIm->grouping;
					},
				],

				'qty'
			],
		]) ?>
		</div>

	</div>

	<div class="alert hidden" id="errorSummary">Please fix these following error: <ul id="ulerrorSummary"></ul></div>
	<?php
	Pjax::begin(['id' => 'pjaxviewdetail', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']])
	// Pjax::begin()
	?>
	<?= GridView::widget([
        'id' => 'gridViewdetail',
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

			[
				'attribute' => 'qty_good',
				'format' => 'raw',
				'value' => function ($model){
					$val = $model->qty_good;
					$out = Html::textInput('qty_good', $val, ['class' => 'form-control input-sm', 'id' => 'qty_good']);
					return $out;
				},
			],
			[
				'attribute' => 'qty_not_good',
				'format' => 'raw',
				'value' => function ($model){
					$val = $model->qty_not_good;
					$out = Html::textInput('qty_not_good', $val, ['class' => 'form-control input-sm', 'id' => 'qty_not_good']);
					return $out;
				},
			],
			[
				'attribute' => 'qty_reject',
				'format' => 'raw',
				'value' => function ($model){
					$val = $model->qty_reject;
					$out = Html::textInput('qty_reject', $val, ['class' => 'form-control input-sm', 'id' => 'qty_reject']);
					return $out;
				},
			],
			[
				'attribute' => 'qty_good_dismantle',
				'format' => 'raw',
				'value' => function ($model){
					$val = $model->qty_good_dismantle;
					$out = Html::textInput('qty_good_dismantle', $val, ['class' => 'form-control input-sm', 'id' => 'qty_good_dismantle']);
					return $out;
				},
			],
			[
				'attribute' => 'qty_not_good_dismantle',
				'format' => 'raw',
				'value' => function ($model){
					$val = $model->qty_not_good_dismantle;
					$out = Html::textInput('qty_not_good_dismantle', $val, ['class' => 'form-control input-sm', 'id' => 'qty_not_good_dismantle']);
					return $out;
				},
			],

			[
				'label' => 'Delta Qty',
				'format' => 'raw',
				'value' => function ($model){
					$val = $model->qty - ( $model->qty_good + $model->qty_not_good + $model->qty_reject + $model->qty_good_dismantle + $model->qty_not_good_dismantle);
					$out = Html::textInput('delta_qty', $val, ['class' => 'form-control input-sm', 'delta' => $model->qty, 'id' => 'delta_qty', 'disabled' => true]);
					return $out;
				},
			],

        ],
    ]); ?>
	<?php Pjax::end(); ?>

	<p>
		<?php if(Yii::$app->controller->action->id == 'qtycond')
            echo Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-success']); ?>
		<?php if(Yii::$app->controller->action->id == 'qtycond')
            echo Html::button(Yii::t('app','Submit'), ['id'=>'inputButton','class' => 'btn btn-success']); ?>

    </p>


</div>
<script>
	if ( $('#delta_qty').val() < 0){
		$('#inputButton').attr('disabled', true);
	}

	$('table').on('blur', '.input-sm', function(){
		var delta = $('#delta_qty');
		var qty_good 				= parseInt( $('#qty_good').val() ) || 0;
		var qty_not_good 			= parseInt( $('#qty_not_good').val() ) || 0;
		var qty_reject 				= parseInt( $('#qty_reject').val() ) || 0;
		var qty_good_dismantle 		= parseInt( $('#qty_good_dismantle').val() ) || 0;
		var qty_not_good_dismantle 	= parseInt( $('#qty_not_good_dismantle').val() ) || 0;

		selisih = parseInt( delta.attr('delta') ) - (qty_good + qty_not_good + qty_reject + qty_good_dismantle + qty_not_good_dismantle);

		delta.val(selisih);
		$('qty_good').val(qty_good);
		$('qty_not_good').val(qty_not_good);
		$('qty_reject').val(qty_reject);
		$('qty_good_dismantle').val(qty_good_dismantle);
		$('qty_not_good_dismantle').val(qty_not_good_dismantle);

		if (selisih < 0){
			alert('Qty is more than Delta');
			$('#inputButton').attr('disabled', true);
		}else{
			$('#inputButton').attr('disabled', false);
		}
	});

	$('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['inbound-wh-transfer/viewtagsn','id'=>$model->id_inbound_wh]) ;?>');
        $('#modalHeader').html('<h3> Create Tag SN </h3>');
    });

	$('#inputButton').click(function (e) {
        var form = $('#gridViewdetail-container');

		data = new FormData();
		form.find('input:hidden, input:text')
			.each(function(){
				name = $(this).attr('name');
				val = $(this).val();
				data.append(name, val);
			});

		var button = $(this);
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

		url = '<?php echo Url::to([$this->context->id.'/qtycond', 'id' => $model->id, 'idInboundWh' => $model->id_inbound_wh]) ;?>';

		$.ajax({
            url: url,
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                if(response == 'success') {
					$('#previousButton').trigger('click');
                } else {
                    alert('error with message: ' + response);
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


</script>
