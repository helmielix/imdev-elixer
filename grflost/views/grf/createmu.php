<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Reference;
use common\models\StatusReference;

/* @var $this yii\web\View */
/* @var $model common\models\OutboundWhTransfer */

$this->title = $model->id_instruction_grf;
$this->params['breadcrumbs'][] = ['label' => 'Outbound Grf', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
// $datasession = Yii::$app->session->get('detailoutbound');
?>
<div class="outbound-grf-view">

    <div class="row">
        <div>
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'small table table-striped table-bordered detail-view'],
                'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                'attributes' => [
                    
                    [
                        'label' => 'Nomor Surat Jalan',
                        'attribute' => 'no_sj',
                    ],
                    [
                        'label' => ' Nomor GRF',
                        'attribute' => 'grf_number',
                        // 'visible' => is_string($model->no_sj),
                    ],
                    [
                        'attribute' => 'wo_number',
                    ],

                    [
                        'attribute' => 'grf_type',
                        'value' => function($model){
                            if($model->grfType)return $model->grfType->description;
                        }
                    ]
                ],
            ]) ?>
        </div>
       
        <div class="col-sm-12">
            <?php if(Yii::$app->controller->action->id == 'view' && $model->status_listing != 6)
                //echo Html::button(Yii::t('app','Update'), ['id'=>'updateButton','class' => 'btn btn-primary']); ?>
            <?php if(Yii::$app->controller->action->id == 'view' && ($model->status_listing == 1 || $model->status_listing == 6 || $model->status_listing == 7))
                //echo Html::button(Yii::t('app','Delete'), ['id'=>'deleteButton','class' => 'btn btn-danger']); ?>
        </div>
    </div>

    <hr>
  <div class="alert hidden" id="errorSummary">Please fix these following error: <ul id="ulerrorSummary"></ul></div>
    <?php 
    Pjax::begin(['id' => 'pjaxviewdetail', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']]) 
    // Pjax::begin()
    ?>
    <?= GridView::widget([
        'id' => 'gridViewdetail',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['style' => 'overflow-x:scroll'],
        'summary' => false,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            
            'im_code',
            'name',
            'brand',
            [
                'label' => 'Type',
                'attribute'=>'grouping',
            ],
            'warna',
            [
                'attribute'=>'sn_type',
                'value'=>'sn_type',
            ],
            [
                'attribute' => 'type',
                'label'=> 'Uom',
            ],
            'qty_request',
            // 'id_grf_detail',
            [
                'attribute' => 'id_grf_detail',
                'format' => 'raw',
                'label' => '',
                'value' => function ($model){

                    return $out = Html::hiddenInput('id_grf_detail[]', $model->id_grf_detail, ['class' => 'id']);
                    
                },
            ],
            // [
            //     'attribute' => 'sn_type',
            //     'value' => function ($model){
            //         return Reference::findOne($model->sn_type)->description;
            //     },
            //     'filter' => ArrayHelper::map( Reference::find()->andWhere(['table_relation' => 'sn_type'])->all(),'id','description'  ),
            // ],
            // 'req_qty',
            
            [
                'attribute' => 'qty_used',
                'format' => 'raw',
                'value' => function ($model){
                    $val = '';
                    if ($model->qty_used){
                        $val = $model->qty_used;
                    }
                    $out = Html::textInput('qty_used[]', $val, ['class' => 'form-control input-sm', 'dataim' => 'qty_used', 'qtyreturn' => $model->qty_used]);

                    return $out.Html::hiddenInput('orafin_code[]', $model->orafin_code, ['class' => 'orafin_code']);

                },
            ],

            [
                'attribute' => 'delta',
                'value' => function ($model){
                    $val = 0;
                    if ($model->qty_used){
                        $val = $model->qty_used;
                    }
                    return $model->qty_request - $val;
                },
            ], 
            // [
            //     'attribute' => 'status_return',
            //     'value' => 'idInstructionGrf.idGrf.idGrfDetail.statusReturn.status_listing',
            //     'filter' => ArrayHelper::map( StatusReference::find()->andWhere(['id' => [31, 36]])->all(),'id','status_listing'  ),
            // ],

            
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    
    <p>
        <!-- <?php if(Yii::$app->controller->action->id == 'createmu')
            echo Html::button(Yii::t('app','Report to IC'), ['id'=>'reportButton','class' => 'btn btn-warning']); ?> -->
        <?php if(Yii::$app->controller->action->id == 'createmu')
            echo Html::button(Yii::t('app','Submit'), ['id'=>'inputButton','class' => 'btn btn-success']); ?>
        
        <?php if(Yii::$app->controller->action->id == 'viewmu')
            echo Html::button(Yii::t('app','Update'), ['id'=>'updateButton','class' => 'btn btn-success']); ?>

        <?php if(Yii::$app->controller->action->id == 'viewmu')
            echo Html::button(Yii::t('app','Print Material Return Form'), ['id'=>'exportButton','class' => 'btn btn-primary']); ?>

        
        <?php if(Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5)
            echo Html::button(Yii::t('app','Approve'), ['id'=>'approveButton','class' => 'btn btn-success']); ?>
        <?php if(Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5)
            echo Html::button(Yii::t('app','Revise'), ['id'=>'reviseButton','class' => 'btn btn-warning']); ?>
        
           

    </p>
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'id' => 'submitForm',
        'layout' => 'horizontal',
        'options' => [
            'style' => 'display:none;'
        ],
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-1',
                'offset' => 'col-sm-offset-1',
                'wrapper' => 'col-sm-6',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); 
    $model->revision_remark = '';
    ?>

    <br />
    <?= $form->field($model, 'revision_remark')->textarea(['rows' => '5']) ?>
    <?= Html::button(\Yii::t('app','Submit Remark'), ['id'=>'submitButton','class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
    
</div>
<script>
    $('table').on('blur', '.input-sm', function(){
        var input = $(this);
        var currentRow = input.closest('tr');
        
        var val = parseInt( input.val() );
        
        iditem = currentRow.find('td:eq(10)').find('.orafin_code').val();
        iditem = iditem.split(';');
        
        stock = currentRow.find('td:eq(8)').text();
                
        count = stock - val;
        if (count < 0){
            alert('<?= $model->getAttributeLabel('qty_used') ?> more than Request Qty.');
            input.val(stock);
            val = stock;
            count = stock - val;
        }else if (isNaN(count)){
            val = 0;
            input.val(val);
            currentRow.find('td:eq(11)').text(stock);
            return false;
        }
        
        currentRow.find('td:eq(11)').text(count);
        
        $.post( '<?= Url::to([$this->context->id.'/createdetail']) ?>', {id: iditem[0], val: val });
    });
    
    $('#reportButton').click(function () {
        selectedAction = 'report';
        pesan = '<?= Yii::$app->params['pesanReporttoIC'] ?>';
        $('#submitForm').show();
    });
    
    $('#updateButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-wh-transfer/update', 'idOutboundWh'=>$model->id_outbound_grf]) ;?>');
        $('#modalHeader').html('<h3> Update Detail Inbound PO </h3>');
    });
    
    $('#submitButton').click(function () {
        var resp = confirm("Do you want to revise this item?");
        

        if (resp == true) {
            console.log('aa');
            console.log(selectedAction);
            var form = $('#gridViewdetail-container');
            data = new FormData();
            form.find('input:hidden, input:text')
                .each(function(){
                    name = $(this).attr('name');
                    val = $(this).val();
                    data.append(name, val);
                });
            if ( $( '#inboundwhtransfer-revision_remark' ).val() == '' ){
                alert('Revision remark can not be blank');
                return false;
            }
            data.append( 'InboundWhTransfer[revision_remark]', $( '#inboundwhtransfer-revision_remark' ).val() );

            url = '<?php echo Url::to(['/inbound-wh-transfer/reporttoic', 'id' => $model->id_outbound_grf]) ;?>';
            console.log(url);
            if (!form.find('.has-error').length) {
                var button = $(this);
                button.prop('disabled', true);
                button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
                
                $.ajax({
                    url: url,
                    type: 'post',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if(response == 'success') {
                            $('#modal').modal('hide');
                            setPopupAlert(pesan);
                        } else {
                            alert('error with message: ' + response);
                        }
                    },
                    complete: function () {
                        button.prop('disabled', false);
                        $('#spinRefresh').remove();
                    },                  
                });
            };
        } else {
            return false;
        }
    });
    
    $('#inputButton').click(function () {
        var form = $('#gridViewdetail-container');
        data = new FormData();
        // data.append('arrival_date', $('#arrival_date-id').val() );
        form.find('input:hidden, input:text')
            .each(function(){
                name = $(this).attr('name');
                val = $(this).val();
                console.log(name);
                console.log(val);
                data.append(name, val);
            });
        
        var button = $(this);
        button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
        
        $('#errorSummary').addClass('hidden');
        $('#ulerrorSummary li').remove();
        $('tr[data-key').removeClass('info');       
        
        $.ajax({
            url: '<?php echo Url::to([$this->context->id.'/createmu', 'id' => $model->id_instruction_grf]) ;?>',
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
            // dataType: 'json',
            success: function (response) {
                if(response == 'success') {
                    $('#modal').modal('hide');
                } else {
                    alert('error with message: ' + response);
                    // pesan = response.pesan;
                    // pesan = pesan.split('\n');
                    // $('#errorSummary').addClass('alert-danger').removeClass('hidden');
                    // for(i = 0; i < pesan.length; i++){
                        // $('#ulerrorSummary').append('<li>'+pesan[i]+'</li>');
                    // }
                    // $('tr[data-key='+response.id+']').addClass('info');
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
    
    $('#approveButton').click(function () {
        $.ajax({
            url: '<?php echo Url::to(['/inbound-wh-transfer/approve', 'id' => $model->id_outbound_grf]) ;?>',
            type: 'post',
            async:true,
            success: function (response) {
                $('#modal').modal('hide');
                setPopupAlert('Data has been approved.');
            }
        });
    });

    $('.uploadButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-wh-transfer/uploadsn']) ;?>?id='+$(this).attr('value'));
        $('#modalHeader').html('<h3> Upload Serial Number </h3>');
    });
    
    $('.viewButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/inbound-wh-transfer/viewdetailsn']) ;?>?idInboundPoDetail='+$(this).attr('value'));
        $('#modalHeader').html('<h3> Detail Serial Number </h3>');
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