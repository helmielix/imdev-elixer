<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\MkmMasterItem;
use common\models\InstructionGrfDetail;

// $this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs(
// "$(document).on('ready pjax:success', function() {
        // // $('.modalButton').click(function(e){
           // // e.preventDefault(); //for prevent default behavior of <a> tag.
           // // var tagname = $(this)[0].tagName;
           // // $('#editModalId').modal('show').find('.modalContent').load($(this).attr('href'));
        // // });
        // console.log('ready pjax:success indexdetail');
        // $.pjax.reload({container:'#pjaxindexdetail',timeout: false});
    // });
    "
    // $(document).on('ready pjax:end', function(event) {
      // $(event.target).initializeMyPlugin()
    // })
");
?>
<div class="instruction-wh-transfer-detail-index">

    <?php if(($this->context->action->id == 'view' && $model->status_listing != 6) || $this->context->action->id == 'indexdetail' ){ ?>
    <!-- <p>
        <?= Html::button(Yii::t('app','Add'), ['id'=>'createsButton','class' => 'btn btn-success']) ?>
    </p> -->
    <?php } ?>
    <?php Pjax::begin([
            'id' => 'pjaxindexgrfdetail',
            'timeout' => false, 
            'enablePushState' => false,         
            'clientOptions' => ['method' => 'POST', 'backdrop' => false, 
            // "container" => "#pjaxindexdetail"
            ],
        ]); ?>
    <?= GridView::widget([
        'id' => 'gridViewindexgrfdetail',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'floatHeader'=>true,
        'floatOverflowContainer' => true,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute' => 'im_code',
                'value' => 'im_code',
            ],

            [
                'label' => 'Nama Barang',
                'attribute' => 'name',
                'value' => 'name',
            ],
            [
                'attribute' => 'brand',
                'value' => 'brand',
            ],
            [
                'attribute' => 'type',
                'value' => 'type',
            ],
            [
                'attribute' => 'warna',
                'value' => 'warna',
            ],
            [
                'attribute' => 'sn_type',
                'value' => 'description',
            ],

            [
                'label' => 'Qty Req',
                'attribute' => 'qty_request',
                'value' => 'qty_request',
            ],
            [
                'attribute' => 'qty_good',
                'format' => 'raw',
                'value' => 'qty_good',
            ],
            [
                'attribute' => 'qty_noot_good',
                'value' => 'qty_noot_good',
            ],
            [
                'attribute' => 'qty_reject',
                'value' => 'qty_reject',
            ],
            [
                'attribute' => 'qty_dismantle_good',
                'value' => 'qty_dismantle_good',
            ],
            [
                'attribute' => 'qty_dismantle_ng',
                'value' => 'qty_dismantle_ng',
            ],
            [
                'attribute' => 'qty_good_rec',
                'value' => 'qty_good_rec',
            ],



            
        ],
    ]); ?>
    <?php yii\widgets\Pjax::end() ?>
    <?php if(($this->context->action->id == 'view' && $model->status_listing != 6) || $this->context->action->id == 'indexgrfdetail' ){ ?>
    <p>        
        <?php if(Yii::$app->controller->action->id == 'indexgrfdetail')
            echo Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-primary']);  ?>
        <?= Html::button(Yii::t('app','Submit Instruction'), ['id'=>'submitButton','class' => 'btn btn-success']) ?>        
    </p>
    <?php } ?>
</div>

<!-- <script>
    // $(document).on('ready pjax:end', function(event) {
      // $(event.target).initializeMyPlugin()
    // })
    // $(document).on("pjax:send", function(e, contents) {
    //    var $contentBeforePut = $(contents);

    //    if(1==1) {
    //     console.log('success replace pjaxindexdetail '+$contentBeforePut);
    //     // here I want to prevent put html content, I tried with:
    //     return false; 
    //    }
    // })
     $('.createsButton').click(function (event) {
            event.stopImmediatePropagation();  
            
            // console.log($(this).attr('orafincode'));
            // alert($(this).attr('orafincode'));
            
            // return false;
            // $('#modal').modal('hide');
            $('#modal').modal('show')
                .find('#modalContent')
                .load('<?php echo Url::to([$this->context->id.'/createdetail','id'=>Yii::$app->session->get('idGrf')]) ;?>');
            $('#modalHeader').html('<h3>  Detail Instruction Grf </h3>');
            // event.stopPropagation();
        });
    
    
    $('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id.'/update','id'=>Yii::$app->session->get('idInstWhTr')]) ;?>');
        $('#modalHeader').html('<h3> Detail Instruksi Warehouse Transfer </h3>');
    });
    
    $('#submitButton').click(function () {
        var button = $(this);
        button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
        
        $.ajax({
            url: '<?php echo Url::to([$this->context->id.'/submit', 'id' => Yii::$app->session->get('idInstWhTr')]) ;?>',
            type: 'post',
            processData: false,
            contentType: false,
            success: function (response) {
                if(response == 'success') {
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
                    alert("System recieve error with code: "+xhr.status);
                }
            },
            complete: function () {
                button.prop('disabled', false);
                $('#spinRefresh').remove();
            },
        });
    });
    $('.viewButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
        $('#modalHeader').html('<h3> '+ $(this).attr('header') +'</h3>');
    });

</script> -->
