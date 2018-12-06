<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\MkmMasterItem;
use common\models\InboundGrfDetail;
use common\models\MasterItemIm;

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
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
            'id' => 'pjaxindexdetail',
            'timeout' => false, 
            'enablePushState' => false,         
            'clientOptions' => ['method' => 'POST', 'backdrop' => false, 
            // "container" => "#pjaxindexdetail"
            ],
        ]); ?>
    <?= GridView::widget([
        'id' => 'gridViewindexdetail',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'floatHeader'=>true,
        'floatOverflowContainer' => true,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // [
            //     'class' => 'yii\grid\ActionColumn',
            //     'buttons'=>[
            //         'delete' => function ($url, $model) {
            //             return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-trash"></span>', '#', [
            //                 'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/deletedetail', 'id' => $model->id]), 'header'=> yii::t('app','GRF Detail')
            //             ]);
            //         },
                    
            //         'update' => function ($url, $model) {
            //             return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>', '#', [
            //                 'title' => Yii::t('app', 'update'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/updatedetail', 'idDetail'=> $model->id]), 'header'=> yii::t('app','Update Detail Warehouse Transfers Instruction')
            //             ]);
            //         },
            //     ],
            // ],
            
            [
                'attribute' => 'orafin_code',
                // 'value' => 'idMasterItemIm.im_code',
            ],
            // 'idOrafinCode.item_desc',
            [
                'header' => 'Nama Barang',
                'attribute' => 'name',
                // 'value' => function($model){
                    // $item = MkmMasterItem::find()->select(['item_desc'])->andWhere(['item_code' => $model->orafin_code])->one();
                    // return $item->item_desc;
                // },
                'value' => 'name',
            ],
            [
                'header' => 'Grouping Barang',
                'attribute' => 'grouping',
                // 'value' => function($model){
                    // $item = MkmMasterItem::find()->select(['item_desc'])->andWhere(['item_code' => $model->orafin_code])->one();
                    // return $item->item_desc;
                // },
                'value' => 'grouping',
            ],
            'qty_request',
            [
                'header' => 'SN/Non',
                // 'format' => 'raw',
                'attribute' => 'sn_type',
                // 'value' => function($model){
                    // $item = MkmMasterItem::find()->select(['item_desc'])->andWhere(['item_code' => $model->orafin_code])->one();
                    // return $item->item_desc;
                // },
                'value' => 'description',
            ],

            // [
            //     'attribute'=>'id_inbound_grf',
            //     'value'=>'id_inbound_grf',
            // ],
            [
                'label' => 'Status',
                'format' => 'raw',
                'value' => function($model){
                    if(InboundGrfDetail::find()->where(['and',['id_inbound_grf'=>$model->id_grf]])->exists()){
                        return "<span class='label label-success'  >Closed</span>";
                    }else if(!MasterItemIm::find()->where(['orafin_code'=>$model->orafin_code])->exists() ){
                        return "<span class='label label-danger' >Not Registered</span>";
                    }       
                    else{ 
                        return "<span class='label label-primary'>Open</span>";
                    }
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{create}',
                'buttons'=>[
                    'create' => function ($url, $model) {
                        if(!InboundGrfDetail::find()->where(['and',['id_inbound_grf'=>$model->id_grf]])->exists()){
                    return Html::a('<span style="margin:0px 2px" class="label label-success">Choose</span>', '#createdetail?id='.$model->id.'&header=Detail_Material_GRF_Vendor_IKO', [
                        'title' => Yii::t('app', 'view'), 'class' => 'createsButton', 'value'=>Url::to([$this->context->id.'/createdetail', 'id' => $model->id]), 'header'=> yii::t('app','GRF Detail')
                        ]);
                    }
                },
                    // 'create' => function ($url, $model) {
                    //         if(!MasterItemIm::find()->where(['orafin_code'=>$model->orafin_code])->exists() ){
                    //             return "";
                    //         }else{
                    //             if(GrfDetail::find()->where(['and',['id_inbound_po'=>$model->id_inbound],['orafin_code'=>$model->orafin_code]])->exists()){
                    //                 return Html::a('<span style="margin:0px 2px;" class="label label-success">Choose</span>', '#update', [
                    //                     'title' => Yii::t('app', 'create'), 'class' => 'updatesButton','idInboundPo'=>$model->id_inbound,'orafinCode'=>$model->orafin_code, 'rrNumber'=>$model->rr_number, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                    //                 ]);
                    //             }else{
                    //                 return Html::a('<span style="margin:0px 2px;" class="label label-success">Choose</span>', '#', [
                    //                     'title' => Yii::t('app', 'create'), 'class' => 'createsButton', 'value'=>$model->orafin_code, 'value2'=>$model->rr_number, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                    //                 ]);
                    //             }
                    //         }   
                            
                    // },
                ],
            ],
            
        ],
    ]); ?>
    <?php yii\widgets\Pjax::end() ?>
    <?php if(($this->context->action->id == 'view' && $model->status_listing != 6) || $this->context->action->id == 'indexdetail' ){ ?>
    <p>        
        <?php if(Yii::$app->controller->action->id == 'indexdetail')
            echo Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-primary']);  ?>
         <?php if(Yii::$app->controller->action->id == 'indexdetail')
        Html::button(Yii::t('app','Submit Instruction'), ['id'=>'submitButton','class' => 'btn btn-success']); ?>        
    </p>
    <?php } ?>
</div>

<script>
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
            $('#modalHeader').html('<h3>  Detail Inbound PO </h3>');
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

</script>
