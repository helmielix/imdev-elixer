<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CaIomAreaExpansion */

$this->title = 'Update IOM Area Expansion: ' . $model->no_iom_area_exp;
$this->params['breadcrumbs'][] = ['label' => 'Ca Iom Area Expansions', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ca-iom-area-expansion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
