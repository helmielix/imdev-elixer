<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model setting\models\MasterItemIm */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Master Item Ims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-item-im-view">

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
            'created_by',
            'updated_by',
            'status',
            // [
            //     'label' => 'Status',
            //     'value' => function($model){
            //         return $model->partnershipStatus->description;
            //     }
            // ],
            'name',
            'brand',
            'warna',
            'created_date',
            'updated_date',
            'im_code',
            'orafin_code',
        ],
    ]) ?>

</div>
