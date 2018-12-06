<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;

$this->title = Yii::t('app', 'Repair Instruction');
// if(Yii::$app->controller->action->id == 'index')
// if(Yii::$app->controller->action->id == 'indexapprove') $this->title = Yii::t('app','Verify GRF Vendor IKO');

$this->registerJsFile('@commonpath/js/btn_modal.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

// $this->registerJsFile('@commonpath/js/popup_alert.js',['depends' => [\yii\web\JqueryAsset::className()]]);

function getFilterStatus() {
    if (Yii::$app->controller->action->id == 'index')
        return [
            1 => 'Inputted',
            2 => 'Revised',
            3 => 'Need Revise',
            6 => 'Rejected',
            7 => 'Drafted'
        ];
    if (Yii::$app->controller->action->id == 'indexapprove')
        return [
            5 => 'Approved',
            1 => 'Inputted'
        ];
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
};
?>
<?php
    Modal::begin(['header' => '<h3 id="modalHeader"></h3>', 'id' => 'modal', 'size' => 'modal-lg']);
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
                echo 'List Input Repair Instruction';
                // };
                // if(Yii::$app->controller->action->id == 'indexapprove'){echo 'List Inbound PO Approval';};
            ?>
        </h3>
        <div class="row">
            <div class="col-sm-12">
                <p class="pull-left">
                    <?php if (Yii::$app->controller->action->id == 'index') { ?>
                        <?= Html::a('Create', '#create?header=Create Repair Instruction', ['class' => 'btn btn-success', 'id' => 'createModal', 'value' => Url::to(['instruction-repair/create']), 'header' => yii::t('app', 'Create Repair Instruction')]); ?>
                    <?php } ?>
                </p>
            </div>
        </div>

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
                'template' => '{view} {update}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        if ($model->status_listing == 3 || $model->status_listing == 7 || $model->status_listing == 50) {
                            /* return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#view?id=' . $model->id . '&header=Detail_Repaire_Instruction', ['title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value' => Url::to(['instruction-repair/view', 'id' => $model->id]), 'header' => yii::t('app', 'Detail Repaire Instruction')]).' '.*/
                            return Html::a(
                                '<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>',
                                '#view?id='.$model->id.'&header=Update_Detail_Repair_Instruction', //update
                                [
                                    'title' => Yii::t('app', 'update'),
                                    'class' => 'viewButton',
                                    'value' => Url::to(['instruction-repair/update', 'id'=> $model->id]),
                                    'header'=> yii::t('app','Update Repair Instruction')
                                ]);
                        }
                    },
                    'view' => function ($url, $model) {
                        if (Yii::$app->controller->action->id == 'index' && isset($model->status_listing)) {

                            if ($model->status_listing != 50) {

                                return Html::a(
                                    '<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>',
                                    '#view?id=' . $model->id . '&header=Detail_Repair_Instruction',
                                    [
                                        'title' => Yii::t('app', 'view'),
                                        'class' => 'viewButton',
                                        'value' => Url::to(['instruction-repair/view', 'id' => $model->id]), //view
                                        'header' => yii::t('app', 'Detail Repair Instruction')
                                    ]);

                            }

                        } else {
                            if (Yii::$app->controller->action->id == 'index')
                                $viewurl = 'view';
                            if (Yii::$app->controller->action->id == 'indexapprove')
                                $viewurl = 'viewapprove';
                            if (Yii::$app->controller->action->id == 'indexoverview')
                                $viewurl = 'viewoverview';
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#' . $viewurl . '?id=' . $model->id . '&header=Detail_Repaire_Instruction', [
                                        'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value' => Url::to(['instruction-repair/' . $viewurl, 'id' => $model->id]), 'header' => yii::t('app', 'Detail Repair Instruction') // Detail Inbound PO
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
            // 'id_warehouse',
            'instruction_number',
            [
                'attribute' => 'target_pengiriman',
                'value' => 'target_pengiriman',
                'format' => 'datetime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'target_pengiriman',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ]),
            ],
            [
                'attribute' => 'vendor_repair',
                'value' => 'idVendor.name',
            ],
        // [
        //         'attribute'=>'id_warehouse',
        //         'value'=>'idWarehouse.nama_warehouse',
        // ],
        ],
    ]);
    ?>
<?php Pjax::end(); ?></div>

<script>

</script>
