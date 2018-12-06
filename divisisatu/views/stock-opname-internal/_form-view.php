<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\time\TimePicker;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use dosamigos\datepicker\DateRangePicker;
use yii\helpers\ArrayHelper;
use divisisatu\models\Warehouse;
use divisisatu\models\Labor;


/* @var $this yii\web\View */
/* @var $model divisisatu\models\StockOpnameInternal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-opname-internal" id="step1">

    <?php $form = ActiveForm::begin([
            'enableClientValidation' => true,
            'id' => 'createForm',
            'action' => '/im/divisisatu/web/stock-opname-internal/update?id='.$model->id,
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

    <?= $form->field($model, 'stock_opname_number')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'cut_off_data_date')->widget(
                    DatePicker::className(),
                    [
                        'inline' => false,
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-M-yyyy'
                        ],
                        'options' => [
                            'readonly' => 'readonly'
                        ],
                        'clientEvents' => [
                            'changeDate' => false
                        ],
                    ]); ?>

    <?= $form->field($model, 'cut_off_data_time')->widget(
                    TimePicker::className(),
                    [
                        'disabled' => true,
                        'pluginOptions' => [
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
                ],
                'options' => [
                    'readonly' => 'readonly'
                ],
                'clientEvents' => [
                    'changeDate' => false
                ],
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
                ],
                'options' => [
                    'readonly' => 'readonly'
                ],
                'clientEvents' => [
                    'changeDate' => false
                ],
            ]);?>
        </div>
    </div>


    <?= $form->field($model, 'id_warehouse')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'pic')->widget(Select2::classname(), [
        'data' => ArrayHelper:: map ( Labor:: find()->asArray()->all(), 'nik', 'nama'),
        'language' => 'en',
        'options' => ['placeholder' => 'Select PIC'],
        'pluginOptions' => ['allowClear' => true],
    ])->label('PIC') ?>

     <div class="form-group">
        <label class='control-label col-sm-4'> </label>
        <div class='col-sm-6'>
            <?= Html::button('Create', ['id'=>'nextButton','class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>

<div class="am-stock-opname-fa-forsm" id="step2" style="display: none;">
    <div class="row">
      <div class="col-sm-6">
        <p>
            <?= Html::button('Upload Excel', ['id'=>'uploadButton','class' => 'btn btn-success']) ?>
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
            'f_good',
            'f_not_good',
            'f_reject',
            'f_dismantle_good',
            'f_dismantle_not_good',
            'f_good_recondition',
            'adj_good',
            'adj_not_good',
            'adj_reject',
            'adj_dismantle_good',
            'adj_dismantle_not_good',
            'adj_good_recondition',
            'remark',
            'file',
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    </div>

        <div>
           <?= Html::button('Previous', ['id'=>'previousButton','class' => 'btn btn-success']) ?>
           <?= Html::button('Submit Stock Opname', ['id'=>'createButton','class' => 'btn btn-success']) ?>
        </div>

    </div>
</div>
    <?php ActiveForm::end(); ?>

<script>
    $('#nextButton').click(function () 
    {
        var form = $('#createForm');
        data = form.data("yiiActiveForm");
        $.each(data.attributes, function() 
        {
            this.status = 3;
        });
        form.yiiActiveForm("validate");
        if (!form.find('.has-error').length) 
        {
            $('#step1').css("display", "none")
            $('#step2').css("display", "block")
            $('#modalHeader').html('<h3>Detail Stock Opname</h3>')

        }
    })

    $('#previousButton').click(function () 
    {
        $('#step1').css("display", "block")
        $('#step2').css("display", "none")
        $('#modalHeader').html('<h3>Create Stock Opname</h3>')
    })

    $('#createButton').click(function () 
    {
        var form = $('#createForm');
        data = form.data("yiiActiveForm");
        $.each(data.attributes, function() 
        {
            this.status = 3;
        });
        form.yiiActiveForm("validate");
        if (!form.find('.has-error').length) 
        {
            data = new FormData(form[0]);

            data.append( 'StockOpnameInternal[id_warehouse]', $( '#stockopnameinternal-id_warehouse' ).val() );


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
</script>
