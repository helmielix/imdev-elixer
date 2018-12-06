<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GovrelParBbfeedPermit */

Yii::$app->controller->action->id === 'view' ? $this->params['breadcrumbs'][] = ['label' => 'Parameter PIC Backbone Feeder Permit', 'url' => ['index']] :
Yii::$app->controller->action->id === 'viewverify' ? $this->params['breadcrumbs'][] = ['label' => 'Parameter PIC Backbone Feeder Permit', 'url' => ['indexverify']] :
$this->params['breadcrumbs'][] = ['label' => 'Parameter PIC Backbone Feeder Permit', 'url' => ['indexapprove']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="govrel-par-bbfeed-permit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'name',
		    [
                'attribute' => 'status_par',
                'value' => isset($model->statusReferenceStatusParameter->status_listing) ? $model->statusReferenceStatusParameter->status_listing : '' ,
            ],
			[
                'attribute' => 'created_by',
                'value' => isset($model->userCreatedBy->name) ?  $model->userCreatedBy->name : '',
            ],
            	'created_date:datetime',
           [
                'attribute' => 'updated_by',
                'value' => isset($model->userUpdatedBy->name) ?  $model->userUpdatedBy->name : '',
            ],
           	'updated_date:datetime',
            [
                'attribute' => 'status_listing',
                'value' => $model->statusReference->status_listing,
            ],
            'revision_remark',

        ],
    ]) ?>

	<?php \yii\widgets\Pjax::begin(['id' => 'xpjax']); ?>

	<p>

          <?= Yii::$app->controller->action->id == 'view' ? Html::button('Update', [
          'id'=>'updateButton',
          'class' => 'btn btn-primary',
          ]) : '' ?>




		<?= ( Yii::$app->controller->action->id == 'viewapprove' && $model->status_listing != 5)? Html::button('Approve', [
            'id'=>'approveButton',
            'class' => 'btn btn-primary',

          ]) : '' ?>
		  
		  
		<?=  (Yii::$app->controller->action->id == 'viewapprove' &&  $model->status_listing == 5) ? Html::button('Revise', [
            'id'=>'reviseButton',
            'class' => 'btn btn-warning',

        ]) : ''?>

		  <?=(Yii::$app->controller->action->id == 'view' || ( Yii::$app->controller->action->id == 'viewapprove' &&  $model->status_listing == 5)) ? Html::button('Delete', [
            'id'=>'deleteButton',
            'class' => 'btn btn-danger',
          
            ]) : '' ?>
			
			

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
			.load('<?php echo Url::to(['/govrel-par-bbfeed-permit/update', 'id' => $model->id]) ;?>');
		$('#modalHeader').html('<h3> Update Parameter PIC Backbone Feeder Permit</h3>');
	});

	$('#verifyButton').click(function () {
        var button = $(this);
        button.prop('disabled', true);
		$.ajax({
			url: '<?php echo Url::to(['/govrel-par-bbfeed-permit/verify', 'id' => $model->id]) ;?>',
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
			url: '<?php echo Url::to(['/govrel-par-bbfeed-permit/approve', 'id' => $model->id]) ;?>',
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



			var resp = confirm("Do you want to delete this item???");
      if (resp == true) {
      $.ajax({
			url: '<?php echo Url::to(['/govrel-par-bbfeed-permit/delete', 'id' => $model->id]) ;?>',
			type: 'post',
			success: function (response) {
				$('#modal').modal('hide');
				setPopupAlert('Data has been deleted.');
			}
		});
      }
      else {
      return false;
      }

	});

	$('#submitButton').click(function () {



		if (selectedAction == 'revise') {


		console.log('aa');
		console.log(selectedAction);
		var form = $('#submitForm');
		data = form.data("yiiActiveForm");
		$.each(data.attributes, function() {
			this.status = 3;
		});
		form.yiiActiveForm("validate");

			if (selectedAction == 'revise') url = '<?php echo Url::to(['/govrel-par-bbfeed-permit/revise', 'id' => $model->id]) ;?>';
		if (selectedAction == 'reject') url = '<?php echo Url::to(['/govrel-par-bbfeed-permit/reject', 'id' => $model->id]) ;?>';
		if (!form.find('.has-error').length) {

			data = new FormData();
		    data.append( 'GovrelParBbfeedPermit[revision_remark]', $( '#govrelparbbfeedpermit-revision_remark' ).val() );
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

		} else {

			var resp = confirm("Do you want to reject this item???");
      if (resp == true) {
     	console.log('aa');
		console.log(selectedAction);
		var form = $('#submitForm');
		data = form.data("yiiActiveForm");
		$.each(data.attributes, function() {
			this.status = 3;
		});
		form.yiiActiveForm("validate");

			if (selectedAction == 'revise') url = '<?php echo Url::to(['/govrel-par-bbfeed-permit/revise', 'id' => $model->id]) ;?>';
		if (selectedAction == 'reject') url = '<?php echo Url::to(['/govrel-par-bbfeed-permit/reject', 'id' => $model->id]) ;?>';
		if (!form.find('.has-error').length) {

			data = new FormData();
			data.append( 'GovrelParBbfeedPermit[revision_remark]', $( '#govrelparbbfeedpermit-revision_remark' ).val() );
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

      }
      else {
      return false;
      }

		}

	});
</script>
