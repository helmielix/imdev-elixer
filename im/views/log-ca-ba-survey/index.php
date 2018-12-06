<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchLogCaBaSurvey */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Ca Ba Surveys';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-ca-ba-survey-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Log Ca Ba Survey', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idlog',
            'id_area',
            'qty_hp_pot',
            'notes:ntext',
            'survey_date',
            // 'created_by',
            // 'created_date',
            // 'updated_by',
            // 'updated_date',
            // 'status_listing',
            // 'status_iom',
            // 'iom_type',
            // 'potency_type',
            // 'no_iom',
            // 'avr_occupancy_rate',
            // 'id',
            // 'property_area_type',
            // 'house_type',
            // 'myr_population_hv',
            // 'dev_method',
            // 'access_to_sell',
            // 'occupancy_use_dth',
            // 'competitors',
            // 'location_description',
            // 'pic_survey',
            // 'contact_survey',
            // 'pic_iom_special',
            // 'revision_remark:ntext',
            // 'qty_soho_pot',
            // 'doc_file',
            // 'iom_file',
            // 'xls_file',
            // 'geom',
            // 'pdf_file',
            // 'status_presurvey',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
