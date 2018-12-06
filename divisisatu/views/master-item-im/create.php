<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model divisisatu\models\MasterItemIm */

$this->title = 'Create Master Item Im';
$this->params['breadcrumbs'][] = ['label' => 'Master Item Ims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-item-im-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
