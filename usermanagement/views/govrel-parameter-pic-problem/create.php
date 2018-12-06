<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GovrelParameterPicProblem */

//$this->title = 'Create Govrel Parameter Pic Problem';
$this->params['breadcrumbs'][] = ['label' => 'Govrel Parameter Pic Problem', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="govrel-parameter-pic-problem-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
