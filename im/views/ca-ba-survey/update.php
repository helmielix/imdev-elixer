<?php

use yii\helpers\Html;

?>
<div class="basurvey-update">

    <?= $this->render('_form', [
        'model' => $model,
		'modelArea' => $modelArea,
		'modelRegion' => $modelRegion,
		'modelCity' => $modelCity,
		'modelDistrict' => $modelDistrict,
		'modelIom' => $modelIom,
    ]) ?>

</div>
