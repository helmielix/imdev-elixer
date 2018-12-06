<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchInboundRepairNew */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Inbound Repair News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inbound-repair-new-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Inbound Repair New'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_instruction_repair',
            'driver',
            'created_by',
            'status_listing',
            'updated_by',
            // 'forwarder',
            // 'no_sj',
            // 'plate_number',
            // 'created_date',
            // 'updated_date',
            // 'revision_remark:ntext',
            // 'id_modul',
            // 'tanggal_datang',
            // 'tagging',
            // 'file_attachment',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
