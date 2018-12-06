<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model instruction\models\InstructionDisposal */

$this->title = 'Disposal Instruction';
?>
<div class="instruction-disposal-create">

    <h2><?= Html::encode("Create ".$this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
