<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Homepass */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Homepasses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="homepass-view">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            //'status_ca',
            'potency_type',
            'iom_type',
           // 'status_govrel',
           // 'status_iko',
            'home_number',
            'hp_type',
          //  'status',
            // 'id_ca_ba_survey',
            // 'id_govrel_ba_distribution',
            'id_planning_iko_bas_plan',
            'streetname',
            'kodepos',
        ],
    ]) ?>

</div>
