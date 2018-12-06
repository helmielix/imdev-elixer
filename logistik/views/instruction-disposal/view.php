<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\InstructionDisposal */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instruction Disposals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instruction-disposal-view">

    <div class="row">
        <div class="col-sm-6">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'small table table-striped table-bordered detail-view'],
                'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                'attributes' => [
                    'instruction_number',
                    'buyer',
                    'warehouse',
                    'file_attachment',
                    'estimasi_disposal',
                ],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'small table table-striped table-bordered detail-view'],
                'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                'attributes' => [
                    'no_iom',
                    'date_iom',
                    'revision_remark',
                ],
            ]) ?>
        </div>
        <div class="col-sm-12">
            <?php if(Yii::$app->controller->action->id == 'view' && $model->status_listing != 6)
                echo Html::button(Yii::t('app','Update'), ['id'=>'updateButton','class' => 'btn btn-primary']); ?>
            <?php if(Yii::$app->controller->action->id == 'view' && ($model->status_listing == 1 || $model->status_listing == 6 || $model->status_listing == 7))
                echo Html::button(Yii::t('app','Delete'), ['id'=>'deleteButton','class' => 'btn btn-danger']); ?>
        </div>
    </div>
    
    <hr>
    
    <h3>Detail Warehouse Transfers Instruction</h3>
    <?= $this->render('indexdetail', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>
    
    <?php if($this->context->action->id != 'view'){ ?>

    <p> 
        <?php if(Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5)
            echo Html::button(Yii::t('app','Approve'), ['id'=>'approveButton','class' => 'btn btn-success']); ?>
        <?php if((Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5))
            echo Html::button(Yii::t('app','Revise'), ['id'=>'reviseButton','class' => 'btn btn-warning']); ?>
        <?php if((Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5))
            echo Html::button(Yii::t('app','Reject'), ['id'=>'rejectButton','class' => 'btn btn-danger']); ?>
        <?= Html::button(Yii::t('app','Close'), ['id'=>'closeButton','class' => 'btn btn-default close', 'data-dismiss' => 'modal']); ?>
    </p>
    <?php } ?>  

</div>

<script>
$('#updateButton').click(function () {
    $('#modal').modal('show')
        .find('#modalContent')
        .load('<?php echo Url::to([$this->context->id.'/update', 'id' => $model->id]) ;?>');
    $('#modalHeader').html('<h3> Update Warehouse Transfer Instruction</h3>');
});

$('#deleteButton').click(function () {
    var resp = confirm("Do you want to delete this item???");
    if (resp == true) {
        $.ajax({
             url: '<?php echo Url::to([$this->context->id.'/delete', 'id' => $model->id]) ;?>',
            type: 'post',
            success: function (response) {
                $('#modal').modal('hide');
                setPopupAlert('<?= Yii::$app->params['pesanDelete'] ?>');
            }
        });
    }else {
        return false;
    }
});

$('#approveButton').click(function () {
    var button = $(this);
    button.prop('disabled', true);
    button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
    
    $.ajax({
        url: '<?php echo Url::to([$this->context->id.'/approve', 'id' => $model->id]) ;?>',
        type: 'post',
        success: function (response) {
            $('#modal').modal('hide');
            setPopupAlert('<?= Yii::$app->params['pesanApproved'] ?>');
        },
        complete: function () {
            button.prop('disabled', false);
            $('#spinRefresh').remove();
        },
    });
});
</script>

