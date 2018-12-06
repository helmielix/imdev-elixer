<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model divisisatu\models\StockOpnameInternal */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Stock Opname Internals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-opname-internal-view">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    
    <?= $this->render('_form-view', [
        'model' => $model,
    ]) ?>

</div>
