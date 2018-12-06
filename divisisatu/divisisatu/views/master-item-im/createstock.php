<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model setting\models\MasterItemIm */

$this->title = 'Create Stock';
$this->params['breadcrumbs'][] = ['label' => 'Master Item Ims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-item-im-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formitemstock', [
        'model' => $model,
    ]) ?>

</div>
