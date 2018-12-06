<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\searchInstructionDisposalDetailIm */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Instruction Disposal Detail Ims';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="instruction-disposal-detail-im-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Instruction Disposal Detail Im', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_disposal_im',
            'id_item_im',
            'id_disposal_detail',
            'created_by',
            // 'req_good',
            // 'req_not_good',
            // 'req_reject',
            // 'req_good_dismantle',
            // 'req_not_good_dismantle',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
