<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;

use common\models\Reference;

$this->title = Yii::t('app','Good Request Form');
// if(Yii::$app->controller->action->id == 'index') 
// if(Yii::$app->controller->action->id == 'indexapprove') $this->title = Yii::t('app','Verify GRF Vendor IKO');

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@commonpath/js/popup_alert.js',['depends' => [\yii\web\JqueryAsset::className()]]);

function getFilterStatus() {
	if(Yii::$app->controller->action->id == 'indexothers')
        return [
            1 => 'Inputted',
            2 => 'Revised',
            3 => 'Need Revise',
            6 => 'Rejected',
            7 => 'Drafted',
        ];
    if(Yii::$app->controller->action->id == 'indexverify')
        return [
            1 => 'Inputted',
            2 => 'Revised',
            4 => 'Verified',
        ];
    if(Yii::$app->controller->action->id == 'indexapprove')
        return [
            5 => 'Approved',
            4 => 'Verified'
        ];
	if(Yii::$app->controller->action->id == 'indexoverview')
		return [
			1 => 'Inputted',
			2 => 'Revised',
			3 => 'Need Revise',
			39 => 'Need Revise by IM',
			5 => 'Approved',
			4 => 'Verified',
			6 => 'Rejected',
		];
} ;

function getFilterGrf(){
    $list = ArrayHelper::map(Reference::find()->where(['table_relation'=>'grf_type'])->all(),'id', 'description');
    return $list;
}
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
            if(Yii::$app->controller->action->id == 'indexothers')echo 'List Input Good Request Form';
            if(Yii::$app->controller->action->id == 'indexothersverify')echo 'List Verification Good Request Form';
            if(Yii::$app->controller->action->id == 'indexothersapprove')echo 'List Approval Good Request Form';
			// };
            // if(Yii::$app->controller->action->id == 'indexapprove'){echo 'List Inbound PO Approval';};
        ?>
		</h3>
		<div class="row">
			<div class="col-sm-12">
				<p>
					<?php if (Yii::$app->controller->action->id == 'indexothers') { ?>
						<?=  Html::a('Create', '#create?header=Create Good Request Form', ['class' => 'btn btn-success', 'id' => 'createModal', 'value'=>Url::to(['grf/createothers']), 'header'=> yii::t('app','Create Good Request Form')]) ; ?>
					<?php } ?>
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
				'template'=>'{view}',
                'buttons'=>[
                    'view' => function ($url, $model) {
                         if(Yii::$app->controller->action->id == 'indexothers' && !isset($model->status_listing)){
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#view?id='.$model->id.'&header=Detail_Material_GRF_Vendor_IKO', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['grf/view','id' => $model->id]), 'header'=> yii::t('app','Detail Material GRF Vendor IKO')  
                            ]);
                        } 
						else {
                            if(Yii::$app->controller->action->id == 'indexothers') $viewurl = 'viewothers';
                            if(Yii::$app->controller->action->id == 'indexothersverify') $viewurl = 'viewothersverify';
                            if(Yii::$app->controller->action->id == 'indexothersapprove') $viewurl = 'viewothersapprove';
                            if(Yii::$app->controller->action->id == 'indexothersoverview') $viewurl = 'viewoverview';
                             return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#'.$viewurl.'?id='.$model->id.'&header=Detail_Grf', [
                                        'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['grf/'.$viewurl, 'id' => $model->id]), 'header'=> yii::t('app','Detail Busdev Pre-Survey')
               
                                ]);
                        }
                    },
                ],
			],
			[
                'attribute' => 'status_listing',
                'format' => 'raw',
                'value' => function ($searchModel) {
                    if ($searchModel->status_listing) {
                        return "<span class='label' style='background-color:{$searchModel->statusReference->status_color}' >{$searchModel->statusReference->status_listing}</span>";
                    } else {
                        return "<span class='label' style='background-color:grey'>Open RR</span>";
                    }
                },
                'filter' => getFilterStatus()
            ],
            'grf_number',
            [
                'attribute' => 'grf_type',
                'value' => function($model){
                    return $model->grfType->description;
                },
                'filter' => getFilterGrf(),
            ],
            [
            	'attribute' => 'wo_number',
            	//'value' => 'whDestination.nama_warehouse'
            	
            ],
            
            

        ],
    ]); ?>
<?php Pjax::end(); ?></div>

<script>

</script>