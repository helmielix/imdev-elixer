<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CaIomAreaExpansion */

$this->title = 'Create IOM Area Expansion';
$this->params['breadcrumbs'][] = ['label' => 'Ca Iom Area Expansions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ca-iom-area-expansion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
