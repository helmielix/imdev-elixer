<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CaReference */

$this->title = 'Update Ca Reference: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ca References', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ca-reference-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
