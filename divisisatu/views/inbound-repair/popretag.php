<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

$this->registerJsFile('@commonpath/js/btn_modal.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="outbound-wh-transfer-create">

    <div class="row">
        <div class="col-sm-6">
            <div>
                <?php
                Modal::begin([
                    'id' => 'modalretag',
                    'size' => 'modal-lg',
                ]);

                echo "<div id='modalContent'></div>";

                echo '<div class="modal-footer">
        </div>';

                Modal::end();
                ?>
            </div>
            <p style="color:red">Serial Number yang Anda masukkan tidak ditemukan.<br>Silakan melakukan tagging SN kembali!<p>
                <?php
                if ($this->context->action->id != "indexadjust") {
                    echo Html::a('Re-Tag SN', '#retag?header=Create_Adjustment_Daily', ['id' => 'btnmodalretag', 'class' => 'btn btn-success',
                        'value' => Url::to(['inbound-repair' . '/' . 'retag', 'id' => $id, 'idparent' => $idparent, 'idbarang' => $idbarang]), 'header' => yii::t('app', 'Re-tag SN')]);
                }
                ?>
        </div>
    </div>
</div>
<script>
    $('#btnmodalretag').click(function () {
//          console.log($(this).attr('value'));
        $('#modalretag').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
</script>