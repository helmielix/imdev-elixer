<?php

use yii\helpers\Html;

?>
<div class="basurvey-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('form_iom', [
        'model' => $model,
    ]) ?>

</div>
