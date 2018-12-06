<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ParameterMasterItem */

$this->title = 'Update Parameter Master Item: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Parameter Master Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="parameter-master-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
