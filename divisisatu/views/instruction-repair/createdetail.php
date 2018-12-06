<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\money\MaskMoney;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->registerJsFile('@commonpath/js/btn_modal.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

function getSNType() {
    return [1 => 'SN', 2 => "Non SN"];
}

function getTypeBarang() {
    return ArrayHelper::map(\common\models\MasterItemIm::find()->all(), 'type', 'type');
    ;
}
?>
<div class="instruction-wh-transfer-detail-index dsd">

    <p>
        <?php Html::button(Yii::t('app', 'Add'), ['id' => 'createButton', 'class' => 'btn btn-success']) ?>


    </p>
    <?php
//$form = ActiveForm::begin([
//            'id' => 'createDetail', 
////            'action'=>"#",
////            'method'=>'Get',
//            'layout' => 'horizontal',
//            'fieldConfig' => [
//                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
//                'horizontalCssClasses' => [
//                    'label' => 'col-sm-4',
//                    'offset' => 'col-sm-offset-4',
//                    'wrapper' => 'col-sm-6',
//                    'error' => '',
//                    'hint' => '',
//                ],
//            ],
//        ]);
    ?>
    <div class="alert hidden" id="errorSummary">Please fix these following error: <ul id="ulerrorSummary"></ul></div>
        <?php
        Pjax::begin(['id' => 'pjaxcreatedetail', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST', 'backdrop' => false,
                "container" => "#pjaxcreatedetail"
            ],]);
        ?>
        <?=
        GridView::widget([
            'id' => 'gridViewcreatedetail',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
//            'options' => ['style' => 'overflow-x:scroll'],
            // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
//            'responsive' => true,
            'floatHeader' => true,
            'floatOverflowContainer' => true,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'im_code',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->im_code . Html::hiddenInput('im_code[]', $model->id . ';' . $model->im_code, ['class' => 'im_code']);
                    },
                ],
                [
                    'attribute' => 'name',
                ],
                'brand',
                [
                    'attribute' => 'type',
                    'filter' => getTypeBarang()
                ],
                'warna',
                [
                    'attribute' => 'sn_type',
                    'filter' => getSNType(),
                    'value' => function ($model) {
                        if ($model->sn_type == 1) {
                            return 'SN';
                        } else {
                            return 'Non SN';
                        }
                    },
                ],
                // 'UOM',
                // 'stock_qty',
                [
                    'attribute' => 's_good',
                    'contentOptions' => ['class' => 'bg-success'],
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'mergeHeader' => true,
                    'vAlign' => 'middle',
                ],
                [
                    'attribute' => 's_not_good',
                    'contentOptions' => ['class' => 'bg-warning'],
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'mergeHeader' => true,
                    'vAlign' => 'middle',
                    'value' => function ($model)use ($reqItemNotGood) {
                        return $model->s_not_good - @$reqItemNotGood[$model->id];
                    },
                ],
                [
                    'attribute' => 's_reject',
                    'contentOptions' => ['class' => 'bg-danger'],
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'mergeHeader' => true,
                    'vAlign' => 'middle',
                    'value' => function ($model)use ($reqItem) {
                        return $model->s_reject - @$reqItem[$model->id];
                    },
                ],
                [
                    'label' => 'Req. Not Good',
                    'format' => 'raw',
                    'value' => function ($model)use ($reqItemNotGood) {
//                        $det= \common\models\InstructionRepairDetail::find()->where(['id_item_im' =>$model->]);
//                        echo '<pre>';print_r($model);
//print_r($reqItemNotGood);
                        $out = '<div class="col-xs-12">';
                        $out .= '</div>';
                        $out = Html::textInput('rnotgood[]', '', ['class' => 'form-control input-sm txt-notgood', 'data-notgood' => $model->s_not_good, 'data-current' => @$reqItemNotGood[$model->id]]);
                        return $out;
                    },
                    'contentOptions' => ['class' => 'bg-danger'],
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'mergeHeader' => true,
                    'vAlign' => 'middle',
                ],
                [
                    'label' => 'Req. Reject',
                    'format' => 'raw',
                    'value' => function ($model)use ($reqItem) {
//                        $det= \common\models\InstructionRepairDetail::find()->where(['id_item_im' =>$model->]);
//                        echo '<pre>';print_r($model);
//print_r($reqItem);exit();
                        $out = '<div class="col-xs-12">';
                        $out .= '</div>';
                        $out = Html::textInput('rreject[]', '', ['class' => 'form-control input-sm txt-reject', 'data-current' => @$reqItem[$model->id], 'data-reject' => $model->s_reject]);
                        return $out;
                    },
                    'contentOptions' => ['class' => 'bg-danger'],
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'mergeHeader' => true,
                    'vAlign' => 'middle',
                ],
                [
                    'label' => 'Rem.good',
                    'contentOptions' => ['class' => 'bg-success'],
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'mergeHeader' => true,
                    'vAlign' => 'middle',
                    'value' => function ($model) {

                        return $model->s_good - $model->req_good_qty;
                    },
                ],
                [
                    'label' => 'Rem.Not Good',
                    'contentOptions' => ['class' => 'bg-danger'],
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'mergeHeader' => true,
                    'vAlign' => 'middle',
                    'value' => function ($model) use ($reqItemNotGood) {

                        //return $model->s_not_good - @$reqItemNotGood[$model->id];
                        return $model->s_not_good;
                    },
                ],
                [
                    'label' => 'Rem.reject',
                    'contentOptions' => ['class' => 'bg-danger'],
                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                    'mergeHeader' => true,
                    'vAlign' => 'middle',
                    'value' => function ($model) use ($reqItem) {

                        //return $model->s_reject - @$reqItem[$model->id];
                        return $model->s_reject;
                    },
                ],
            ],
        ]);
        ?>
        <?php yii\widgets\Pjax::end() ?>
    <p>
        <?= Html::button(Yii::t('app', 'Previous'), ['id' => 'previousButton', 'class' => 'btn btn-success']); ?>
        <?= Html::button(Yii::t('app', 'Submit Item'), ['id' => 'submitButton', 'class' => 'btn btn-success']) ?>
    </p>
    <?php // ActiveForm::end();  ?>
