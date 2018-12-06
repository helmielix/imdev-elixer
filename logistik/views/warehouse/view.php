<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\Warehouse */

$this->title = 'Warehouse '.$model->nama_warehouse;
$this->params['breadcrumbs'][] = ['label' => 'Warehouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warehouse-view">

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
            'nama_warehouse',
            'id_region',
            'pic',
            'id_divisi',
            'alamat',
            'note:ntext',
        ],
    ]) ?>
	
	<?php Pjax::begin(); ?>    
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],
				
				// 'id_warehouse',
				// 'id_user',
				[
					'attribute' => 'id_warehouse',
					'value' => function($datamodel) use ($model){
						return $model->nama_warehouse;
					},
					'filter' => null,
				],
				[
					'attribute' => 'id_user',
					'value' => function($datamodel){
						return $datamodel->iduser->username;
					},
				],

			],
		]); ?>
	<?php Pjax::end(); ?>

</div>
