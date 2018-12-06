<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GovrelParBbfeedPermit */

//$this->title = 'Create Govrel Par Bbfeed Permit';
$this->params['breadcrumbs'][] = ['label' => 'Parameter PIC Backbone Feeder Permit', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="govrel-par-bbfeed-permit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
