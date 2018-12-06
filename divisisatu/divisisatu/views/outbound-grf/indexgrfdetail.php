<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\MkmMasterItem;
use common\models\InstructionGrfDetail;
use yii\helpers\ArrayHelper;
use common\models\Reference;
use common\models\OutboundGrfDetailSn;

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs(
"
    $('.viewButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
        $('#modalHeader').html('<h3> '+ $(this).attr('header') +'</h3>');
    });
", \yii\web\View::POS_END);
?>
<div class="outbound-Grf-detail-index">

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
            [
                'attribute' => 'status_listing',
                'format' => 'raw',
                'value' => function ($dataProvider) {
                    if($dataProvider->status_listing == 999){
                        return "<span class='label' style='background-color:{$dataProvider->statusReference->status_color}' >Not Registered</span>";
                    }else{
                        return "<span class='label' style='background-color:{$dataProvider->statusReference->status_color}' >{$dataProvider->statusReference->status_listing}</span>";
                    }
                },
                'visible' => $this->context->action->id == 'create' || $this->context->action->id == 'restore',
            ],
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{create} {view} {restore}',
                'buttons'=>[
                    'create' => function ($url, $model) {
                        if($model->status_listing == 999 || $model->status_listing == 43){
                            return Html::a('<span style="margin:0px 2px;" class="label label-success">Upload SN</span>', '#', [
                                'title' => Yii::t('app', 'upload'), 'class' => 'viewButton', 'value'=> Url::to([$this->context->id.'/uploadsn', 'id' => $model->id, 'idOutboundGrf' => $model->id_outbound_grf]), 'idOutboundGrf' => $model->id_outbound_grf, 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        }
                    },
                    
                    'view' => function ($url, $model) {
                        if(($model->status_listing == 41 || $model->status_listing == 43) && ($this->context->action->id != 'viewprintsj' && $this->context->action->id != 'exportpdf')){
                            // if ($model->idMasterItemImDetail->idMasterItemIm->sn_type == 2){
                            //     return '';
                            // }
                            return Html::a('<span style="margin:0px 2px;" class="label label-info">View</span>', '#', [
                                'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/viewdetailsn', 'idOutboundGrfDetail' => $model->id]), 'header'=> yii::t('app','Detail Serial Number')
                            ]);
                        }
                    },
                    
                    'restore' => function ($url, $model){
                        if ( $this->context->action->id != 'create' && $this->context->action->id != 'restore' ){
                            return '';
                        }
                        if(($model->status_listing == 41 || $model->status_listing == 43) && ($this->context->action->id != 'viewprintsj' && $this->context->action->id != 'exportpdf')){
                            $count = OutboundGrfDetailSn::find()->andWhere(['id_outbound_grf_detail' => $model->id])->count();
                            // if ($model->idMasterItemImDetail->idMasterItemIm->sn_type == 2){
                            //     return '';
                            // }
                            if ($count == 0){
                                return '';
                            }
                            return Html::a('<span style="margin:0px 2px;" class="label label-danger"> <i class="fa fa-undo fa-flip-horizontal"></i> </span>', '#', [
                                'title' => Yii::t('app', 'restore'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/restore', 'idOutboundGrfDetail' => $model->id, 'id' => $model->id_outbound_grf]), 'header'=> yii::t('app','Create Tag SN')
                            ]);
                        }
                    },
                ],
                'visible' => $this->context->action->id != 'exportpdf' && $this->context->action->id != 'viewprintsj',
            ],   
        ],
    ]); ?>
    <?php yii\widgets\Pjax::end() ?>
    <p>        
        <?php if(Yii::$app->controller->action->id == 'indexgrfdetail')
            echo Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-success']);  
        
        
        if(Yii::$app->controller->action->id != 'viewapprove'){
            switch(Yii::$app->controller->action->id){
                case 'create': case 'restore':
                    $actionName = 'Submit SN';
                    $idbutton = 'submitButton';
                break;
                case 'view':
                    $actionName = 'Submit';
                    $idbutton = 'submitSjButton';
                break;
                case 'viewprintsj':
                    $actionName = 'Print PDF';
                    $idbutton = 'exportButton';
                break;
                case 'exportpdf':
                    $actionName = '';
                    $idbutton = 'exportButton';
                break;
            }
            ?>
            
            <?= Html::button(Yii::t('app',$actionName), ['id'=>$idbutton,'class' => 'btn btn-success']) ?>
            
        <?php } ?>
    </p>
</div>

<script>   
    $('.fa-undo').click(function(){
        $(this).addClass('fa-spin');
        
    });
    $('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id.'/update','id'=>Yii::$app->session->get('idInstructionGrf')]) ;?>');
        $('#modalHeader').html('<h3> Detail Instruction Grf </h3>');
    });
    
    $('#exportButton').click(function () {
        var hot = $('#handover_time').val();
        console.log(hot);
        // return false;
        // window.open("<?php echo Url::to([$this->context->id.'/exportpdf', 'id' => $model->id_instruction_grf]) ?>", "_blank");
        
        var button = $(this);
        button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
        
        data = new FormData();
        data.append( 'time', $( '#handover_time' ).val() );
        
        $.ajax({
            url: '<?php echo Url::to([$this->context->id.'/savehandovertime', 'id' => $model->id_instruction_grf]) ;?>',
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                if(response == 'success') {
                    window.open("<?php echo Url::to([$this->context->id.'/exportpdf', 'id' => $model->id_instruction_grf]) ?>", "_blank");
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

</script>