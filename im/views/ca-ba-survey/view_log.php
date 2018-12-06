<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\CaBaSurveyReference;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use common\models\User;

$this->registerJsFile('@commonpath/js/btn_modal.js');
?>
<div class="basurvey-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'location_description',
            'id_area',
			[
				'label' => 'Status Listing',
				'value' => function($model){
					if(Yii::$app->controller->action->id == 'viewlog'){
						if($model->statusReferenceListing){
							return $model->statusReferenceListing->status_listing;
						}
					}
				}
			],
            'qty_hp_pot',
			[
				'label' => 'IOM Type',
				'value' => function($model){
					if(empty($model->reference->description)){
						return '-';
					}else{
						return $model->reference->description;
					}
					
				}
			],
			'pic_iom_special',
			'potency_type',
			[
				'label'=>'Property Area Type',
				'value' => function($model){
					return implode(',',ArrayHelper::getColumn(CaBaSurveyReference::find()
											->joinWith('idCaReference')
											->select(['ca_ba_survey_reference.id_ca_ba_survey','ca_ba_survey_reference.id_ca_reference','ca_reference.value as value'])
											->andFilterWhere(['and',['id_ca_ba_survey'=>$model->id],['in','id_ca_reference',[9,3,47]]])
											->asArray()->all(), 'value'));
				}
			],
			[
				'label'=>'House Type',
				'value' => function($model){
					return implode(',',ArrayHelper::getColumn(CaBaSurveyReference::find()
											->joinWith('idCaReference')
											->select(['ca_ba_survey_reference.id_ca_ba_survey','ca_ba_survey_reference.id_ca_reference','ca_reference.value as value'])
											->andFilterWhere(['and',['id_ca_ba_survey'=>$model->id],['in','id_ca_reference',[2,6,7,10]]])
											->asArray()->all(), 'value'));
				}
			],
            
			[
				'label'=>'Average Ocupancy Level',
				'value' => function($model){
					return implode(',',ArrayHelper::getColumn(CaBaSurveyReference::find()
											->joinWith('idCaReference')
											->select(['ca_ba_survey_reference.id_ca_ba_survey','ca_ba_survey_reference.id_ca_reference','ca_reference.value as value'])
											->andFilterWhere(['and',['id_ca_ba_survey'=>$model->id],['in','id_ca_reference',[16,17,18,19,20,21,22,23,24,25]]])
											->asArray()->all(), 'value'));
				}
			],
            
			[
				'label'=>'Majority of Occupant',
				'value' => function($model){
					return implode(',',ArrayHelper::getColumn(CaBaSurveyReference::find()
											->joinWith('idCaReference')
											->select(['ca_ba_survey_reference.id_ca_ba_survey','ca_ba_survey_reference.id_ca_reference','ca_reference.value as value'])
											->andFilterWhere(['and',['id_ca_ba_survey'=>$model->id],['in','id_ca_reference',[26,27]]])
											->asArray()->all(), 'value'));
				}
			],
			[
				'label'=>'Methods of Development',
				'value' => function($model){
					return implode(',',ArrayHelper::getColumn(CaBaSurveyReference::find()
											->joinWith('idCaReference')
											->select(['ca_ba_survey_reference.id_ca_ba_survey','ca_ba_survey_reference.id_ca_reference','ca_reference.value as value'])
											->andFilterWhere(['and',['id_ca_ba_survey'=>$model->id],['in','id_ca_reference',[28,29,30]]])
											->asArray()->all(), 'value'));
				}
			],
			[
				'label'=>'Access to Sales',
				'value' => function($model){
					return implode(',',ArrayHelper::getColumn(CaBaSurveyReference::find()
											->joinWith('idCaReference')
											->select(['ca_ba_survey_reference.id_ca_ba_survey','ca_ba_survey_reference.id_ca_reference','ca_reference.value as value'])
											->andFilterWhere(['and',['id_ca_ba_survey'=>$model->id],['in','id_ca_reference',[31,32,33]]])
											->asArray()->all(), 'value'));
				}
			],
			[
				'label'=>'Competitors',
				'value' => function($model){
					return implode(',',ArrayHelper::getColumn(CaBaSurveyReference::find()
											->joinWith('idCaReference')
											->select(['ca_ba_survey_reference.id_ca_ba_survey','ca_ba_survey_reference.id_ca_reference','ca_reference.value as value'])
											->andFilterWhere(['and',['id_ca_ba_survey'=>$model->id],['in','id_ca_reference',[34,35,36,37,38,39]]])
											->asArray()->all(), 'value'));
				}
			],
			[
				'label'=>'Competitors',
				'value' => function($model){
					return implode(',',ArrayHelper::getColumn(CaBaSurveyReference::find()
											->joinWith('idCaReference')
											->select(['ca_ba_survey_reference.id_ca_ba_survey','ca_ba_survey_reference.id_ca_reference','ca_reference.value as value'])
											->andFilterWhere(['and',['id_ca_ba_survey'=>$model->id],['in','id_ca_reference',[40,41,42,43,44]]])
											->asArray()->all(), 'value'));
				}
			],
            'notes',
            [
				'attribute'=>'survey_date',
                'format'=>'date'
			],
			
			
			[
                'attribute'=>'doc_file',
                'format'=>'raw',
                'value'=>Html::a(basename($model->doc_file), ['downloadfile', 'id' => $model->id], $options = ['target'=>'_blank', 'data' => [
                    'method' => 'post',
                    'params' => [
                        'data' => 'doc_file',
                        // 'path' => 'true'
                    ],
                    ]]),

            ],
			
			[
				'attribute'=>'xls_file',
				'format'=>'raw',
				'value'=>Html::a('Download Excel Homepass', ['downloadfile', 'id' => $model->id], $options = ['target'=>'_blank', 'data' => [
                    'method' => 'post',
                    'params' => [
                        'data' => 'xls_file',
                        // 'path' => 'true'
                    ],
                    ]]),
			],
			[
				'attribute'=>'pdf_file',
				'format'=>'raw',
				'value'=>Html::a('Download Excel Homepass', ['downloadfile', 'id' => $model->id], $options = ['target'=>'_blank', 'data' => [
                    'method' => 'post',
                    'params' => [
                        'data' => 'pdf_file',
                        // 'path' => 'true'
                    ],
                    ]]),
			],
            [
            	'attribute' => 'created_by',
            	'value' => function($model){
					if($model->created_by){
						return User::findIdentity($model->created_by)->name;
					}
				}
            ],
            'created_date:datetime',
            
            'created_date',
            [
            	'attribute' => 'updated_by',
            	'value' => function($model){
					if($model->created_by){
						return User::findIdentity($model->updated_by)->name;
					}
				}
            ],
            'updated_date',
			'revision_remark'
        ],
    ]) ?>
