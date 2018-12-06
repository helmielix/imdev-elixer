<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GovrelParameterReminder */

$this->title = 'Create Govrel Parameter Reminder';
$this->params['breadcrumbs'][] = ['label' => 'Govrel Parameter Reminders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="govrel-parameter-reminder-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
