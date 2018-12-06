<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AmStockOpnameFa */

$this->title = 'Create Am Stock Opname Fa';
$this->params['breadcrumbs'][] = ['label' => 'Am Stock Opname Fas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="am-stock-opname-fa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
