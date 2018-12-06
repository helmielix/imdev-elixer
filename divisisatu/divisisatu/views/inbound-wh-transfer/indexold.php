<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SearchOutboundWhTransfer */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Outbound Wh Transfers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outbound-wh-transfer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Outbound Wh Transfer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_instruction_wh',
            'driver',
            'created_by',
            'status_listing',
            'updated_by',
            // 'forwarder',
            // 'surat_jalan_number',
            // 'plate_number',
            // 'created_date',
            // 'updated_date',
            // 'revision_remark:ntext',
            // 'id_modul',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
