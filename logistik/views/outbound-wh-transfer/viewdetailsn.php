<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

use common\models\Reference;
/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inbound Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outbound-wh-transfer-view">



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
			[
				'attribute' => 'id_item_im',
				'value' => function($model){
					// return $model->idMasterItemImDetail->idMasterItemIm->name;
					return $model->idMasterItemIm->name;
				},
				'label' => 'Nama Material'
			],
			[
				'label' => 'IM Code',
				'value' => function($model){
					// return $model->idMasterItemImDetail->idMasterItemIm->im_code;
					return $model->idMasterItemIm->im_code;
				},
			],
			'req_good',
			'req_not_good',
			'req_reject',
			'req_dismantle',
			'req_revocation',
			'req_good_rec',
			'req_good_for_recond',

        ],
    ]) ?>



	<?php
	Pjax::begin(['id' => 'gridpjax', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']])
	// Pjax::begin()
	?>
	<?= GridView::widget([
        'id' => 'gridViewdetail',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

			'serial_number',
			'mac_address',
			[
				'attribute' => 'condition',
				'value' => function ($model){
					return ucwords($model->condition);
				},
				'filter' =>  [
						1 => 'Good',
						2 => 'Not Good',
						3 => 'Reject',
						4 => 'Dismantle',
						5 => 'Revocation',
						6 => 'Good Recondition',
						7 => 'Good for Recondition',
					],
			],

        ],
    ]); ?>
	<?php \yii\widgets\Pjax::end(); ?>

	<?php if (Yii::$app->controller->action->id == 'viewdetailsn'): ?>
	<p>
        <?= Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-success']) ?>
        <?= Html::button(Yii::t('app','Print'), ['id'=>'printSNButton','class' => 'btn btn-success']) ?>

    </p>
	<?php endif; ?>
</div>
<script>
	<?= '//'.basename(Yii::$app->request->referrer) ?>

	$('#printSNButton').click(function(){
		window.open("<?php echo Url::to([$this->context->id.'/exportsn', 'id' => $model->id]) ?>", "_blank");
	});

	$('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php
			if (basename(Yii::$app->request->referrer) == 'indexprintsj'){
				$url = 'view';
				$header = 'Create Surat Jalan';
			}else if (basename(Yii::$app->request->referrer) == 'indexapprove'){
				$url = 'viewapprove';
				$header = 'Approval Surat Jalan';
			}else{
				$url = 'create';
				$header = 'Create Tag SN';
			}
			echo Url::to(['outbound-wh-transfer/'.$url,'id'=>$model->id_outbound_wh]) ;?>');
        $('#modalHeader').html('<h3> <?= $header ?> </h3>');
    });
</script>
