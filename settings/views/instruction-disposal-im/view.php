<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\InstructionDisposalIm */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instruction Disposal Im', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="instruction-disposal-im-view">

    <div class="row">
        <div class="col-sm-6">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'small table table-striped table-bordered detail-view'],
                'template' => '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                'attributes' => [
                    'idDisposalAm.instruction_number',
                    'idDisposalAm.buyer',
                    'idDisposalAm.warehouse',
                    'idDisposalAm.file_attachment',
                    'idDisposalAm.estimasi_disposal',
                    'idDisposalAm.no_iom',
                    'idDisposalAm.date_iom:date',
                ],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
        <div class="col-sm-12">
            <?php if(Yii::$app->controller->action->id == 'view' && $model->status_listing != 6)
                //echo Html::button(Yii::t('app','Update'), ['id'=>'updateButton','class' => 'btn btn-primary']); ?>
            <?php if(Yii::$app->controller->action->id == 'view' && ($model->status_listing == 1 || $model->status_listing == 6 || $model->status_listing == 7))
                //echo Html::button(Yii::t('app','Delete'), ['id'=>'deleteButton','class' => 'btn btn-danger']); ?>
        </div>
    </div>
    
    <?php if($this->context->action->id != 'view'){ ?>
    <p> 
        <?php if(Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5)
            echo Html::button(Yii::t('app','Approve'), ['id'=>'approveButton','class' => 'btn btn-success']); ?>
        <?php if((Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5))
            echo Html::button(Yii::t('app','Revise'), ['id'=>'reviseButton','class' => 'btn btn-warning']); ?>
        <?php if((Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5))
            echo Html::button(Yii::t('app','Reject'), ['id'=>'rejectButton','class' => 'btn btn-danger']); ?>
    </p>
    <?php } ?>  


</div>