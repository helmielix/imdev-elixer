<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\bootstrap\Modal;

use common\models\MkmMasterItem;

/* @var $this yii\web\View */
/* @var $model inbound\models\InboundPo */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<?php Modal::begin([
        'header'=>'<h3 id="modalHeader"></h3>',
        'id'=>'modal',
        'size'=>'modal-lg'
    ]);
    echo '<div id="modalContent"> </div>';
    Modal::end();
?>
<?php \yii\widgets\Pjax::begin(['id' => 'pjax',]); ?>
<div class="inbound-po-form">

    <?php $form = ActiveForm::begin([
		'enableClientValidation' => true,
        'id' => 'createForm',
        'layout' => 'horizontal',
		'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-4',
                'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-6',
                'error' => '',
                'hint' => '',
            ],
        ],
	]); ?>
	
	<div class="row">
		<div class="col-lg-6">
			<?= $form->field($modelOrafin, 'rr_number')->textInput(['disabled'=>true]) ?>
			
			<?= $form->field($modelOrafin, 'pr_number')->textInput(['disabled'=>true]) ?>
			
			<?= $form->field($modelOrafin, 'po_number')->textInput(['disabled'=>true]) ?>
		</div>
		<div class="col-lg-6">
			<?= $form->field($modelOrafin, 'supplier')->textInput(['disabled'=>true]) ?>

			<?= $form->field($modelOrafin, 'rr_date')->textInput(['disabled'=>true]) ?>

			<?= $form->field($modelOrafin, 'waranty')->textInput(['disabled'=>true]) ?>
		</div>
	</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	
	
    <?php ActiveForm::end(); ?>
	<?= GridView::widget([
        'id' => 'gridView',
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{create}',
                'buttons'=>[
                   
                    'create' => function ($url, $model) {
                        // if(Yii::$app->controller->action->id == 'index' ){
                            return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-plus"></span>', '#createdetail?orafinCode='.$model->orafin_code.'&header=Create_Material_GRF_Vendor_IKO', [
                                'title' => Yii::t('app', 'create'), 'class' => 'viewButton', 'value'=>Url::to(['inbound-po/createdetail', 'orafinCode' => $model->orafin_code, 'rrNumber'=> $model->rr_number]), 'header'=> yii::t('app','Create Material GRF Vendor IKO')
                            ]);
                        // }
                    },
					
                ],
            ],
			[
				'label' => 'Orafin Name',
				'format' => 'raw',
				'value' => function($model){
					$item = MkmMasterItem::find()->select('item_desc')->where(['item_code'=>$model->orafin_code])->one();
					return $item->item_desc;
				}
			]
			
			
        ],
    ]); ?>
	<?php \yii\widgets\Pjax::end(); ?>

</div>
