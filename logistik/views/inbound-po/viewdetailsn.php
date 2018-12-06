<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

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
            // 'id',
			[
				'attribute' => 'id_item_im',
				'value' => function($model){
					return $model->itemIm->name;
				},
				'label' => 'Nama Barang'
			],
			[
				'label' => 'IM Code',
				'value' => function($model){
					return $model->itemIm->im_code;
				},
			],
			[
				'attribute' => 'grouping',
				'value' => function($model){
					return $model->itemIm->referenceGrouping->description;
				}
			],
			[
				'attribute' => 'brand',
				'value' => function($model){
					return $model->itemIm->referenceBrand->description;
				}
			],
			[
				'attribute' => 'warna',
				'label' => 'Color',
				'value' => function($model){
					return $model->itemIm->referenceWarna->description;
				}
			],
			[
				'attribute' => 'type',
				'value' => function($model){
					return $model->itemIm->referenceType->description;
				}
			],
			'qty',
            
        ],
    ]) ?>
	
	
	
	<?php 
	Pjax::begin(['id' => 'gridpjax', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]) 
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
			'condition',
			
			
        ],
    ]); ?>
	<?php \yii\widgets\Pjax::end(); ?>
	
	<p>
        <?= Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-success']) ?>
    </p>
</div>
<script>
	$('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['inbound-po/viewsn','id'=>$model->id_inbound_po]) ;?>');
        $('#modalHeader').html('<h3> Create Inbound PO </h3>');
    });
</script>