<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;

use common\models\Reference;
use common\models\StatusReference;
use common\models\Division;

$this->title = Yii::t('app','Log GRF Instruction');
// if(Yii::$app->controller->action->id == 'index') 
// if(Yii::$app->controller->action->id == 'indexapprove') $this->title = Yii::t('app','Verify GRF Vendor IKO');

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@commonpath/js/popup_alert.js',['depends' => [\yii\web\JqueryAsset::className()]]);

function getFilterStatus() {
	if(Yii::$app->controller->action->id == 'indexlog')
        return ArrayHelper::map( statusReference::find()->andWhere(['id' => [47,53,43,1,2,3,4,5,6,13] ])->all(),'id','status_listing' ) ;
		// return [
		// 	1 => 'Inputted',
		// 	2 => 'Revised',
		// 	3 => 'Need Revise',
		// 	5 => 'Approved',
		// 	7 => 'Drafted',
		// 	47 => 'Report From WH',
		// 	13 => 'Deleted',
		// ];
	if(Yii::$app->controller->action->id == 'indexapprove')
		return [
			5 => 'Approved',
			1 => 'Inputted'
		];
	if(Yii::$app->controller->action->id == 'indexoverview'){
		$list = ArrayHelper::map( statusReference::find()->andWhere(['id' => [53,43,1,2,3,4,5,6,13] ])->all(),'id','status_listing' ) ;
        return $list;
	}
		
} ;
function getFilterRequestor(){
    $list = ArrayHelper::map(Reference::find()->where(['table_relation'=>'requestor'])->all(),'id','description');
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
            // if(Yii::$app->controller->action->id == 'index'){
				echo 'List Good Request Form';
			// };
            // if(Yii::$app->controller->action->id == 'indexapprove'){echo 'List Inbound PO Approval';};
        ?>
		</h3>
		<div class="row">
			<div class="col-sm-12">
				<p class="pull-right">
					
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
                         if(Yii::$app->controller->action->id == 'indexlog' && !isset($model->status_listing)){
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#viewlog?id='.$model->idlog.'&header=Detail_Good_Request_Form', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['instruction-grf/viewlog','id' => $model->idlog]), 'header'=> yii::t('app','Detail Good Request Form')  
                            ]);
                        } 
						else {                            
                            if(Yii::$app->controller->action->id == 'indexlog') $viewurl = 'viewlog';
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#'.$viewurl.'?id='.$model->idlog.'&header=Detail_Good_Request_Form', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['instruction-grf/'.$viewurl, 'id' => $model->idlog]), 'header'=> yii::t('app','Detail Good Request Form')  
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
                        return "<span class='label' style='background-color:red'>New Grf</span>";
                    }
                },
                'filter' => getFilterStatus()
            ],
            'grf_number',
            [   
                'attribute'=>'id_division',
                'label'=> 'Division',
                'value'=>'idGrf.idDivision.nama',
                'filter' => ArrayHelper::map( Division::find()->all(),'id','nama' ),
            ],
            [
               'attribute'=>'grf_type',
                'value'=>'idGrf.grfType.description',
                'filter' => ArrayHelper::map( Reference::find()->andWhere(['table_relation' => 'grf_type'])->all(),'id','description' ),
            ],
            'wo_number',
            [
                'attribute' => 'requestor',
                'value' => function($model){
                	if(is_numeric($model->requestor)){
                    	return $model->requestorName->description;
                	}
                },
                'filter' => getFilterRequestor(),
            ],

        ],
    ]); ?>
<?php Pjax::end(); ?></div>

<script>

</script>