<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchGovrelParameterReminder */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Govrel Parameter Reminders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="govrel-parameter-reminder-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Govrel Parameter Reminder', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'type',
			'day',
			
           // 'created_date',
            //'updated_date',
           //'updated_by',
            // 'created_by',
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
