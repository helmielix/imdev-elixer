<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;

use common\models\Reference;
/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */

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
                    // return $model->idItemIm->idMasterItemIm->name;
					return $model->idItemIm->name;
				},
				'label' => 'Nama Material'
			],
			[
				'label' => 'IM Code',
				'value' => function($model){
                    // return $model->idItemIm->idMasterItemIm->im_code;
					return $model->idItemIm->im_code;
				},
			],
			'qty',

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
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

			'serial_number',
			'mac_address',
			[
				'attribute' => 'condition',
				'value' => function ($searchModel){
					return ucwords($searchModel->condition);
				},
				'filter' => ArrayHelper::map( Reference::find()->andWhere(['table_relation' => [ 'good_type', 'dismantle_type' ]])->all(), 'description', 'description' ),
			],


        ],
    ]); ?>
	<?php \yii\widgets\Pjax::end(); ?>

	<p>
        <?= Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-success']) ?>
    </p>
</div>
<script>
	$('#previousButton').click(function () {
		var button = $(this);
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
        
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['inbound-wh-transfer/viewtagsn','id'=>$model->id_inbound_wh]) ;?>');
        $('#modalHeader').html('<h3> Create Tag SN </h3>');
    });
</script>
