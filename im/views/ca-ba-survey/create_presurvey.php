<?php

use yii\helpers\Html;

?>
<div class="basurvey-create">

    <?= $this->render('_form_presurvey', [
        'model' => $model,
		'modelArea' => $modelArea,
		'modelRegion' => $modelRegion,
		'modelCity' => $modelCity,
		'modelDistrict' => $modelDistrict,
		'modelIom' => $modelIom,
    ]) ?>

</div>
