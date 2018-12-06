<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\OutboundRepairTransfer */

$this->registerJsFile('@commonpath/js/btn_modal.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/popup_alert.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

// MASIH ADA YANG HARUS DIUBAH!!! <CHG>

/* $this->title = $model->id_instruction_repair;
  $this->params['breadcrumbs'][] = ['label' => 'Outbound Wh Transfers', 'url' => ['index']];
  $this->params['breadcrumbs'][] = $this->title; */
//$model = ["title" => 12]

function getSNType() {
    return [1 => 'SN', 2 => "Non SN"];
}

function getStatus() {
    return [41 => 'Registered', 44 => "Not Register"];
}
?>

<div>
    <?php
    Modal::begin([
        'header' => '<h4>Modal SN</h4>',
        'id' => 'modal2',
        'size' => 'modal-lg',
    ]);

    echo "<div id='modalContent2'></div>";

    echo '<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>';

    Modal::end();
    ?>
</div>

<div>
    <?php
    Modal::begin([
        'header' => '<h4>Modal SN</h4>',
        'id' => 'modalSN',
        'size' => 'modal-lg',
    ]);

    echo "<div id='modalContentSN'></div>";

    echo '<div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>';

    Modal::end();
    ?>
</div>

<div class="row">
    <div class="col-sm-6">

        <?=
        DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'small table table-striped table-bordered detail-view'],
            'attributes' => [
                [
                    'attribute' => 'instruction_number',
                    'label' => 'Nomor Instruksi',
                //'value' => '001/INST',
                ],
                [
                    'attribute' => 'target_pengiriman',
                    'label' => 'Tanggal Pengiriman',
                //'value' => '20 Juli 2018',r
                ],
                [
                    'label' => 'Warehouse',
                    'value' => 'Jakarta',
                ],
                [
                    'attribute' => 'name',
                    'label' => 'Vendor Repair',
                //'value' => 'Makmur',
                ],
                [
                    'attribute' => 'tanggal_datang',
                //'label' => 'Tanggal Datang',
                //'value' => '20 Juli 2018',
                ]
            ]
        ]);
        ?>

    </div>
</div>

<div class="row">
    <div class="col-sm-offset-7">
        <label>Mac Address
            <?= Html::checkBox('macAddressCheckbox', '', ['id' => 'checkboxMacaddr']) ?>
        </label>

        <?php
        echo Html::a('Download Template', 'download?action=nomac', ['id' => 'downloadTemplate', 'class' => 'btn btn-success',
            'title' => Yii::t('app', 'Download Template'), 'value' => Url::to([$this->context->id . '/' . 'download', 'action' => 'nomac'])
        ]);
        ?>
        <?php echo Html::button(Yii::t('app', 'Print Instruction'), ['id' => 'instructionButton', 'class' => 'btn btn-primary btn-sm']); ?>
    </div>
</div>

<?php Pjax::begin(['id' => 'pjax', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]) ?>

