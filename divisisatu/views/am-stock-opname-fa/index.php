<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AmStockOpnameFaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Am Stock Opname Fas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="am-stock-opname-fa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Am Stock Opname Fa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'stock_opname_number',
            'status_listing',
            'created_by',
            'updated_by',
            'id_warehouse',
            // 'pic',
            // 'cut_off_data',
            // 'file',
            // 'revision_remark:ntext',
            // 'created_date',
            // 'updated_date',
            // 'id_modul',
            // 'sto_start_date',
            // 'sto_end_date',
            // 'time_cut_off_data',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