<?php \yii\widgets\Pjax::begin(['id' => 'xpjax']); ?>
	<p>
        <?php if(Yii::$app->controller->action->id == 'view')
			echo Html::button(Yii::t('app','Update'), ['id'=>'updateButton','class' => 'btn btn-primary']); ?>
        <?php if(Yii::$app->controller->action->id == 'view')
			echo Html::button(Yii::t('app','Delete'), ['id'=>'deleteButton','class' => 'btn btn-danger']); ?>
		<?php if(Yii::$app->controller->action->id == 'viewverify' && $model->status_listing != 4 && $model->xls_file != '' && $model->xls_file != null){
				echo Html::button(Yii::t('app','Verify'), ['id'=>'verifyButton','class' => 'btn btn-success']);
			}else if(Yii::$app->controller->action->id == 'viewverify_presurvey') {
				echo Html::button(Yii::t('app','Verify'), ['id'=>'verifyButton','class' => 'btn btn-success']);
			}
		?>
        <?php if((Yii::$app->controller->action->id == 'viewapprove_presurvey' || Yii::$app->controller->action->id == 'viewapprove') && $model->status_listing != 5)
			echo Html::button(Yii::t('app','Approve'), ['id'=>'approveButton','class' => 'btn btn-success']); ?>
		<?php if(Yii::$app->controller->action->id == 'viewverify' && ($model->status_listing != 5 && $model->status_listing != 4)){
			echo Html::button(Yii::t('app','Revise'), ['id'=>'reviseButton','class' => 'btn btn-warning']); 
		}else if(Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5){
			echo Html::button(Yii::t('app','Revise'), ['id'=>'reviseButton','class' => 'btn btn-warning']); 
		}
		?>
        <?php if(Yii::$app->controller->action->id == 'viewverify' && ($model->status_listing != 5 && $model->status_listing != 4)){
			echo Html::button(Yii::t('app','Reject'), ['id'=>'rejectButton','class' => 'btn btn-danger']); 
		}else if(Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5){
			echo Html::button(Yii::t('app','Reject'), ['id'=>'rejectButton','class' => 'btn btn-danger']); 
		}
		?>

	</p>
    <?php $form = ActiveForm::begin([
		'enableClientValidation' => true,
		'id' => 'submitForm',
		'layout' => 'horizontal',
		'options' => [
			'style' => 'display:none;'
		],
		'fieldConfig' => [
				'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
				'horizontalCssClasses' => [
					'label' => 'col-sm-1',
					'offset' => 'col-sm-offset-1',
					'wrapper' => 'col-sm-6',
					'error' => '',
					'hint' => '',
				],
			],
	]); ?>

		<br />
		<?= $form->field($model, 'revision_remark')->textarea(['rows' => '5']) ?>
		<?= Html::button(\Yii::t('app','Submit Remark'), ['id'=>'submitButton','class' => 'btn btn-primary']) ?>
	<?php ActiveForm::end(); ?>