<div class="row">
    <?=
    GridView::widget([
        'id' => 'gridViewindexdetail',
        'dataProvider' => $dataProvider,
        'floatHeader' => true,
        'floatOverflowContainer' => true,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            [
                'format' => 'raw',
                'label' => '',
                'value' => function ($model) {
                    return Html::hiddenInput('st[]', $model->status, ["class" => "valst"]);
                },
            ],
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'label' => 'Nama Barang',
            //'value' => 'item.im_code',
            /* 'value' => function($model) {
              return ['STB', 'OTB'];
              } */
            ],
            [
                'attribute' => 'im_code',
                'label' => 'IM Code',
            //'value' => 'item.im_code',
            /* 'value' => function($model) {
              return ['STB', 'OTB'];
              } */
            ],
            [
                'attribute' => 'brand',
                'label' => 'Brand',
            //'value' => 'item.im_code',r
            /* 'value' => function($model) {
              return ['STB', 'OTB'];
              } */
            ],
            [
                'attribute' => 'req_qty',
                'label' => 'QTY Req',
            //'value' => 'item.im_code',
            /* 'value' => function($model) {
              return ['STB', 'OTB'];
              } */
            ],
            [
                'attribute' => 's_good',
                'label' => 'QTY Good',
            //'value' => 'item.im_code',
            /* 'value' => function($model) {
              return ['STB', 'OTB'];
              } */
            ],
            [
                'attribute' => 's_reject',
                'label' => 'QTY Reject',
            //'value' => 'item.im_code',
            /* 'value' => function($model) {
              return ['STB', 'OTB'];
              } */
            ],
            [
                'attribute' => 'sn_type',
                'label' => 'SN/Non',
                'value' => function ($model) {
                    if ($model->sn_type == 1) {
                        return 'SN';
                    } else {
                        return 'Non SN';
                    }
                },
            //'value' => 'item.im_code',
            /* 'value' => function($model) {
              return ['STB', 'OTB'];
              } */
            ],
            [
                'attribute' => 'status',
                'label' => 'Status',
                'value' => function ($model) {
                    if ($model->status == 41) {
                        return 'Registered';
                    } else {
                        return 'Not Register';
                    }
                },
            ],
            [
                'label' => '',
                'format' => 'html',
                'value' => function($model) {

                    if (strcasecmp("registered", $model->status) == 0) {
                        return Html::a('Restore', '', ['class' => 'btn btn-danger',
                                    'title' => Yii::t('app', 'Restore'), 'value' => Url::to([$this->context->id . '/' . 'view'])
                        ]);
                    } else {
                        return '<span></span>';
                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{create} {view} {restore}',
                'buttons' => [
                    'restore' => function ($url, $model) {
                        if ($model->status == 41) {
                            return Html::a('<span style="margin:0px 2px;" class="label label-danger">Reset SN</span>', '#', [
                                        'title' => Yii::t('app', 'reset'), 'class' => 'viewButton', 'value' => Url::to([$this->context->id . '/restoresn', 'idOutboundRepairDetail' => $model->id_inbound_repair_detail, 'idItem' => $model->id_barang]), 'header' => yii::t('app', 'Restore')
                            ]);
                        }
                    },
                    'view' => function ($url, $model) {
                        if ($model->status == 41) {

                            return Html::a('<span style="margin:0px 2px;" class="label label-info">View</span>', '#', [
                                        'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value' => Url::to([$this->context->id . '/viewdetailsn', 'idInboundRepairDetail' => $model->id_inbound_repair_detail]), 'header' => yii::t('app', 'Detail Serial Number')
                            ]);
                        }
                    },
                    'create' => function ($url, $model) {
//                        print_r($model);
                        if ($model->status == 44 || $model->status == 43) {
                            
                            if($model->sn_type==1){
                            return Html::a('<span style="margin:0px 2px;" class="label label-success">Upload SN</span>', '#', [
                                        'title' => Yii::t('app', 'upload'), 'class' => 'viewButton', 'value' => Url::to([$this->context->id . '/uploadsn', 'id' => $model->id_inbound_repair_detail, 'idbarang' => $model->id_barang, 'idparent' => $model->id_instruction_repair]), 'idparent' => $model->id_instruction_repair, 'header' => yii::t('app', 'Create Tag SN')
                            ]);
                            }else{
                                return Html::a('<span style="margin:0px 2px;" class="label label-success">Upload SN</span>', '#', [
                                        'title' => Yii::t('app', 'upload'), 'class' => 'viewButton', 'value' => Url::to([$this->context->id . '/cond', 'id' => $model->id_inbound_repair_detail, 'idbarang' => $model->id_barang, 'idparent' => $model->id_instruction_repair]), 'idparent' => $model->id_instruction_repair, 'header' => yii::t('app', 'Create Tag SN')
                            ]); 
                            }
                        }
                    },
                ],
            ],
        ],
    ]);
    ?>
</div>

<?php 
if($model->status_listing!=1){
echo Html::button(Yii::t('app', 'Submit SN'), ['id' => 'approveButton', 'class' => 'btn btn-success']); 
}
?>

<?php Pjax::end(); ?>

<script>
    $('#approveButton').click(function () {
        var button = $(this);
        button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
        var status = '41';
        $('.valst').each(function () {
            if ($(this).val() != '41') {
                status = '44';
            }
        });
//        console.log(status);
        // $('#modal').modal('hide').delay(1500);
//        data=new FormData();
//         data.append('status', status);
//        var data={'id':1,status:status};
        $.ajax({
            url: '<?php echo Url::to([$this->context->id . '/submitsn', 'id' => $model->id_instruction_repair,]);  ?>',
            type: 'post',
            data: {status:status},
//            processData: false,
//            contentType: false,
            success: function (response) {
                if (response == 'success') {
                    window.location.href='<?php echo Url::to([$this->context->id . '/indexsn']);  ?>';
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

    $('.condButton').click(function () {
        //alert('HAI!')
        //$('#modal').modal('hide')
        $('#modal2').modal('show')
                .find('#modalContent2')
                .load('<p>tes</p>');
        $('#modalHeader2').html('<h3> Update Warehouse Transfer Instruction</h3>');
    });

    $('.viewSN').click(function () {
        //$('#modal').modal('hide')
        $('#modalSN').modal('show')
                .find('#modalContentSN')
                .load('http://localhost:8080/im/divisisatu/web/inbound-repair/uploadsn?item=1')
    });

    $("#checkboxMacaddr").change(function () {

        if (this.checked) {
            //Do stuff
            $("#downloadTemplate").
                    alert("click!");
        }
    });
    $('.viewButton').click(function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        $('#modalHeader').html('<h3> ' + $(this).attr('header') + '</h3>');
    });
    $('#previousButton').on("click", function () {
        $('#modalSN').modal('show')
                .find('#modalContentSN')
                .load('<?php echo Url::to([$this->context->id . '/createtag', 'id' => $id]); ?>');
        $('#modalHeader').html('<h3> Detail Instruksi Warehouse Transfer </h3>');
    });

</script>