<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\Reference;

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs(
"

", \yii\web\View::POS_END);
?>
<div class="instruction-wh-transfer-detail-index">

	<?php Pjax::begin([
			'id' => 'pjaxindexdetail',
			'timeout' => false,
			'enablePushState' => false,
			'clientOptions' => ['method' => 'GET'
			// , 'backdrop' => false
			],
		]); ?>
    <?= GridView::widget([
        'id' => 'gridViewindexdetail',
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'floatHeader'=>true,
		'floatOverflowContainer' => true,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'name',
				// 'value' => 'idMasterItemImDetail.idMasterItemIm.name',
				'value' => 'idMasterItemIm.name',
			],
			[
				'attribute' => 'id_item_im',
				// 'value' => 'idMasterItemImDetail.idMasterItemIm.im_code',
				'value' => 'idMasterItemIm.im_code',
			],
			[
				'attribute' => 'brand',
				// 'value' => 'idMasterItemImDetail.idMasterItemIm.brand',
				'value' => 'idMasterItemIm.referenceBrand.description',
			],
			'req_good',
			'req_not_good',
			'req_reject',
			'req_good_dismantle',
			'req_not_good_dismantle',
			[
				'attribute' => 'sn_type',
				// 'value' => 'idMasterItemImDetail.idMasterItemIm.referenceSn.description',
				'value' => 'idMasterItemIm.referenceSn.description',
				'filter' => ArrayHelper::map(Reference::find()->andWhere(['table_relation' => 'sn_type'])->all(), 'id_grouping', 'description'),
			],
			[
                'attribute' => 'status_listing',
                'format' => 'raw',
                'value' => function ($dataProvider) {
					if($dataProvider->status_listing == 999){
						return "<span class='label' style='background-color:{$dataProvider->statusReference->status_color}' >Not Yet Uploaded</span>";
					}else{
						return "<span class='label' style='background-color:{$dataProvider->statusReference->status_color}' >{$dataProvider->statusReference->status_listing}</span>";
					}
                },
				'visible' => $this->context->action->id == 'create',
            ],


        ],
    ]); ?>
	<?php yii\widgets\Pjax::end() ?>

</div>

<script>

    $('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id.'/update','id'=>Yii::$app->session->get('idInstWhTr')]) ;?>');
        $('#modalHeader').html('<h3> Detail Instruksi Warehouse Transfer </h3>');
    });

    $('.viewButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
        $('#modalHeader').html('<h3> '+ $(this).attr('header') +'</h3>');
    });

</script>
