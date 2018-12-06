<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model instruction\models\InstructionDisposal */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instruction Disposals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instruction-disposal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'created_by',
            'updated_by',
            'status_listing',
            'no_iom',
            'warehouse',
            'buyer',
            'created_date',
            'updated_date',
            'target_implementation',
            'revision_remark:ntext',
            'id',
        ],
    ]) ?>

</div>
