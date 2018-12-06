<?php

use yii\helpers\Html;

$this->title = 'Update Subdistrict: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Subdistricts', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="subdistrict-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'modelRegion' => $modelRegion,
		'modelCity' => $modelCity,
    ]) ?>

</div>
