<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\LogCaIomAndCity */

$this->title = $model->idlog;
$this->params['breadcrumbs'][] = ['label' => 'Log Ca Iom And Cities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-ca-iom-and-city-view">

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
            'id',
            'id_city',
            'id_ca_iom_area_expansion',
        ],
    ]) ?>

</div>
