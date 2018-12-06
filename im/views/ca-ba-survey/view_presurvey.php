<?php

use yii\helpers\Html;
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
            'estimasi_homepass',
            [
                'attribute' => 'city',
                'value' => $model->idArea->idSubdistrict->idDistrict->idCity->name,
            ],
            [
                'attribute' => 'district',
                'value' => $model->idArea->idSubdistrict->idDistrict->name,
            ],
            [
                'attribute' => 'subdistrict',
                'value' => $model->idArea->idSubdistrict->name,
            ],
            [
            	'attribute' => 'status_presurvey',
            	'value' => $model->statusReferencePreSurvey->status_listing,
            ],
			[
				'attribute'=>'survey_date',
                'format'=>'date'
			],
            [
            	'attribute' => 'created_by',
            	'value' => User::findIdentity($model->created_by)->name,
            ],
            'created_date:datetime',
            [
            	'attribute' => 'updated_by',
            	'value' => User::findIdentity($model->updated_by)->name,
            ],
            'updated_date:datetime',
			'revision_remark'
        ],
    ]) ?>
<?php \yii\widgets\Pjax::begin(['id' => 'xpjax']); ?>
	<p>
        <?php if(Yii::$app->controller->action->id == 'view_presurvey'&& Yii::$app->controller->action->id != 'viewoverview_presurvey' && $model->status_presurvey != 6)
			echo Html::button(Yii::t('app','Update'), ['id'=>'updateButton','class' => 'btn btn-primary']); ?>
        <?php if((Yii::$app->controller->action->id == 'view' || Yii::$app->controller->action->id == 'view_presurvey') && Yii::$app->controller->action->id != 'viewoverview_presurvey')
			echo Html::button(Yii::t('app','Delete'), ['id'=>'deleteButton','class' => 'btn btn-danger']); ?>
		<?php if(Yii::$app->controller->action->id == 'viewverify' && $model->status_presurvey != 4 ){
				echo Html::button(Yii::t('app','Verify'), ['id'=>'verifyButton','class' => 'btn btn-success']);
			}else if(Yii::$app->controller->action->id == 'viewverify_presurvey' && $model->status_presurvey != 4) {
				echo Html::button(Yii::t('app','Verify'), ['id'=>'verifyButton','class' => 'btn btn-success']);
			}
		?>
        <?php if((Yii::$app->controller->action->id == 'viewapprove_presurvey' || Yii::$app->controller->action->id == 'viewapprove') && $model->status_presurvey != 5)
			echo Html::button(Yii::t('app','Approve'), ['id'=>'approveButton','class' => 'btn btn-success']); ?>


		<?php if(Yii::$app->controller->action->id == 'viewverify_presurvey' && ($model->status_presurvey != 5 && $model->status_presurvey != 4)){
			echo Html::button(Yii::t('app','Revise'), ['id'=>'reviseButton','class' => 'btn btn-warning']);
		}else if(Yii::$app->controller->action->id == 'viewapprove_presurvey' && $model->status_presurvey != 5){
			echo Html::button(Yii::t('app','Revise'), ['id'=>'reviseButton','class' => 'btn btn-warning']);
		}
		?>
        <?php if(Yii::$app->controller->action->id == 'viewverify_presurvey' && ($model->status_presurvey != 5 && $model->status_presurvey != 4)){
			echo Html::button(Yii::t('app','Reject'), ['id'=>'rejectButton','class' => 'btn btn-danger']);
		}else if(Yii::$app->controller->action->id == 'viewapprove_presurvey' && $model->status_presurvey != 5){
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
			.load('<?php echo Url::to(['/ca-ba-survey/update_presurvey', 'id' => $model->id]) ;?>');
		$('#modalHeader').html('<h3> Update Presurvey: <?= $model->id; ?></h3>');
	});

	$('#verifyButton').click(function () {
        var button = $(this);
        button.prop('disabled', true);
		$.ajax({
			url: '<?php echo Url::to(['/ca-ba-survey/verify_presurvey', 'id' => $model->id]) ;?>',
			type: 'post',
			success: function (response) {
				if(response == 'success') {
					$('#modal').modal('hide');
					setPopupAlert('Data has been verified.');
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
			url: '<?php echo Url::to(['/ca-ba-survey/approve_presurvey', 'id' => $model->id]) ;?>',
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

		if (selectedAction == 'revise') url = '<?php echo Url::to(['/ca-ba-survey/revise_presurvey', 'id' => $model->id]) ;?>';
		if (selectedAction == 'reject') url = '<?php echo Url::to(['/ca-ba-survey/reject_presurvey', 'id' => $model->id]) ;?>';
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
