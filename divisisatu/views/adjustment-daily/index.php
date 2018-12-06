<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;
use common\models\StatusReference;

$this->title = Yii::t('app','Adjustment Daily');
// if(Yii::$app->controller->action->id == 'index')
// if(Yii::$app->controller->action->id == 'indexapprove') $this->title = Yii::t('app','Verify GRF Vendor IKO');

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/popup_alert.js',['depends' => [\yii\web\JqueryAsset::className()]]);
//echo "<pre>";print_r($searchModel->all());exit();
//echo $this->context->action->id;
function getFilterStatus() {
    if(Yii::$app->controller->action->id == 'index')
        return [
            1 => 'Inputted',
            2 => 'Revised',
            3 => 'Need Revise',
            6 => 'Rejected',
            7 => 'Drafted'
        ];
    if(Yii::$app->controller->action->id == 'indexprintsj')
        return ArrayHelper::map(StatusReference::find()->andWhere(['id' => [42, 3, 22, 25]])->all(), 'id', 'status_listing');
    // return [
    // 5 => 'Approved',
    // 4 => 'Verified'
    // ];
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
        <h3>Adjustment Daily</h3>

    </div>
  <?php
  if($this->context->action->id!="indexadjust"){
  echo Html::a('Create','#create?header=Create_Adjustment_Daily',['id'=>'createModal','class' => 'btn btn-success',
        'value' => Url::to(['adjustment-daily'.'/'.'create']), 'header'=> yii::t('app','Create Adjustment Daily')]);
  }
  ?>
    
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
                        $header = 'Adjustment Daily';
                        $headerlnk = str_replace(' ', '_', $header);
                        return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#'.'view'.'?id='.$model->id_adjustment.
                            '&header='.$headerlnk, [
                            'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/'.'view','id' => $model->id_adjustment]), 'header'=> yii::t('app',$header)
                        ]);
                    }
                ]
            ],
            [
                'attribute' => 'status_listing',
                'format' => 'raw',
                'value' => function ($searchModel) {
                    if ($searchModel->statusReference->status_listing) {
                        return "<span class='label' style='background-color:{$searchModel->statusReference->status_color}' >{$searchModel->statusReference->status_listing}</span>";
                    } else {
                        return "<span class='label' style='background-color:red'>New Instruction</span>";
                    }
                },
                'filter' => getFilterStatus()
            ],
            [
                'attribute' => 'no_adj',
                'label' => 'No. Adjustment Daily',
                /*'value' => function($model) {
                    return '123';
                }*/
                //'visible' => $this->context->action->id == 'indexprintsj',
            ],
            [
                'attribute' => 'no_sj',
                'label' => 'Nomor Surat Jalan',
                /*'value' => function($model) {
                    return '345';
                }*/
                //'visible' => $this->context->action->id == 'indexprintsj',
            ],
        ]
    ]); ?>

    <?php Pjax::end(); ?></div>
