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
     
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id . '/createtag', 'id' => Yii::$app->request->get('id'),'idparent' => Yii::$app->request->get('idparent'),'idbarang' => Yii::$app->request->get('idbarang')])?>');
        $('#modalHeader').html('<h3>Create Tag SN</h3>');
       
        
    });

	$('#createButton').click(function () {

		var form = $('#upload-form');
//		data = form.data("yiiActiveForm");
//		$.each(data.attributes, function() {
//			this.status = 3;
//		});
		form.yiiActiveForm("validate");
		if (!form.find('.has-error').length) {
			data = new FormData();
			data.append( 'file', $( '#uploadform-file' )[0].files[0] );
            var button = $(this);
            button.prop('disabled', true);
            button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
			$.ajax({
				
				  url: '<?php echo Url::to(['/'.\Yii::$app->controller->id.'/uploadsn', 'id' => Yii::$app->request->get('id'),'idparent' => Yii::$app->request->get('idparent'),'idbarang' => Yii::$app->request->get('idbarang')]) ;?>',
				  type: 'post',
				  data: data,
				  processData: false,
				  contentType: false,
				  success: function (response) {
						if(response == 'success') {
							
							$('#modal').modal('show')
								.find('#modalContent')
								.load('<?php echo Url::to(['/'.\Yii::$app->controller->id.'/createtag', 'id' => Yii::$app->request->get('id'),'idparent' => Yii::$app->request->get('idparent'),'idbarang' => Yii::$app->request->get('idbarang')]) ;?>');
							$('#modalHeader').html('<h3>Detail Inbound WH</h3>');
							
							
						} else if(response=="nosn"){
                                                    $('#modal').modal('show')
								.find('#modalContent')
								.load('<?php echo Url::to(['/'.\Yii::$app->controller->id.'/popretag', 'id' => Yii::$app->request->get('id'),'idparent' => Yii::$app->request->get('idparent'),'idbarang' => Yii::$app->request->get('idbarang')]) ;?>');
							$('#modalHeader').html('');
                                                }
                                                else {
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
                        $('#spinRefresh').remove();
                    },
			 });
		}
	});
</script>
