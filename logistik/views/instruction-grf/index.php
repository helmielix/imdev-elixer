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
use common\models\Region;

$this->title = Yii::t('app','Good Request Form');
// if(Yii::$app->controller->action->id == 'index') 
// if(Yii::$app->controller->action->id == 'indexapprove') $this->title = Yii::t('app','Verify GRF Vendor IKO');

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
// $this->registerJsFile('@commonpath/js/popup_alert.js',['depends' => [\yii\web\JqueryAsset::className()]]);

function getFilterStatus() {
    if(Yii::$app->controller->action->id == 'index'){
        $list = ArrayHelper::map( statusReference::find()->andWhere(['id' => [53,43,1,2,3,6] ])->all(),'id','status_listing' ) ;
        return $list;
    }        

    if(Yii::$app->controller->action->id == 'indexverify')
        return [
            1 => 'Inputted',
            2 => 'Revised',
            3 => 'Need Revise',
            4 => 'Verified',
            6 => 'Rejected',
            7 => 'Drafted'
        ];
        
    if(Yii::$app->controller->action->id == 'indexapprove')
        return [
            5 => 'Approved',
            1 => 'Inputted'
        ];
    if(Yii::$app->controller->action->id == 'indexoverview'){
        $list = ArrayHelper::map( statusReference::find()->andWhere(['id' => [53,43,1,2,3,4,5,6] ])->all(),'id','status_listing' ) ;
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
            // if(Yii::$app->controller->action->id == 'indexapprove'){echo 'List Instruction PO Approval';};
        ?>
        </h3>
        <div class="row">
            <div class="col-sm-12">
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
                         if((Yii::$app->controller->action->id == 'index' || Yii::$app->controller->action->id == 'indexoverview') && !isset($model->status_listing)){
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-plus"></span>', '#create?id='.$model->id.'&header=Detail_Good_Request_Form', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/create','id' => $model->id]), 'header'=> yii::t('app','GRF')
                            ]);
                        } 
                        else {
                            if(Yii::$app->controller->action->id == 'index') {
                                $viewurl = 'view';
                                $header = 'Detail Good Request Form';
                                if ($model->status_listing == 53) {
                                    $header = 'GRF';
                                }
                            }
                            if(Yii::$app->controller->action->id == 'indexoverview') {
                                $viewurl = 'viewoverview';
                                $header = 'Detail Good Request Form';
                            }

                            if(Yii::$app->controller->action->id == 'indexverify') {
                                $viewurl = 'viewverify';
                                $header = 'Verify';
                            }
        
                            if(Yii::$app->controller->action->id == 'indexapprove') {
                                $viewurl = 'viewapprove';
                                $header = 'Approval';
                            }
                            $headerlnk = str_replace(' ', '_', $header);
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#'.$viewurl.'?id='.$model->id.
                            '&header='.$headerlnk, [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/'.$viewurl, 'id' => $model->id]), 'header'=> yii::t('app',$header) 
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
                'attribute'=>'id_region',
                'label'=> 'Region',
                'value'=> function($model){
                    if (is_numeric(($model->id_region))) {
                        return Region::find()->andWhere(['id' => $model->id_region])->one()->name;
                    }
                },
                'filter' => ArrayHelper::map( Region::find()->all(),'id','name' ),
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
                    return $model->requestorName->description;
                },
                'filter' => getFilterRequestor(),
            ],
            // [
            //     'attribute' => 'pic',
            //     'value' => function($model){
            //         if($model->picName)
            //         return $model->picName->nama;
            //     }
            // ],
            
            

        ],
    ]); ?>
<?php Pjax::end(); ?></div>

<script>

</script>