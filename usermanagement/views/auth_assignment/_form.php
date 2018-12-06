<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\AuthItem;
use common\models\User;
use app\models\Role;

/* @var $this yii\web\View */
/* @var $model app\models\AuthAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-assignment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList(
        ArrayHelper::map(User::find()->all(), 'id', 'username'),
                [
                    'prompt'=>'Pilih User',
                ]
    ) ?>

    <?= $form->field($model, 'item_name')->dropDownList(
    	ArrayHelper::map(AuthItem::find()->where(['NOT LIKE','name','/'])->all(), 'name', 'name'),
                [
                    'prompt'=>'Pilih Role',
                ]
    ) ?>


    

  


    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
