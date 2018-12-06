<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\InstructionDisposalDetailIm */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Instruction Disposal Detail Ims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instruction-disposal-detail-im-view">

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
            'id',
            'id_disposal_im',
            'id_item_im',
            'id_disposal_detail',
            'created_by',
            'req_good',
            'req_not_good',
            'req_reject',
            'req_good_dismantle',
            'req_not_good_dismantle',
        ],
    ]) ?>

</div>
