<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CaReference */

$this->title = 'Create Ca Reference';
$this->params['breadcrumbs'][] = ['label' => 'Ca References', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ca-reference-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
