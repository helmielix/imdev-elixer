<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OutboundWhTransfer */

$this->title = 'Create Outbound Wh Transfer';
$this->params['breadcrumbs'][] = ['label' => 'Outbound Wh Transfers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outbound-wh-transfer-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
		'searchModel' => $searchModel,
		'dataProvider' => $dataProvider,
    ]) ?>

</div>
