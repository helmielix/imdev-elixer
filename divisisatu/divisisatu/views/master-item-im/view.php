<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

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
            'orafin_code',
            'im_code',
            'name',
			[
				'attribute' => 'sn_type',
				'value' => $model->referenceSn->description,
			],
			[
				'attribute' => 'grouping',
				'value' => $model->referenceGrouping->description,
			],
			[
				'attribute' => 'brand',
				'value' => $model->referenceBrand->description,
			],
			[
				'attribute' => 'warna',
				'value' => $model->referenceWarna->description,
			],
			[
				'attribute' => 'type',
				'value' => $model->referenceType->description,
			],
            [
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status0->status_listing;
                }
            ],
			[
                'attribute' => 'created_by',
                'value' => function($model){
                    return User::findIdentity($model->created_by)->name;
                }
            ],
			[
                'attribute' => 'updated_by',
                'value' => function($model){
                    return User::findIdentity($model->updated_by)->name;
                }
            ],
            
            
            'created_date:date',
            'updated_date:date',
        ],
    ]) ?>

</div>
