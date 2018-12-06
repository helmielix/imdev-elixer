<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use dosamigos\datepicker\DatePicker;
use kartik\grid\GridView;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\OutboundRepairTransfer */

$this->registerJsFile('@commonpath/js/btn_modal.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/popup_alert.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$urlsave = Url::to([$this->context->id . '/createtag', 'id' => $model->id_instruction_repair]);
//echo $urlsave;
?>
<div class="outbound-wh-transfer-create">

    <div class="row">
        <div class="col-sm-6">
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
            <?php $form = ActiveForm::begin(['id' => 'upload-form']); ?>
            <?php Pjax::begin(['id' => 'pjax', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]) ?>

            <div class="row">
                <?=
                GridView::widget([
                    'id' => 'gridViewindexdetail',
                    'dataProvider' => $dataProvider,
                    'floatHeader' => true,
                    'floatOverflowContainer' => true,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'name',
                            'label' => 'SN Baru',
                        ],
                        [
                            'label' => 'SN Lama',
                            'format' => 'raw',
                            'value' => function() {
                                return Select2::widget([
                                            'name' => 'sn_lama',
                                            'data' => \yii\helpers\ArrayHelper::map(common\models\MasterSn::find()->all(), 'serial_number', 'serial_number'),
                                            'language' => 'en',
                                            // form-control select2-hidden-accessible
                                            'options' => ['id' => 'jenis_transaksi', 'placeholder' => 'Select SN Lama', 'class' => 'input-sm'],
                                            'pluginOptions' => [
                                                'allowClear' => true],
                                ]);
                            }
                        ],
                        [
                            'label' => 'IM Code',
                            'format' => 'raw',
                            'value' => function() {
                                return Select2::widget([
                                            'name' => 'im_code',
                                            'data' => \yii\helpers\ArrayHelper::map(common\models\MasterItemIm::find()->all(), 'im_code', 'im_code'),
                                            'language' => 'en',
                                            // form-control select2-hidden-accessible
                                            'options' => ['id' => 'jenis_transaksi', 'placeholder' => 'Select IM Code', 'class' => 'input-sm'],
                                            'pluginOptions' => [
                                                'allowClear' => true],
                                ]);
                            }
                        ],
                        [
                            'format' => 'raw',
                            'label' => '',
                            'value' => function($dataProvider) {
//                print_r($dataProvider);
                                return Html::hiddenInput('sn_lama', $dataProvider['name']);
                            }
                        ],
                    ],
                ]);
                ?>
            </div>

            <?php echo Html::button(Yii::t('app', 'Submit'), ['id' => 'saveSNButton', 'class' => 'btn btn-success']); ?>

            <?php Pjax::end(); ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script>
    $('#saveSNButton').click(function () {
//          console.log($(this).attr('value'));
        $('#modal2').modal('show')
                .find('#modal2')
                .load('<?php echo $urlsave; ?>');
    });
</script>