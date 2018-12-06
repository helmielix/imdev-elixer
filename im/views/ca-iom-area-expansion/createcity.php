<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\IOMANDCITY */

$this->title = 'Add City to IOM';
$this->params['breadcrumbs'][] = ['label' => 'Iomandcities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="iomandcity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formcity', [
        'model' => $model,
		'modelProvince' => $modelProvince,
		'modelRegion' => $modelRegion,
    ]) ?>

</div>
