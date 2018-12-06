<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GovrelParBbfeedPermit */

//$this->title = 'Update Govrel Par Bbfeed Permit: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Parameter PIC Backbone Feeder Permit', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="govrel-par-bbfeed-permit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
