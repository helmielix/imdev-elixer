<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

use common\models\Reference;
/* @var $this yii\web\View */
/* @var $model Instruction\models\InstructionGrf */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instruction Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outbound-wh-transfer-view">

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
			[
				'attribute' => 'im_code',
				'value' => function($model){
					return $model->idOutboundGrf->idInstructionGrf->idGrf->idGrfDetail->idOrafinCode->im_code;
				},
				
			],
			[
				'attribute' => 'im_code',
				'value' => function($model){
					return $model->idOutboundGrf->idInstructionGrf->idGrf->idGrfDetail->idOrafinCode->name;
				},
				
			],
			'qty_good',
			'qty_noot_good',
			'qty_reject',
			'qty_dismantle_good',
			'qty_dismantle_ng',
			'qty_good_rec',
            
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
            
			[
				'attribute'=>'serial_number',
			],
			'mac_address',
			[
				'attribute' => 'condition',
			],
			
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
			echo Url::to(['outbound-grf/'.$url,'id'=>$model->id_outbound_grf]) ;?>');
        $('#modalHeader').html('<h3> <?= $header ?> </h3>');
    });
</script>