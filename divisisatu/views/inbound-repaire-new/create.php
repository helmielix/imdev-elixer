<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\InboundRepairNew */

$this->title = Yii::t('app', 'Create Inbound Repair New');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inbound Repair News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inbound-repair-new-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
