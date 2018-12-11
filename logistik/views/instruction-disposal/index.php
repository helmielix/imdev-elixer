<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchInstructionDisposal */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Instruction Disposals';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/popup_alert.js',['depends' => [\yii\web\JqueryAsset::className()]]);

function getFilterStatus() {
	if(Yii::$app->controller->action->id == 'index')
		return [
			1 => 'Inputted',
			2 => 'Revised',
			3 => 'Need Revise',
			6 => 'Rejected',
			7 => 'Drafted'
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
?>

<?php Modal::begin([
    'header'=>'<h3 id="modalHeader"></h3>',
    'id'=>'modal',
    'size'=>'modal-lg'
  ]);

  echo '<div id="modalContent"> </div>';

  Modal::end();
?>
<div class="instruction-disposal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
      <div class="col-sm-12">
        <p class="">
          <?php if (Yii::$app->controller->action->id == 'index') { ?>
            <?=  Html::a('Create', '#create?header=Create', ['class' => 'btn btn-success', 'id' => 'createModal', 'value'=>Url::to(['instruction-disposal/create']), 'header'=> yii::t('app','Create')]) ; ?>
          <?php } ?>
        </p>
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
				'template'=>'{view} {update} ',
                'buttons'=>[
                    'view' => function ($url, $model) {
                         if(Yii::$app->controller->action->id == 'index' && isset($model->status_listing)){
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#view?id='.$model->id.'&header=Detail_Instruction_Disposal', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['instruction-disposal/view','id' => $model->id]), 'header'=> yii::t('app','Detail Instruction Disposal')
                            ]);
                        } 
						else {
                            if(Yii::$app->controller->action->id == 'index') $viewurl = 'view';
                            if(Yii::$app->controller->action->id == 'indexapprove') $viewurl = 'viewapprove';
                            if(Yii::$app->controller->action->id == 'indexoverview') $viewurl = 'viewoverview';
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#'.$viewurl.'?id='.$model->id.'&header=Detail_Material_GRF_Vendor_IKO', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['instruction-disposal/'.$viewurl, 'id' => $model->id]), 'header'=> yii::t('app','Detail Inbound PO')
                                ]);
                        }
                    },
                    'update' => function ($url, $model) {
                        if(Yii::$app->controller->action->id == 'index' && isset($model->status_listing)){
                            if($model->status_listing != 6)
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>', '#update?id='.$model->id.'&header=Update_Instruction_Disposal:_', [
                                'title' => Yii::t('app', 'update'), 'class' => 'viewButton', 'value'=>Url::to(['instruction-disposal/update', 'id'=> $model->id]), 'header'=> yii::t('app','Update Instruction Disposal')
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
            //'instruction_number',
            'no_iom',
             [
                'attribute' => 'date_iom',
                'value'  => 'date_iom',
                'format' => 'datetime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_iom',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ]),
            ],
            'id_warehouse',
			
            // 'buyer',
            // 'created_date',
            // 'updated_date',
            // 'target_implementation',
            // 'revision_remark:ntext',
            // 'id_modul',
            // 'id',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
