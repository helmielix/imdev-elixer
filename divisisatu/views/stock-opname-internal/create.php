<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model divisisatu\models\StockOpnameInternal */

$this->title = 'Create Stock Opname Internal';
$this->params['breadcrumbs'][] = ['label' => 'Stock Opname Internals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-opname-internal-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,

    ]) ?>

</div>
