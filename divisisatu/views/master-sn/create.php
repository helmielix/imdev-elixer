<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MasterSn */

$this->title = Yii::t('app', 'Create Master Sn');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Master Sns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-sn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
