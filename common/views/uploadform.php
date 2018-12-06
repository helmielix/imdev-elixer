<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Upload';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'upload-form']); ?>

                <?= $form->field($model, 'file')->fileInput() ?>

                <div class="form-group">
                    <?=  Yii::getAlias('@web').'/'.\Yii::$app->controller->id.'/index' ? Html::button('Previous', ['id'=>'prevButton','class'=>'btn btn-info']) : Html::button('Previous', ['id'=>'prevButton','class'=>'btn btn-info']) ?>
                    <?=  Yii::getAlias('@web').'/'.\Yii::$app->controller->id.'/index' ? Html::button('Upload', ['id'=>'createButton','class'=>'btn btn-primary']) : Html::button('Upload', ['id'=>'createButton','class'=>'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

<script>
    $('#prevButton').click(function (){
    	var button = $(this);
        button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
        
        <?php if(\Yii::$app->controller->id == 'inbound-po'){ ?>
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/'.\Yii::$app->controller->id.'/viewsn']) ;?>');
        $('#modalHeader').html('<h3>Detail Inbound PO</h3>');
        <?php }else if(\Yii::$app->controller->id == 'outbound-wh-transfer'){ ?>
		$('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/'.\Yii::$app->controller->id.'/create', 'id' => Yii::$app->request->get('idOutboundWh')]) ;?>');
        $('#modalHeader').html('<h3>Create Tag SN</h3>');
		<?php }else if(\Yii::$app->controller->id == 'inbound-wh-transfer'){ ?>
		$('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/'.\Yii::$app->controller->id.'/viewtagsn', 'id' => Yii::$app->request->get('idInboundWh')]) ;?>');
        $('#modalHeader').html('<h3>Create Tag SN</h3>');
		<?php }else if(\Yii::$app->controller->id == 'outbound-repair'){ ?>
		$('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/'.\Yii::$app->controller->id.'/create', 'id' => Yii::$app->request->get('idOutboundRepair')]) ;?>');
        $('#modalHeader').html('<h3>Create Tag SN</h3>');
		<?php }else if(\Yii::$app->controller->id == 'outbound-grf'){ ?>
		$('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/'.\Yii::$app->controller->id.'/create', 'id' => Yii::$app->request->get('idOutboundGrf')]) ;?>');
        $('#modalHeader').html('<h3>Create Tag SN</h3>');
		<?php } ?>
        
    });

	$('#createButton').click(function () {

		var form = $('#upload-form');
		data = form.data("yiiActiveForm");
		$.each(data.attributes, function() {
			this.status = 3;
		});
		form.yiiActiveForm("validate");
		if (!form.find('.has-error').length) {
			data = new FormData();
			data.append( 'file', $( '#uploadform-file' )[0].files[0] );
            var button = $(this);
            button.prop('disabled', true);
            button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
			$.ajax({
				<?php if(\Yii::$app->controller->id == 'inbound-po'){ ?>
				  url: '<?php echo Url::to(['/'.\Yii::$app->controller->id.'/uploadsn']) ;?>',
				<?php } else if(\Yii::$app->controller->id == 'outbound-wh-transfer'){ ?>
				  url: '<?php echo Url::to(['/'.\Yii::$app->controller->id.'/uploadsn', 'id' => Yii::$app->request->get('id')]) ;?>',
				<?php } else if(\Yii::$app->controller->id == 'outbound-repair'){ ?>
				  url: '<?php echo Url::to(['/'.\Yii::$app->controller->id.'/uploadsn', 'id' => Yii::$app->request->get('id')]) ;?>',
				<?php } else if(\Yii::$app->controller->id == 'inbound-wh-transfer'){ ?>
				  url: '<?php echo Url::to(['/'.\Yii::$app->controller->id.'/uploadsn', 'id' => Yii::$app->request->get('id'), 'idInboundWh' => Yii::$app->session->get('idInboundWh')]) ;?>',
				<?php } else if(\Yii::$app->controller->id == 'outbound-grf'){ ?>
				  url: '<?php echo Url::to(['/'.\Yii::$app->controller->id.'/uploadsn', 'id' => Yii::$app->request->get('id')]) ;?>',
				<?php } ?>
				  type: 'post',
				  data: data,
				  processData: false,
				  contentType: false,
				  success: function (response) {
						if(response == 'success') {
							<?php if(\Yii::$app->controller->id == 'inbound-po'){ ?>
							$('#modal').modal('show')
								.find('#modalContent')
								.load('<?php echo Url::to(['/'.\Yii::$app->controller->id.'/viewsn']) ;?>');
							$('#modalHeader').html('<h3> Inbound PO</h3>');
							<?php }else if(\Yii::$app->controller->id == 'outbound-wh-transfer'){ ?>
							$('#modal').modal('show')
								.find('#modalContent')
								.load('<?php echo Url::to(['/'.\Yii::$app->controller->id.'/create', 'id' => Yii::$app->request->get('idOutboundWh')]) ;?>');
							$('#modalHeader').html('<h3>Create Tag SN</h3>');
							<?php }else if(\Yii::$app->controller->id == 'outbound-repair'){ ?>
							$('#modal').modal('show')
								.find('#modalContent')
								.load('<?php echo Url::to(['/'.\Yii::$app->controller->id.'/create', 'id' => Yii::$app->request->get('idOutboundRepair')]) ;?>');
							$('#modalHeader').html('<h3>Create Tag SN</h3>');
							
							<?php }else if(\Yii::$app->controller->id == 'inbound-wh-transfer'){ ?>
							$('#modal').modal('show')
								.find('#modalContent')
								.load('<?php echo Url::to(['/'.\Yii::$app->controller->id.'/viewtagsn', 'id' => Yii::$app->session->get('idInboundWh')]) ;?>');
							$('#modalHeader').html('<h3>Detail Inbound WH</h3>');
							<?php }else if(\Yii::$app->controller->id == 'outbound-grf'){ ?>
							$('#modal').modal('show')
								.find('#modalContent')
								.load('<?php echo Url::to(['/'.\Yii::$app->controller->id.'/create', 'id' => Yii::$app->request->get('idOutboundGrf')]) ;?>');
							$('#modalHeader').html('<h3>Create Tag SN</h3>');
							<?php } ?>
							
						} else {
							<?php if(\Yii::$app->controller->id == 'inbound-wh-transfer'){ ?>
							response = response.toLowerCase();
							if (response.indexOf("tagging") > 0){
								alert(response);
								$('#modal').modal('show')
									.find('#modalContent')
									.load('<?php echo Url::to(['/'.\Yii::$app->controller->id.'/retagsn', 'id' => Yii::$app->request->get('id')]) ;?>');
								$('#modalHeader').html('<h3>Re-Tag SN</h3>');
							}else{
								alert('error with message: ' + response);
							}
							<?php }else { ?>
							alert('error with message: ' + response);
							<?php } ?>
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
                        $('#spinRefresh').remove();
                    },
			 });
		}
	});
</script>
