<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use kartik\time\TimePicker;
use dosamigos\datepicker\DatePicker;
use dosamigos\datepicker\DateRangePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\StockOpnameInternal */
/* @var $form yii\widgets\ActiveForm */

$model->status_listing=1;
?>

<div class="stock-opname-internal-form">
    <div class="row">
      <div class="col-sm-6">
        <p>Stock Gudang</p>
      </div>
      <div class="col-sm-6">
        <p class="pull-right">
            <?= Html::button('Export to Excel',
                [
                    'class' => 'btn btn-success',
                    'id' => 'export-excel',
                    'value'=>Url::to(['stock-opname-internal/create']),
                    'header'=> yii::t('app','Create Stock Opname Internal')
                ]);
            ?>
            <?= Html::button('Previous', ['id'=>'previousButton','class' => 'btn btn-success']) ?>
        </p>
      </div>
    </div>
<?php Pjax::begin(['id' => 'pjax', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]) ?>
<?= GridView::widget([

        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'orafin_code',
            'im_code',
            'name',
            'brand',
            'grouping',
            'sn_type',
            's_good',
            's_not_good',
            's_reject',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

    <?php $form = ActiveForm::begin(); ?>

    <div>
       <?= Html::button('Previous', ['id'=>'previousButton','class' => 'btn btn-success']) ?>
       <?= Html::button('Submit Stock Opname', ['id'=>'createButton','class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<script>
$('#export-excel').click(function () {
    `<?php
    $file = Yii::createObject([
        'class' => 'codemix\\excelexport\\ExcelFile',
        'sheets' => [
            'Users' => [
                'class' => 'codemix\\excelexport\\ActiveExcelSheet',
                'query' => $dataProvider,
            ]
        ]
    ]);
    $file->send('user.xlsx'); ?>`
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
                    // $('#modal').modal('show')
                    //     .find('#modalContent')
                    //     .load('<?php
                    //     $goto = ($model->isNewRecord) ? '/indexdetail' : '/view';
                    //     echo Url::to([$this->context->id.$goto, 'id' => Yii::$app->session->get('idInstRep')]) ;?>');
                    // $('#modalHeader').html('<h3>Detail Instruksi Warehouse Transfer</h3>');
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
