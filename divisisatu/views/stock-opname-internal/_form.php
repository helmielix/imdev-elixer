<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use kartik\time\TimePicker;
use dosamigos\datepicker\DatePicker;
use dosamigos\datepicker\DateRangePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\export;
use divisisatu\models\Warehouse;
use divisisatu\models\StockOpnameInternal;
use divisisatu\models\MasterItemImSearch;



/* @var $this yii\web\View */
/* @var $model divisisatu\models\StockOpnameInternal */
/* @var $form yii\widgets\ActiveForm */
?>

 <?php $form = ActiveForm::begin([
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
        ]); ?>

<div class="stock-opname-internal" id="step1">

    <!-- <?= $form->field($model, 'stock_opname_number')->textInput(['disabled' => true]) ?> -->

    <?= $form->field($model, 'cut_off_data_date')->widget(
                    DatePicker::className(),
                    [ 'inline' => false,
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-M-yyyy'
                        ]
                    ]); ?>
    <?= $form->field($model, 'cut_off_data_time')->widget(
                    TimePicker::className(),
                    [ 'pluginOptions' => [
                        'showSeconds' => true,
                        'showMeridian' => false,
                        'minuteStep' => 1,
                        'secondStep' => 5,
                    ]
                ]); ?>

    <div class="form-group">
        <label class="control-label col-sm-4">Tanggal Stock Opname</label>
        <div class="col-sm-3">
            <?= DatePicker::widget([
                'model' => $model,
                'attribute' => 'start_date',
                'template' => '{input}{addon}',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-M-yyyy'
                ]
            ]);?>
        </div>
        <div class="col-sm-3">
            <?= DatePicker::widget([
                'model' => $model,
                'attribute' => 'end_date',
                'template' => '{input}{addon}',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-M-yyyy'
                ]
            ]);?>
        </div>
    </div>

    <?= $form->field($model, 'id_warehouse')->widget(Select2::classname(), [
        'data' => ArrayHelper:: map ( Warehouse:: find()->asArray()->all(), 'id', 'nama_warehouse'),
        'language' => 'en',
        'options' => ['placeholder' => 'Select Warehouse'],
        'pluginOptions' => ['allowClear' => true],
    ])->label('Warehouse') ?>

        <div class="form-group">
        <label class='control-label col-sm-4'> </label>
        <div class='col-sm-6'>
            <?php switch ($this->context->action->id) {
                case 'create':
                    $actionText = 'Create';
                    break;
                case 'update':
                    $actionText = 'Update';
                    break;
            } ?>
            <?= Html::button($actionText, ['id'=>'nextButton','class' => 'btn btn-success']) ?>
        </div>
    </div>

</div>
<div class="stock-opname-internal-form" id="step2" style="display: none;">
    <div class="row">
      <div class="col-sm-6">
        <p>Stock Gudang</p>
      </div>
      <div class="col-sm-6">
        <p class="pull-right">
            <label for="intransit" style="margin-right: 5px;">Status Intransit</label>
            <input type="checkbox" style="margin-right: 10px;" id="intransit" />
            <?= Html::a('Export to Excel',
                Url::to(['stock-opname-internal/export-excel']),
                [
                    'class' => 'btn btn-success',
                    'id' => 'export-excel',
                ]);
            ?>
            <?= Html::a('Export to Excel',
                Url::to(['stock-opname-internal/export-excel-intransit']),
                [
                    'class' => 'btn btn-success',
                    'style' => 'display: none;',
                    'id' => 'export-excel-intransit',
                ]);
            ?>
        </p>
      </div>
    </div>


<div style="overflow: auto;">
<?php Pjax::begin(['id' => 'sodetail', 'timeout' => false, 'enablePushState' => false]) ?>
<?= GridView::widget([

        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'orafin_code',
            'im_code',
            'name',
            'brand',
            'grouping',
            'sn_type',
            'type',
            's_good',
            's_not_good',
            's_reject',
            's_dismantle_good',
            's_dismantle_not_good',
            's_good_recondition',
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>

    <div>
       <?= Html::button('Previous', ['id'=>'previousButton','class' => 'btn btn-success']) ?>
       <?= Html::button('Submit Stock Opname', ['id'=>'createButton','class' => 'btn btn-success']) ?>
    </div>

</div>
    <?php ActiveForm::end(); ?>

<script>
$('#nextButton').click(function () {
    var form = $('#createForm');
    data = form.data("yiiActiveForm");
    $.each(data.attributes, function() {
        this.status = 3;
    });
    form.yiiActiveForm("validate");
    if (!form.find('.has-error').length) {
                        $('#step1').css("display", "none")
                        $('#step2').css("display", "block")
$('#modalHeader').html('<h3>Detail Stock Opname</h3>')

}
})

                    $('#previousButton').click(function () {
                        $('#step1').css("display", "block")
                        $('#step2').css("display", "none")
$('#modalHeader').html('<h3>Create Stock Opname</h3>')
})
$('#createButton').click(function () {
    var form = $('#createForm');
    data = form.data("yiiActiveForm");
    $.each(data.attributes, function() {
        this.status = 3;
    });
    form.yiiActiveForm("validate");
    if (!form.find('.has-error').length) {
        data = new FormData(form[0]);

        data.append( 'AmStockOpnameFa[id_warehouse]', $( '#amstockopnamefa-id_warehouse' ).val() );


        var button = $(this);
        button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

        $.ajax({
            url: '<?php echo Url::to([$this->context->id.'/'.$this->context->action->id, 'id' => $model->stock_opname_number]) ;?>',
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                if(response == 'success') {
                    window.location.replace('<?= Url::to([$this->context->id . "/index"]); ?>')
                     $('#modal').modal('hide')

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
                    alert("System recieve error with code: "+xhr.status);
                }
            },
            complete: function () {
                button.prop('disabled', false);
                $('#spinRefresh').remove();
            },
        });
    };
});
$('#intransit').change(function () {
    if ($(this).is(':checked')) {
        $('#export-excel').css('display', 'none')
        $('#export-excel-intransit').css('display', 'inline')
    } else {
        $('#export-excel').css('display', 'inline')
        $('#export-excel-intransit').css('display', 'none')
    }
})
</script>


