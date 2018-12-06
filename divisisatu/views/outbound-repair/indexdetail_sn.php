<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->registerJsFile('@commonpath/js/btn_modal.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs("", \yii\web\View::POS_END);
//echo $this->context->action->id;

?>
<div class="instruction-wh-transfer-detail-index">

    <?php
    Pjax::begin([
        'id' => 'pjaxindexdetail',
        'timeout' => false,
        'enablePushState' => false,
        'clientOptions' => ['method' => 'POST'
        // , 'backdrop' => false
        ],
    ]);
    ?>
    <?=
    GridView::widget([
        'id' => 'gridViewindexdetail',
        'dataProvider' => $dataProvider,
        'floatHeader' => true,
        'floatOverflowContainer' => true,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Nama Barang',
                'value' => 'idMasterItemIm.name'
            ],
            [
                'label' => 'IM Code',
                'value' => 'idMasterItemIm.im_code'
            ],
            [
                'label' => 'Brand',
                'value' => 'idMasterItemIm.brand'
            ],
            [
                'label' => 'Req.Reject',
                'value' => 'req_reject'
            ],
            // 'req_reject',
            [
                'label' => 'SN/Non',
                'value' => 'idMasterItemIm.referenceSn.description'
            ],
            [
                'label' => 'Status',
                'value' => function ($dataProvider) {
                    if ($dataProvider->status_listing === 41 || $dataProvider->idMasterItemIm['sn_type'] === 2) {
                        return 'Registered';
                    } else {
                        return 'Not Registered';
                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{create} {view} {restore}',
                'buttons' => [
                    // 'recond' => function ($url, $model) {
                    //                    if($model->idMasterItemIm->sn_type == 2){
                    //                        return Html::a('<span style="margin:0px 2px;" class="label label-success">Qty Recond</span>', '#', [
                    //                            'title' => Yii::t('app', 'upload'), 'class' => 'viewButton', 'value'=> Url::to([$this->context->id.'/addqtyrecond', 'idOutboundRepairDetail' => $model->id, 'idItem' => $model->id_item_im]), 'header'=> yii::t('app','Add Qty Recondition')
                    //                        ]);
                    //                    }
                    //                },
                    'restore' => function ($url, $model) {
                        if ($model->status_listing == 42 && $model->idMasterItemIm['sn_type'] !== 2 || ($model->status_listing == 41 && $this->context->action->id=="create")) {
                            return Html::a('<span style="margin:0px 2px;" class="label label-danger">Reset SN</span>', '#', [
                                        'title' => Yii::t('app', 'reset'), 'class' => 'viewButton', 'value' => Url::to([$this->context->id . '/restoresn', 'idOutboundRepairDetail' => $model->id, 'idItem' => $model->id_item_im]), 'header' => yii::t('app', 'Restore')
                            ]);
                        }
                    },
                    'view' => function ($url, $model) {
                        if ($model->status_listing == 42 || $model->status_listing == 43 || $model->status_listing == 41) {

                            return Html::a('<span style="margin:0px 2px;" class="label label-info">View</span>', '#', [
                                        'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value' => Url::to([$this->context->id . '/viewdetailsn', 'idOutboundRepairDetail' => $model->id]), 'header' => yii::t('app', 'Detail Serial Number')
                            ]);
                        }
                    },
                    'create' => function ($url, $model) {
                        if (($model->status_listing == 999 || $model->status_listing == 43) && $model->idMasterItemIm->sn_type != 2) {
                            return Html::a('<span style="margin:0px 2px;" class="label label-success">Upload SN</span>', '#', [
                                        'title' => Yii::t('app', 'upload'), 'class' => 'viewButton', 'value' => Url::to([$this->context->id . '/uploadsn', 'id' => $model->id, 'idOutboundRepair' => $model->id_outbound_repair]), 'idOutboundRepair' => $model->id_outbound_repair, 'header' => yii::t('app', 'Create Tag SN')
                            ]);
                        }
                    },
                ],
            ],
        ],
    ]);
    ?>
    <?php yii\widgets\Pjax::end() ?>
    <p>        
    <?php
    if (Yii::$app->controller->action->id == 'indexdetail')
        echo Html::button(Yii::t('app', 'Previous'), ['id' => 'previousButton', 'class' => 'btn btn-success']);
    switch (Yii::$app->controller->action->id) {
        case 'create':
            $actionName = 'Submit SN';
            $idbutton = 'submitButton';
            $actionName2 = 'Report To IC';
            $idbutton2 = 'reportButton';
            echo Html::button(Yii::t('app', $actionName2), ['id' => $idbutton, 'class' => 'btn btn-warning']);
            echo Html::button(Yii::t('app', $actionName), ['id' => $idbutton, 'class' => 'btn btn-success', 'style' => 'margin: 4px']);
            break;
        case 'view':
            if($model->status_listing!=22){
            $actionName = 'Submit';
            $idbutton = 'submitSjButton';
            echo Html::button(Yii::t('app', $actionName), ['id' => $idbutton, 'class' => 'btn btn-success']);
            break;
            }else{
//                 $actionName = 'Approve';
//            $idbutton = 'approveButton';
//            $actionName2 = 'Revise';
//            $idbutton2 = 'reviseButton';
//            echo Html::button(Yii::t('app', $actionName2), ['id' => $idbutton, 'class' => 'btn btn-warning']);
//            echo Html::button(Yii::t('app', $actionName), ['id' => $idbutton, 'class' => 'btn btn-success', 'style' => 'margin: 4px']);
            break;
            }
    }
    ?>


    </p>
</div>

<script>

    $('#previousButton').click(function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load('<?php echo Url::to([$this->context->id . '/update', 'id' => Yii::$app->session->get('idInstRep')]); ?>');
        $('#modalHeader').html('<h3> Detail Instruksi Warehouse Transfer </h3>');
    });

    $('#submitButton').click(function () {
        var button = $(this);
        button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

        $('#modal').modal('hide').delay(1500);

        // $.ajax({
        // url: '<?php echo Url::to([$this->context->id . '/submit', 'id' => Yii::$app->session->get('idInstRep')]); ?>',
        // type: 'post',
        // processData: false,
        // contentType: false,
        // success: function (response) {
        // if(response == 'success') {
        // $('#modal').modal('hide');
        // } else {
        // alert('error with message: ' + response.pesan);
        // }
        // },
        // error: function (xhr, getError) {
        // if (typeof getError === "object" && getError !== null) {
        // error = $.parseJSON(getError.responseText);
        // getError = error.message;
        // }
        // if (xhr.status != 302) {
        // alert("System recieve error with code: "+xhr.status);
        // }
        // },
        // complete: function () {
        // button.prop('disabled', false);
        // $('#spinRefresh').remove();
        // },
        // });
    });

    $('#submitSjButton').click(function () {
        var button = $(this);
        button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
        data = new FormData();

        data.append('OutboundRepair[forwarder]', $('#outboundrepair-forwarder').val());
        data.append('OutboundRepair[plate_number]', $('#outboundrepair-plate_number').val());
        data.append('OutboundRepair[driver]', $('#outboundrepair-driver').val());
        data.append('file', $('#outboundrepair-file_attachment')[0].files[0]);
        // $('#modal').modal('hide').delay(1500);

        $.ajax({
            url: '<?php echo Url::to([$this->context->id . '/submitsj', 'id' => $model->id_instruction_repair]); ?>',
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response == 'success') {
                    $('#modal').modal('hide');
                } else {
                    alert('error with message: ' + response.pesan);
                }
            },
            error: function (xhr, getError) {
                if (typeof getError === "object" && getError !== null) {
                    error = $.parseJSON(getError.responseText);
                    getError = error.message;
                }
                if (xhr.status != 302) {
                    alert("System recieve error with code: " + xhr.status);
                }
            },
            complete: function () {
                button.prop('disabled', false);
                $('#spinRefresh').remove();
            },
        });
    });

    $('.viewButton').click(function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        $('#modalHeader').html('<h3> ' + $(this).attr('header') + '</h3>');
    });

</script>
