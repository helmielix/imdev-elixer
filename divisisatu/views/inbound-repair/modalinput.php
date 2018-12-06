<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\Url;
use kartik\grid\GridView;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\OutboundRepairTransfer */

// MASIH ADA YANG HARUS DIUBAH!!! <CHG>
// TANGGAL JANGAN DENGAN FORMAT ANEH!!!

/* $this->title = $model->id_instruction_repair;
  $this->params['breadcrumbs'][] = ['label' => 'Outbound Wh Transfers', 'url' => ['index']];
  $this->params['breadcrumbs'][] = $this->title; */
//$model = ["title" => 12]
?>

<div class="outbound-wh-transfer-create">

    <div class="row">
        <div class="col-sm-6">

<?=
DetailView::widget([
    'model' => $model,
    'options' => ['class' => 'small table table-striped table-bordered detail-view'],
    'attributes' => [
        [
            'label' => 'Nomor Surat Jalan',
            'value' => function($model) {
                //return $model->no_sj;
                return $model->no_sj;
            }
        ],
        [
            'attribute' => 'name',
            'label' => 'Vendor Repair',
        /* 'value' => function($model){
          // $model->instructionRepair->vendor_repair;
          return $model->name;
          } */
        ],
        [
            'label' => 'File Attachment',
            'value' => function($model) {
                return 'file.pdf';
            }
        ],
    /* [
      //'attribute' => 'tanggal_datang',
      'format' => 'raw',
      'label' => 'Tanggal Datang',
      'value' => function($model) {
      global $form;
      return $form->field($model, 'tanggal_datang')->widget(
      DatePicker::className(),
      [ 'inline' => false,
      'clientOptions' => [
      'autoclose' => true,
      'format' => 'yyyy-mm-dd',
      // 'startDate' => $model->idCdmPnl->pnl_date
      ]
      ]);
      }
      ], */
    // 'idInstructionRepair.wh_origin',
    // 'idInstructionRepair.wh_destination',
    ]
]);
?>

        </div>
    </div>

    <?php
//    echo $this->context->id;
    $form = ActiveForm::begin([
                'enableClientValidation' => true,
                'id' => 'createForm',
                'action' => Url::to([$this->context->id . '/index']),
                //'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{hint}\n{error}\n",
                /* 'horizontalCssClasses' => [
                  'label' => 'col-sm-4',
                  'offset' => 'col-sm-offset-4',
                  'wrapper' => 'col-sm-6',
                  'error' => '',
                  'hint' => '',
                  ], */
                ],
                'requiredCssClass' => 'requiredField',
                'options' => ['enctype' => 'multipart/form-data']
    ]);
    ?>
<?php echo Html::hiddenInput('id', $id); ?>
    <?=
    $form->field($model, 'tanggal_datang')->widget(
            DatePicker::className(), ['inline' => false,
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
        // 'startDate' => $model->idCdmPnl->pnl_date
        ]
    ])
    ?>

    <div class="row">
        <div class="col-sm-12">
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
                        'attribute' => 'name',
                        'label' => 'Nama Barang',
                    ],
                    [
                        'attribute' => 'im_code',
                        'label' => 'IM Code',
                    ],
                    [
                        'attribute' => 'brand',
                        'label' => 'Brand',
                    ],
                    [
                        'attribute' => 'req_qty',
                        'label' => 'QTY Req',
                    ],
                    [
                        'attribute' => 'id_item_im',
                        'label' => 'QTY Good',
                        'value' => 'item.im_code',
                        'attribute' => 'sn_type',
                        'label' => 'SN/Non',
                        'value' => function($model) {
                            if ($model->sn_type == 1) {
                                return 'SN';
                            } else {
                                return 'Non-SN';
                            }
                        },
                    ],
                    [
                        'attribute' => 'qty_terima',
                        'format' => 'raw',
                        'label' => 'QTY Terima',
                        'value' => function($model) {
//                            echo "<pre>";print_r($model);
                            return '<input type="text" name="req_qty['.$model->id_inbound_repair_detail.']" value="' . $model->qty_terima . '">';
                        }
                    ],
                    [
                        'attribute' => 'delta',
                        'label' => 'Delta',
         
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Status',

                    ],
                ],
            ]);
            ?>
        </div>
    </div>

    <div class="form-group">
    <?= Html::submitButton('Submit SN', ['class' => 'btn btn-success', 'id' => 'submitButton']) ?>
    </div>

<?php ActiveForm::end() ?>
</div>

