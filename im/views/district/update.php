<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DISTRICT */

$this->title = 'Update District: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Districts', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="district-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelRegion' => $modelRegion,
    ]) ?>

</div>
