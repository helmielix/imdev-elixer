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

$this->title = Yii::t('app', 'Warehouse Outbound Repair');
// if(Yii::$app->controller->action->id == 'index') 
// if(Yii::$app->controller->action->id == 'indexapprove') $this->title = Yii::t('app','Verify GRF Vendor IKO');

$this->registerJsFile('@commonpath/js/btn_modal.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/popup_alert.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

function getFilterStatus() {
    if (Yii::$app->controller->action->id == 'index')
        return [
            1 => 'Inputted',
            2 => 'Revised',
            3 => 'Need Revise',
            6 => 'Rejected',
            7 => 'Drafted'
        ];
    if (Yii::$app->controller->action->id == 'indexprintsj')
        return ArrayHelper::map(StatusReference::find()->andWhere(['id' => [42, 3, 22, 25]])->all(), 'id', 'status_listing');
    if (Yii::$app->controller->action->id == 'indexapproval')
        return ArrayHelper::map(StatusReference::find()->andWhere(['id' => [22, 5]])->all(), 'id', 'status_listing');
    // return [
    // 5 => 'Approved',
    // 4 => 'Verified'
    // ];
    if (Yii::$app->controller->action->id == 'indexoverview')
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

;
?>
<?php
Modal::begin([
    'header' => '<h3 id="modalHeader"></h3>',
    'id' => 'modal',
    'size' => 'modal-lg',
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
            if (Yii::$app->controller->action->id == 'index') {
                echo 'List Tag SN';
            };
            if (Yii::$app->controller->action->id == 'indexprintsj') {
                echo 'List Print Surat Jalan';
            };
            if (Yii::$app->controller->action->id == 'indexapproval') {
                echo 'List Approval Surat Jalan';
            };
            ?>
        </h3>

    </div>


    <?php Pjax::begin(['id' => 'pjax', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]) ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        /* if(Yii::$app->controller->action->id == 'index' && ($model->status_listing==999)){
                          return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-plus"></span>', '#create?id='.$model->id_instruction_repair.'&header=Create_Tag_SN', [
                          'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/create','id' => $model->id_instruction_repair]), 'header'=> yii::t('app','Create Tag SN') */
                        if (Yii::$app->controller->action->id == 'index' && !isset($model->status_listing)) {
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-plus"></span>', '#viewinstruction?id=' . $model->id_instruction_repair . '&header=Create_tag_SN', [
                                        'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value' => Url::to([$this->context->id . '/viewinstruction', 'id' => $model->id_instruction_repair]), 'header' => yii::t('app', 'Create Tag SN')
                            ]);
                        } else {
                            if (Yii::$app->controller->action->id == 'index') {
                                $viewurl = 'create';
                                $header = 'Create Tag SN';
                            }
                            if (Yii::$app->controller->action->id == 'indexprintsj') {
                                $viewurl = 'view';
                                $header = 'Create Surat Jalan';
                            }
                            if (Yii::$app->controller->action->id == 'indexapproval') {
                                $viewurl = 'viewapprove';
                                $header = 'Detail Print Surat Jalan';
                            }
                            if (Yii::$app->controller->action->id == 'indexoverview') {
                                $viewurl = 'viewoverview';
                            }

                            $headerlnk = str_replace(' ', '_', $header);
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#' . $viewurl . '?id=' . $model->id_instruction_repair .
                                            '&header=' . $headerlnk, [
                                        'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value' => Url::to([$this->context->id . '/' . $viewurl, 'id' => $model->id_instruction_repair]), 'header' => yii::t('app', $header)
                            ]);
                        }
                    },
                ],
            ],
            [
                'attribute' => 'status_listing',
                'format' => 'raw',
                'value' => function ($searchModel) {
//                        echo"<pre>"; print_r($searchModel);exit();

                    if ($searchModel->status_listing == 999 || !$searchModel->status_listing ) {
                        return "<span class='label' style='background-color:red'>New Instruction</span>";
                    } else {
//                        if ($searchModel->status_listing) {
                            return "<span class='label' style='background-color:{$searchModel->statusReference->status_color}' >{$searchModel->statusReference->status_listing}</span>";
//                        }else{
//                            return "<span class='label' >{$searchModel->status_listing}</span>";
//                
//                        }
                    }
                },
                'filter' => getFilterStatus()
            ],
            [
                'attribute' => 'no_sj',
                'label' => 'Nomor Surat Jalan',
                'visible' => $this->context->action->id == 'indexprintsj',
            ],
            [
                'attribute' => 'instruction_number',
                'label' => 'Nomor Instruksi',
            ],
            [
                'attribute' => 'target_pengiriman',
                'value' => 'target_pengiriman',
                'label' => 'Tanggal Pengiriman',
                'format' => 'date',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'target_pengiriman',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ]),
            ],
        /* [
          'attribute' => 'created_date',
          'value'  => 'created_date',
          'format' => 'datetime',
          'filter' => DatePicker::widget([
          'model' => $searchModel,
          'attribute' => 'created_date',
          'clientOptions' => [
          'autoclose' => true,
          'format' => 'yyyy-mm-dd',
          ],
          ]),
          ],
          [
          'attribute' => 'updated_date',
          'value'  => 'updated_date',
          'format' => 'datetime',
          'filter' => DatePicker::widget([
          'model' => $searchModel,
          'attribute' => 'updated_date',
          'clientOptions' => [
          'autoclose' => true,
          'format' => 'yyyy-mm-dd',
          ],
          ]),
          ], */
        ],
    ]);
    ?>
<?php Pjax::end(); ?></div>
