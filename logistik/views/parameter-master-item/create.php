<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ParameterMasterItem */

$this->title = 'Create Parameter Master Item';
$this->params['breadcrumbs'][] = ['label' => 'Parameter Master Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parameter-master-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
