<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchWarehouse */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Warehouse';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warehouse-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p class='pull-right'>
        <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
				'class' => 'yii\grid\ActionColumn',
				'template'=>'{view} {update} {userwarehouse} {delete}',
                'buttons'=>[
                    'userwarehouse' => function ($url, $model) {
						return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-link"></span>', 'userwarehouse?idwarehouse='.$model->id.'&header=Mapping_Warehouse_to_User', [
							'title' => Yii::t('app', 'Link to User'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/userwarehouse','idwarehouse' => $model->id]), 'header'=> yii::t('app','Mapping Warehouse to User')  
						]);
                    },
                ],
			],
            
            'nama_warehouse',
            'pic',
            'id_region',
            'id_divisi',
            'alamat',
            // 'id_warehouse',
            // 'note:ntext',

        ],
    ]); ?>
<?php Pjax::end(); ?></div>
