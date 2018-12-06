<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LogCaBaSurvey */

$this->title = $model->idlog;
$this->params['breadcrumbs'][] = ['label' => 'Log Ca Ba Surveys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-ca-ba-survey-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idlog], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idlog], [
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
            'idlog',
            'id_area',
            'qty_hp_pot',
            'notes:ntext',
            'survey_date',
            'created_by',
            'created_date',
            'updated_by',
            'updated_date',
            'status_listing',
            'status_iom',
            'iom_type',
            'potency_type',
            'no_iom',
            'avr_occupancy_rate',
            'id',
            'property_area_type',
            'house_type',
            'myr_population_hv',
            'dev_method',
            'access_to_sell',
            'occupancy_use_dth',
            'competitors',
            'location_description',
            'pic_survey',
            'contact_survey',
            'pic_iom_special',
            'revision_remark:ntext',
            'qty_soho_pot',
            'doc_file',
            'iom_file',
            'xls_file',
            'geom',
            'pdf_file',
            'status_presurvey',
        ],
    ]) ?>

</div>
