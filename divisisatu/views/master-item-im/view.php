<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\MasterItemIm */

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
            'name',
            'brand',
            'created_date',
            'updated_date',
            'im_code',
            'orafin_code',
            'sn_type',
            'grouping',
            'warna',
            'stock_qty',
            's_good',
            's_not_good',
            's_reject',
            'type',
            's_dismantle_good',
            's_dismantle_not_good',
            's_good_recondition',
        ],
    ]) ?>

</div>
