<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\InboundRepairNew */

$this->title = $model->id_instruction_repair;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inbound Repair News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inbound-repair-new-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id_instruction_repair], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_instruction_repair], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_instruction_repair',
            'driver',
            'created_by',
            'status_listing',
            'updated_by',
            'forwarder',
            'no_sj',
            'plate_number',
            'created_date',
            'updated_date',
            'revision_remark:ntext',
            'id_modul',
            'tanggal_datang',
            'tagging',
            'file_attachment',
        ],
    ]) ?>

</div>