</div>

<script>

<?php
$qString = Yii::$app->request->queryString;
$id = null;
if ($qString == '') {
    $goto = '/indexdetail';
} else {
    $goto = '/view';
    $id = Yii::$app->session->get('idInstRep');
}
?>
//    $('#')
    $(".txt-notgood").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: home, end, left, right, down, up
                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
    $(".txt-reject").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: home, end, left, right, down, up
                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
    $('.txt-notgood').on('keyup', function () {
        var notgood = $(this).attr('data-notgood');
        var req = $(this).val();
        var current = $(this).attr('data-current');
        var sisa = parseInt(notgood) - parseInt(req) - parseInt(current);
        if (sisa < 0) {
            alert('Your request greater than stock');
             $(this).val(parseInt(notgood));
        } else {
            if (!isNaN(sisa)) {
                //$(this).closest('td').next().next().next().text(sisa);
            } else {
                //$(this).closest('td').next().next().next().text(notgood - current);
            }
        }
    });

    $('.txt-reject').on('keyup', function () {
        var reject = $(this).attr('data-reject');
        var req = $(this).val();
        var current = $(this).attr('data-current');
        var sisa = parseInt(reject) - parseInt(req) - parseInt(current);
        if (sisa < 0) {
            alert('Your request greater than stock');
            $(this).val(parseInt(reject));
        } else {
            if (!isNaN(sisa)) {
                //$(this).closest('td').next().next().next().text(sisa);
            } else {
                //$(this).closest('td').next().next().next().text(reject - current);
            }
        }
    });

    $('#previousButton').click(function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load('<?php echo Url::to([$this->context->id . $goto, 'id' => $id]); ?>');
        $('#modalHeader').html('<h3> Create Instruction Repair </h3>');
    });

    $('#submitButton').click(function () {
        window.imcode = '';
        window.rreject = '';
        window.rnotgood = '';
        $.each($(".dsd").find(':input'), function () {
            if ($(this).attr('class') == 'im_code') {
                window.imcode += $(this).val() + ",";
            }
            if ($(this).attr('name') == 'rreject[]') {
                window.rreject += $(this).val() + ",";
            }
            if ($(this).attr('name') == 'rnotgood[]') {
                window.rnotgood += $(this).val() + ",";
            }
        });


        data = new FormData();
        data.append("im_code[]", window.imcode.substring(0, window.imcode.length - 1).split(','));
        data.append("rreject[]", window.rreject.substring(0, window.rreject.length - 1).split(','));
        data.append("rnotgood[]", window.rnotgood.substring(0, window.rnotgood.length - 1).split(','));

        var button = $(this);
        button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

        $('#errorSummary').addClass('hidden');
        $('#ulerrorSummary li').remove();
        $('tr[data-key').removeClass('info');

        $.ajax({
            url: '<?php echo Url::to([$this->context->id . '/createdetail', 'id' => Yii::$app->session->get('idInstWhTr')]); ?>',
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                if (response.status == 'success') {
                    $('#modal').modal('show')
                            .find('#modalContent')
                            .load('<?php echo Url::to([$this->context->id . $goto, 'id' => $id]); ?>');
                    $('#modalHeader').html('<h3>Create Repair Instruction</h3>');
                } else {
                    pesan = response.pesan;
                    pesan = pesan.split('\n');
                    $('#errorSummary').addClass('alert-danger').removeClass('hidden');
                    for (i = 0; i < pesan.length; i++) {
                        $('#ulerrorSummary').append('<li>' + pesan[i] + '</li>');
                    }
                    $('tr[data-key=' + response.id + ']').addClass('info');
                    alert('error with message: ' + response.pesan);
                }
            },
            error: function (xhr, getError) {
                if (typeof getError === "object" && getError !== null) {
                    error = $.parseJSON(getError.responseText);
                    getError = error.message;
                }
                if (xhr.status != 302) {
                    alert("System receive error with code: " + xhr.status);
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
