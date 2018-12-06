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
    ]); ?>
    
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'id_item_im')->textInput(['disabled'=>true]) ?>

            <?= $form->field($model, 'orafin_code')->textInput(['disabled'=>true]) ?>

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
                                $style = ['style'=>'width:100%','id'=>'idreqgoodqty'];
                               if(Yii::$app->controller->action->id == 'updatedetail' && isset($arrQtyDetail[$model->im_code][0])){
                                   $model->qty_good = $arrQtyDetail[0];
                               }else {
                                   $model->qty_good = null;
                               }
                                return Html::textInput('qty_good[]', $model->qty_good);
                            }
                    ],
                    [
                        'attribute'=>'qty_not_good',
                        'format' => 'raw',
                        'label'=>'Good',
                          'headerOptions' => ['style' => 'width:10%'],
                            'value' => function ($model) use ($arrQtyDetail)
                            {
                                $style = ['style'=>'width:100%','id'=>'idreqnotgoodqty'];
                               if(Yii::$app->controller->action->id == 'updatedetail' && isset($arrQtyDetail[$model->im_code][0])){
                                   $model->qty_not_good = $arrQtyDetail[1];
                               }else {
                                   $model->qty_not_good = null;
                               }
                                return Html::textInput('qty_not_good[]', $model->qty_not_good);
                            }
                    ],
                    [
                        'attribute'=>'qty_reject',
                        'format' => 'raw',
                        'label'=>'Good',
                          'headerOptions' => ['style' => 'width:10%'],
                            'value' => function ($model) use ($arrQtyDetail)
                            {
                                $style = ['style'=>'width:100%','id'=>'idreqrejectqty'];
                               if(Yii::$app->controller->action->id == 'updatedetail' && isset($arrQtyDetail[$model->im_code][0])){
                                   $model->qty_reject = $arrQtyDetail[3];
                               }else {
                                   $model->qty_reject = null;
                               }
                                return Html::textInput('qty_reject[]', $model->qty_reject);
                            }
                    ],
                
                ],
            ]); ?>
        </div>
    </div>

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
        var form = $('#createForm');
        data = form.data("yiiActiveForm");
        $.each(data.attributes, function() {
            this.status = 3;
        });
        form.yiiActiveForm("validate");
        if (!form.find('.has-error').length) {
            var button = $(this);
            button.prop('disabled', true);
            button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
            $.ajax({
                url: '<?php echo Url::to(['/inbound-po/'.$this->context->action->id, 'id' => $model->id, 'idInboundPo' => $model->id_inbound_po]) ;?>',
                type: 'post',
                data: form.serialize(),
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