<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;
use divisisatu\models\StatusReference;


/* @var $this yii\web\View */
/* @var $searchModel divisisatu\models\StockOpnameInternalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app','Stock Opname Internal');

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);

function getFilterStatus() {
	if(Yii::$app->controller->action->id == 'index')
		return [
			1 => 'Inputted',
			34 => 'On Progress',
		];
} ;
?>
<?php Modal::begin([
		'header'=>'<h3 id="modalHeader"></h3>',
		'id'=>'modal',
		'size'=>'modal-lg',
	]);

	echo '<div id="modalContent"> </div>';

	Modal::end();
?>
<div id="southPanel">

    <div id="southPanelHeader">
        <div class="panelZoomController">
            
        </div>
		<h3>
        <?php
			echo 'List Input Stock Opname Internal';
        ?>
		</h3>
		<div class="row">
			<div class="col-sm-12">
				<p class="pull-right">
					<?=  Html::a('Create', '#create?header=Create Stock Opname Internal', ['class' => 'btn btn-success', 'id' => 'createModal', 'value'=>Url::to(['stock-opname-internal/create']), 'header'=> yii::t('app','Create Stock Opname Internal')]) ; ?>
				</p>
			</div>
		</div>
		
    </div>

	
<?php Pjax::begin(['id' => 'pjax', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]) ?>
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
				'class' => 'yii\grid\ActionColumn',
				'template'=>'{view} {update}',
                'buttons'=>[
                    'view' => function ($url, $model) {
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#add-pic?id='.$model->id.'&header=Create Stock Opname Internal', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['stock-opname-internal/add-pic','id' => $model->id]), 'header'=> yii::t('app','Create Stock Opname Internal')  
                            ]);
					},
					'update' => function ($url, $model) {
						if($model->status_listing==1){
							return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>', '#view?id='.$model->id.'&header=Update Stock Opname Internal', [
								'title' => Yii::t('app', 'update'), 'class' => 'viewButton',  'value'=>Url::to(['stock-opname-internal/update','id' => $model->id]), 'header'=> yii::t('app','Update Stock Opname Internal')  
							]);
                        }
						else {
							return null;
						}
                    },
                ],
			],
			[
                'attribute' => 'status_listing',
				'format' => 'raw',
				'value' => function ($searchModel) {
                    return "<span class='label' style='background-color:"
                        . StatusReference::find()
                        ->where(['id' => $searchModel->status_listing])
                        ->one()
                        ->status_color
                        . "' >"
                        . StatusReference::find()
                        ->where(['id' => $searchModel->status_listing])
                        ->one()
                        ->status_listing
                        . "</span>";
                    },
                'filter' => getFilterStatus()
            ],
            'stock_opname_number',
            [
				'attribute' => 'cut_off_data_date',
				'value'  => 'cut_off_data_date',
				'format' => 'datetime',
				'filter' => DatePicker::widget([
					'model' => $searchModel,
					'attribute' => 'cut_off_data_date',
					'clientOptions' => [
						'autoclose' => true,
						'format' => 'yyyy-mm-dd',
					],
				]),
			],
			[
				'attribute' => 'start_date',
				'value'  => 'start_date',
				'format' => 'datetime',
				'filter' => DatePicker::widget([
					'model' => $searchModel,
					'attribute' => 'start_date',
					'clientOptions' => [
						'autoclose' => true,
						'format' => 'yyyy-mm-dd',
					],
				]),
            ],
            [
				'attribute' => 'end_date',
				'value'  => 'end_date',
				'format' => 'datetime',
				'filter' => DatePicker::widget([
					'model' => $searchModel,
					'attribute' => 'start_date',
					'clientOptions' => [
						'autoclose' => true,
						'format' => 'yyyy-mm-dd',
					],
				]),
			],
            [
				'class' => 'yii\grid\ActionColumn',
				'template'=>'{delete}',
                'buttons'=>[
                    'delete' => function ($url, $model) {
                        return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
							// 'class' => 'btn btn-danger',
							'data' => [
								'confirm' => 'Are you sure you want to delete this item?',
								'method' => 'post',
							],
						]);
                    },
                ],
			],

        ],
    ]); ?>
<?php Pjax::end(); ?></div>

<script>

</script>