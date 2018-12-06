<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\InboundGrf */

$this->title = 'Create Inbound Grf';
$this->params['breadcrumbs'][] = ['label' => 'Inbound Grves', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inbound-grf-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
