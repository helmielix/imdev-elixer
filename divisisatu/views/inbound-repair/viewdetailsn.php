<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

use common\models\Reference;
/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */

$this->title = $model->id_inbound_repair_detail;
$this->params['breadcrumbs'][] = ['label' => 'Inbound Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//print_r($model);
?>
<div class="outbound-repair-view">

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
			[
				'attribute' => 'id_item_im',
				'value' => function($model){
					return $model->item->name;
				},
				'label' => 'Nama Material'
			],
			[
				'label' => 'IM Code',
				'value' => function($model){
					return $model->item->im_code;
				},
			],
//			'req_good',
//			'req_not_good',
//			'req_reject',
//			'req_good_dismantle',
//			'req_not_good_dismantle',
            
        ],
    ]) ?>
	
	
	
	<?php 
	Pjax::begin(['id' => 'gridpjax', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]) 
	// Pjax::begin()
	?>
	<?= GridView::widget([
        'id' => 'gridViewdetail',
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            
			'serial_number',
			'mac_address',
//			'condition',
			
        ],
    ]); ?>
	<?php \yii\widgets\Pjax::end(); ?>
	
	<p>
        <?= Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-success']) ?>
    </p>
</div>
<script>
	<?= '//'.basename(Yii::$app->request->referrer) ?>
	
	$('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php 
			
				$url = 'createtag';
				$header = 'Create Tag SN';
			
			echo Url::to(['inbound-repair/'.$url,'id'=>$model->id_instruction_repair]) ;?>');
        $('#modalHeader').html('<h3> <?= $header ?> </h3>');
    });
</script>