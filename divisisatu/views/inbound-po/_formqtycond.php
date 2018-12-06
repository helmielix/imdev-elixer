<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

use common\models\Reference;
/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */

// $this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inbound Pos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$isDisabled = true;
if($this->context->action->id == 'qtycond'){
    $isDisabled = false;
}
$arrQtyDetail = '';
?>
<div class="inbound-po-viewqtycond">

	<?php if (Yii::$app->controller->action->id == 'qtycond' || Yii::$app->controller->action->id == 'viewqtycond'){
        $arrQtyDetail = Yii::$app->session->get('countQtycond');
            // $idForm = 'saveForm';
        // print_r($arrQtyDetail['OM119-07.053.123'][0]);
    }
    ?>
	
	<?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'id' => 'updateForm',
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
    ]); ?>
    
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model->itemIm, 'name')->textInput(['disabled'=>true]) ?>

            <?= $form->field($model->itemIm, 'im_code')->textInput(['disabled'=>true]) ?>

            <?= $form->field($model->itemIm->referenceGrouping, 'description')->textInput(['disabled'=>true]) ?>

            <?= $form->field($model, 'qty')->textInput(['disabled'=>true]) ?>

           
        </div>
        <div class="col-lg-6">
            <?= $form->field($model->itemIm->referenceBrand, 'description')->textInput(['disabled'=>true]) ?>

            <?= $form->field($model->itemIm->referenceType, 'description')->textInput(['disabled'=>true]) ?>

            <?= $form->field($model->itemIm->referenceWarna, 'description')->textInput(['disabled'=>true]) ?>
        </div>
    </div>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'id' => 'gridViewdetail',
                'columns' => [

                    [
                        'attribute'=>'qty_good',
                        'format' => 'raw',
                        'label'=>'Good',
                          'headerOptions' => ['style' => 'width:10%'],
                            'value' => function ($model) use ($arrQtyDetail)
                            {
                                   // print_r($arrQtyDetail);
                                  // print_r($model->im_code);
                                $style = ['style'=>'width:100%','id'=>'idreqgoodqty'];
                               if(!empty($arrQtyDetail[$model->im_code][0])){
                                   $model->qty_good = $arrQtyDetail[$model->im_code][0];
                               }else {
                                   $model->qty_good = null;
                               }
                               if($this->context->action->id != 'qtycond'){
                                    return $model->qty_good;
                               }else{
                                    return Html::textInput('qty_good', $model->qty_good);
                               }
                                
                            }
                    ],
                    [
                        'attribute'=>'qty_not_good',
                        'format' => 'raw',
                        'label'=>'Not Good',
                          'headerOptions' => ['style' => 'width:10%'],
                            'value' => function ($model) use ($arrQtyDetail)
                            {
                                $style = ['style'=>'width:100%','id'=>'idreqnotgoodqty'];
                               if( isset($arrQtyDetail[$model->im_code][1])){
                                   $model->qty_not_good = $arrQtyDetail[$model->im_code][1];
                               }else {
                                   $model->qty_not_good = null;
                               }

                               if($this->context->action->id != 'qtycond'){
                                    return $model->qty_not_good;
                               }else{
                                    return Html::textInput('qty_not_good', $model->qty_not_good);
                               }
                            }
                    ],
                    [
                        'attribute'=>'qty_reject',
                        'format' => 'raw',
                        'label'=>'Reject',
                          'headerOptions' => ['style' => 'width:10%'],
                            'value' => function ($model) use ($arrQtyDetail)
                            {
                                $style = ['style'=>'width:100%','id'=>'idreqrejectqty'];
                               if( isset($arrQtyDetail[$model->im_code][2])){
                                   $model->qty_reject = $arrQtyDetail[$model->im_code][2];
                               }else {
                                   $model->qty_reject = null;
                               }
                               if($this->context->action->id != 'qtycond'){
                                    return $model->qty_reject;
                               }else{
                                    return Html::textInput('qty_reject', $model->qty_reject);
                               }
                                
                            }
                    ],
                    [
                        'attribute' => 'qty',
                        'format' => 'raw',
                        'value' => function ($model){
                            return Html::hiddenInput('qty', $model->qty);
                        },
                        'label' => ''
                    ],
                
                ],
            ]); ?>
        
    

    <div class="form-group">
        <label class='control-label col-sm-4'> </label>
        <div class='col-sm-6'>
            <?=  Html::button('Previous', ['id'=>'prevButton','class'=>'btn btn-success']) ; ?>

            <?php if($this->context->action->id == 'qtycond') { ?>
            <?= Html::button('Update', ['id'=>'createButton','class' => 'btn btn-success']) ?>
            <?php } ?>
            <?= Html::button('Submitting...', ['id'=>'loadingButton','class' => 'btn btn-secondary', 'style'=>'display:none']) ?>
            
        </div>

    </div>
	<?php ActiveForm::end(); ?>
	
</div>
<script>
    $('#createButton').click(function (event) {
        // event.stopPropagation();
        
        var form = $('#gridViewdetail-container');
        data = new FormData();
        form.find('input:hidden, input:text')
            .each(function(){
                name = $(this).attr('name');
                val = $(this).val();
                data.append(name, val);
            });
        if (!form.find('.has-error').length) {
            var button = $(this);
            button.prop('disabled', true);
            button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
            $.ajax({
                url: '<?php echo Url::to(['/inbound-po/'.$this->context->action->id, 'id' => $model->id, 'idInboundPo' => $model->id_inbound_po]) ;?>',
                type: 'post',
                data: data,
                processData: false,
                contentType: false,
                success: function (response) {
                    if(response == 'success') {
                        $('#modal').modal('show')
                            .find('#modalContent')
                            .load('<?php echo Url::to(['/'.\Yii::$app->controller->id.'/viewsn']) ;?>');
                        $('#modalHeader').html('<h3> Inbound PO</h3>');
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

    $('#prevButton').click(function (){
        <?php if(\Yii::$app->controller->id == 'inbound-po'){ ?>
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/'.\Yii::$app->controller->id.'/viewsn']) ;?>');
        $('#modalHeader').html('<h3>Detail Inbound PO</h3>');
        
        <?php } ?>
        
    });
</script>