<?php yii\widgets\Pjax::end() ?>
</div>

<script>
	var selectedAction;
	$('#updateButton').click(function () {
		$('#modal').modal('show')
			.find('#modalContent')
			.load('<?php echo Url::to(['/ca-ba-survey/update', 'id' => $model->id]) ;?>');
		$('#modalHeader').html('<h3> Update BAS: <?= $model->id; ?></h3>');
	});

	$('#verifyButton').click(function () {
        var button = $(this);
        button.prop('disabled', true);
		$.ajax({
			url: '<?php echo Url::to(['/ca-ba-survey/verify', 'id' => $model->id]) ;?>',
			type: 'post',
			success: function (response) {
				if(response == 'success') {
					$('#modal').modal('hide');
					setPopupAlert('Data has been verified.');
				} else {
					alert('error with message: ' + response);
				}
			},
            error: function (xhr, getError) {
            	if (typeof getError === "object" && getError !== null) {
            		error = $.parseJSON(getError.responseText);
            		getError = error.message;
            	}
            	if (xhr.status != 302) {
            		alert("System recieve error with code: "+xhr.status);
            	}
            },
            complete: function () {
                button.prop('disabled', false);
            },
		});
	});

	$('#approveButton').click(function () {
        var button = $(this);
        button.prop('disabled', true);
		$.ajax({
			url: '<?php echo Url::to(['/ca-ba-survey/approve', 'id' => $model->id]) ;?>',
			type: 'post',
			success: function (response) {
				if(response == 'success') {
					$('#modal').modal('hide');
					setPopupAlert('Data has been approved.');
				} else {
					alert('error with message: ' + response);
				}
			},
            error: function (xhr, getError) {
            	if (typeof getError === "object" && getError !== null) {
            		error = $.parseJSON(getError.responseText);
            		getError = error.message;
            	}
            	if (xhr.status != 302) {
            		alert("System recieve error with code: "+xhr.status);
            	}
            },
            complete: function () {
                button.prop('disabled', false);
            },
		});
	});

	$('#rejectButton').click(function () {
		selectedAction = 'reject';
		$('#submitForm').show();
	});
	$('#reviseButton').click(function () {
		selectedAction = 'revise';
		$('#submitForm').show();
	});

	$('#deleteButton').click(function () {
		$.ajax({
			url: '<?php echo Url::to(['/ca-ba-survey/delete', 'id' => $model->id]) ;?>',
			type: 'post',
			success: function (response) {
				if(response == 'success') {
					$('#modal').modal('hide');
					setPopupAlert('Data has been deleted.');
				} else {
					alert('error with message: ' + response);
				}
			}
		});
	});

	$('#submitButton').click(function () {

		console.log('aa');
		console.log(selectedAction);
		var form = $('#submitForm');
		data = form.data("yiiActiveForm");
		$.each(data.attributes, function() {
			this.status = 3;
		});
		form.yiiActiveForm("validate");

		if (selectedAction == 'revise') url = '<?php echo Url::to(['/ca-ba-survey/revise', 'id' => $model->id]) ;?>';
		if (selectedAction == 'reject') url = '<?php echo Url::to(['/ca-ba-survey/reject', 'id' => $model->id]) ;?>';
		if (!form.find('.has-error').length) {

			data = new FormData();
			data.append( 'CaBaSurvey[revision_remark]', $( '#cabasurvey-revision_remark' ).val() );
            var button = $(this);
            button.prop('disabled', true);
			 $.ajax({
				  url: url,
				  type: 'post',
				  data: data,
				  processData: false,
				  contentType: false,
				  success: function (response) {
						if(response == 'success') {
							$('#modal').modal('hide');
							if (selectedAction == 'revise') {
								setPopupAlert('Data has been revised.');
							} else {
								setPopupAlert('Data has been rejeted.');
							}
						} else {
							alert('error with message: ' + response);
						}
				  },
                    error: function (xhr, getError) {
                    	if (typeof getError === "object" && getError !== null) {
                    		error = $.parseJSON(getError.responseText);
                    		getError = error.message;
                    	}
                    	if (xhr.status != 302) {
                    		alert("System recieve error with code: "+xhr.status);
                    	}
                    },
                    complete: function () {                    	
                        button.prop('disabled', false);
                    },
			 });
		 };
	});
</script>
