<?php

use yii\helpers\Html;


$this->title = 'Create Subdistrict';
$this->params['breadcrumbs'][] = ['label' => 'Subdistricts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subdistrict-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'modelRegion' => $modelRegion,
		'modelCity' => $modelCity,
    ]) ?>

</div>
