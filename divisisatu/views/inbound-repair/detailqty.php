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

// MASIH ADA YANG HARUS DIUBAH!!! <CHG>

/* $this->title = $model->id_instruction_repair;
  $this->params['breadcrumbs'][] = ['label' => 'Outbound Wh Transfers', 'url' => ['index']];
  $this->params['breadcrumbs'][] = $this->title; */
//$model = ["title" => 12]

function getSNType() {
    return [1 => 'SN', 2 => "Non SN"];
}

$this->registerJsFile('@commonpath/js/btn_modal.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/popup_alert.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<?php
Modal::begin([
    'header' => '<h3 id="modalHeader"></h3>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);

echo '<div id="modalContent"> </div>';

Modal::end();
//var_dump($searchModel->one());
//exit();
?>


<div class="row">
    <div class="col-sm-6">

        <?=
        DetailView::widget([
            'model' => $searchModel->one(),
            'options' => ['class' => 'small table table-striped table-bordered detail-view'],
            'attributes' => [
                [
                    'attribute' => 'name',
                    'label' => 'Nama Barang',
                //'value' => '001/INST',
                ],
                [
                    'attribute' => 'im_code',
                //'label' => 'Tanggal Pengiriman',
                //'value' => '20 Juli 2018',
                ],
                [
                    'attribute' => 'grouping',
                //'label' => 'Warehouse',
                //'value' => 'Jakarta',
                ],
                [
                    'attribute' => 'req_qty',
                //'label' => 'Vendor Repair',
                //'value' => 'Makmur',
                ],
            ]
        ]);
        ?>

    </div>
</div>
<div class="row">
    <?=
    GridView::widget([
        'id' => 'gridViewindexdetail',
        'dataProvider' => $dataProvider,
//        'model' => $dataProvider,
        'floatHeader' => true,
        'floatOverflowContainer' => true,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 's_good',
                'label' => 'Good',
                'value' => function($model) {
                    return Html::textInput('s_good', $model->s_good, ['onChange' => 'ubahdelta()', 'id' => 'good']);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 's_reject',
                'label' => 'Reject',
                'value' => function($model) {
                    return Html::textInput('s_reject', $model->s_reject, ['onChange' => 'ubahdelta()', 'id' => 'reject']);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'delta',
                'label' => 'Delta',
                'value' => function($model) {
                    return Html::tag('span', $model->s_good - $model->s_reject, ['class' => 'delta', 'id' => 'delta', 'data-idparent' => $model->id_instruction_repair]);
                },
                'format' => 'raw',
            ],
        ],
    ]);
    ?>
</div>
<?php echo Html::button(Yii::t('app', 'Submit'), ['id' => 'approveNonSNButton', 'class' => 'btn btn-success']); ?>
<script>
    function ubahdelta() {
        var good = $('#good').val();
        var reject = $('#reject').val();
        $('#delta').text((parseInt(good) - parseInt(reject)));
    }
    $('#approveNonSNButton').click(function () {
        var good = $('#good').val();
        var reject = $('#reject').val();
        var delta = (parseInt(good) - parseInt(reject));
        var iddetail = $('#delta').attr("data-idparent");
        data = {good: good, reject: reject, delta: delta, iddetail: iddetail};
        $.ajax({
            url: '<?php echo Url::to([$this->context->id . '/submitnonsn']); ?>',
            type: 'post',
            data: data,
            success: function (response) {
                if (response == 'success') {
//                    $('#modal').modal('hide');
                    $('#modal').modal('show')
                            .find('#modalContent')
                           .load('<?php echo Url::to(['/'.\Yii::$app->controller->id.'/createtag', 'id' => $idparent]) ;?>');
							;
                    $('#modalHeader').html('<h3> Create Tag SN</h3>');
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
</script>