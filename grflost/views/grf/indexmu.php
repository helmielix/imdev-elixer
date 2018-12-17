<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;
use common\models\StatusReference;


$this->title = Yii::t('app','Good Request Form');
// if(Yii::$app->controller->action->id == 'index') 
// if(Yii::$app->controller->action->id == 'indexapprove') $this->title = Yii::t('app','Verify GRF Vendor IKO');

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@commonpath/js/popup_alert.js',['depends' => [\yii\web\JqueryAsset::className()]]);

function getFilterStatus() {
    if(Yii::$app->controller->action->id == 'index')
        return [
            1 => 'Inputted',
            2 => 'Revised',
            3 => 'Need Revise',
            6 => 'Rejected',
            7 => 'Drafted'
        ];
        if(Yii::$app->controller->action->id == 'indexsn')
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
            1 => 'Inputted'
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
                <!-- <p class="pull-right">
                    <?php if (Yii::$app->controller->action->id == 'index') { ?>
                        <?=  Html::a('Create', '#create?header=Create Good Request Form', ['class' => 'btn btn-success', 'id' => 'createModal', 'value'=>Url::to(['grf/create']), 'header'=> yii::t('app','Create Good Request Form')]) ; ?>
                    <?php } ?>
                </p> -->
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
                        if(Yii::$app->controller->action->id == 'indexmr' && empty($model->qty_return)){
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-plus"></span>', '#createmr?id='.$model->id_instruction_grf.'&header=Create_Tag_SN', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/createmr','id' => $model->id_instruction_grf]), 'header'=> yii::t('app','Create Material Return Peminjaman')
                            ]);
                        } 
                        else {
                            if(Yii::$app->controller->action->id == 'indexmu' ) {
                                $viewurl = 'viewmr';
                                $header = 'Create Tag SN';
                            }
                            
                            $headerlnk = str_replace(' ', '_', $header);
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#'.$viewurl.'?id='.$model->id_instruction_grf.
                            '&header='.$headerlnk, [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/'.$viewurl, 'id' => $model->id_instruction_grf]), 'header'=> yii::t('app',$header) 
                                ]);
                        }
                    },
                ],
            ],
            [
                'attribute' => 'status_return',
                'format' => 'raw',
                'value' => function ($searchModel) {
                  if ($searchModel->qty_return != '') {
                        return "<span class='label' style='background-color:{$searchModel->statusListing->status_color}' >{$searchModel->statusListing->status_listing}</span>";
                    } else {
                        return "<span class='label' style='background-color:red'>New Received</span>";
                    }
                },
                'filter' => getFilterStatus()
            ],
            'grf_number',
            [
                'attribute' => 'wo_number',
                //'value' => 'whDestination.nama_warehouse'
                
            ],
            'pic',
            [
                'attribute' => 'id_division',
                'value'=>'idInstructionGrf.idGrf.idDivision.nama',
                // 'value' => function($model){
                // return $model->idInboundGrf->idGrf->idDivision->nama;
            // },
            ],
            [
            'attribute' => 'grf_type',
            'value'=>'idInstructionGrf.idGrf.grfType.description',
            ],
            // [   
            //     'attribute'=>'id_division',
            //     'label'=> 'Division',
            //     'value'=>'idGrf.idDivision.nama',
            // ],
            // [   'attribute'=>'grf_type',
            //     'value'=>'idGrf.grfType.description',
            // ],
            
            

        ],
    ]); ?>
<?php Pjax::end(); ?></div>

<script>

</script>