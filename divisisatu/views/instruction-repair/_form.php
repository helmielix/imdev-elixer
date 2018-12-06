<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;
use kartik\select2\Select2;
use common\models\Reference;
use common\models\Warehouse;
use common\models\MasterItemIm;
use common\models\ItemRepairReference;
use common\models\Vendor;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\InstructionWhTransfer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="instruction-wh-transfer-form">

    <?php
    $form = ActiveForm::begin([
                'enableClientValidation' => true,
                'id' => 'createForm',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                    'horizontalCssClasses' => [
                        'label' => 'col-sm-4',
                        'offset' => 'col-sm-offset-4',
                        'wrapper' => 'col-sm-6',
                        'error' => '',
                        'hint' => '',
                    ],
                ],
                'requiredCssClass' => 'requiredField'
    ]);
    ?>

    <?php //echo  $form->field($model, 'instruction_number')->hiddenInput(['disabled' => true]) ?>

    <?=
    $form->field($model, 'target_pengiriman')->label('Tanggal Pengiriman')->widget(
            DatePicker::className(), ['inline' => false,
        'clientOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
        ]
    ])
    ?>

    <?php
    $dataWarehouse = Warehouse::find()->all();
    $dataVendor = Vendor::find()->all();
    ?>

    <?=
    $form->field($model, 'id_warehouse')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($dataWarehouse, 'id', 'nama_warehouse'),
        // 'data' => $dataWarehouse,
        'language' => 'en',
        'options' => ['placeholder' => 'Select Warehouse'],
        'pluginOptions' => [
            'allowClear' => true],
    ])
    ?>

    <?=
    $form->field($model, 'vendor_repair')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($dataVendor, 'id', 'name'),
        // 'data' => $dataWarehouse,
        'language' => 'en',
        'options' => ['placeholder' => 'Select Vendor'],
        'pluginOptions' => [
            'allowClear' => true],
    ])
    ?>

            <?= $form->field($model, 'note')->textArea() ?>

    <div class="form-group">
        <label class='control-label col-sm-4'> </label>
        <div class='col-sm-6'>
            <?php
            switch ($this->context->action->id) {
                case 'create':
                    $actionText = 'Create';
                    break;
                case 'update':
                    $actionText = 'Update';
                    break;
            }
            ?>
<?= Html::button($actionText, ['id' => 'createButton', 'class' => 'btn btn-success']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>


</div>

<script>
    $('#createButton').click(function () {
        var form = $('#createForm');
        data = form.data("yiiActiveForm");
        $.each(data.attributes, function () {
            this.status = 3;
        });
        form.yiiActiveForm("validate");
        if (!form.find('.has-error').length) {
            data = new FormData(form[0]);
            data.append('InstructionRepair[target_pengiriman]', $('#instructionrepair-target_pengiriman').val());
            data.append('InstructionRepair[id_warehouse]', $('#instructionrepair-id_warehouse').val());
            data.append('InstructionRepair[vendor_repair]', $('#instructionrepair-vendor_repair').val());
            data.append('InstructionRepair[note]', $('#instructionrepair-note').val());

            var button = $(this);
            button.prop('disabled', true);
            button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

            $.ajax({
                url: '<?php echo Url::to([$this->context->id . '/' . $this->context->action->id, 'id' => $model->id]); ?>',
                type: 'post',
                data: data,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response == 'success') {

                        var headerModal = '';
                        var controllerLabel = '<?php echo Yii::$app->controller->action->id; ?>';

                        if (controllerLabel=='update') {
                            headerModal = '<h3>Update Detail Repair Instruction<h3>' ;
                        } else {
                            headerModal = '<h3>Detail Repair Instruction<h3>';
                        }

                        $('#modal').modal('show')
                                .find('#modalContent')
                                .load('<?php
//$goto = ($model->isNewRecord) ? '/indexdetail' : '/view';
echo Url::to([$this->context->id . '/indexdetail', 'id' => Yii::$app->session->get('idInstRep')]);
?>');

                        $('#modalHeader').html(headerModal);
                    } else {
                        alert('error with message: ' + response);
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
        }
        ;
    });
</script>
