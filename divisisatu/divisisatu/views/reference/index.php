<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\Reference;

/* @var $this yii\web\View */
/* @var $searchModel setting\models\searchReference */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'References';
$this->params['breadcrumbs'][] = $this->title;

$table_relationfilter = ArrayHelper :: map ( Reference :: find()->all(), 'table_relation','table_relation');
?>
<div class="reference-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Reference', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'id_grouping',
            'description',
            
			[
				'attribute' => 'table_relation',
				'filter' => $table_relationfilter
			],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
