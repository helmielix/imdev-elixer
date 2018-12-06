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

                <?= $form->field($model, 'NOTE')->textInput(['maxlength' => true]) ?>

                <div class="form-group">
                    <?=  Yii::getAlias('@web').'/oltplacement/index' ? Html::button('Upload', ['id'=>'createButton2','class'=>'btn btn-primary']) : Html::button('Upload', ['id'=>'createButton2','class'=>'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

<script>
	$('#createButton').click(function () {
		
		data = new FormData();
		data.append( 'file', $( '#uploadform-file' )[0].files[0] );
		
		
		 $.ajax({
			  url: '<?php echo Url::to(['/ospbas/upload', 'id' => 1]) ;?>',
			  type: 'post',
			  data: data,
			  processData: false,
			  contentType: false,
			  success: function (response) {
					if(response == 'success') {
						$('#modal').modal('hide');
					} else {
						alert('error with message: ' + response);
					}
			  }
		 });
	});
	
	$('#createButton2').click(function () {
		
		data = new FormData();
		data.append( 'file', $( '#uploadform-file' )[0].files[0] );
		
		
		 $.ajax({
			  url: '<?php echo Url::to(['/oltplacement/upload', 'id' => 1]) ;?>',
			  type: 'post',
			  data: data,
			  processData: false,
			  contentType: false,
			  success: function (response) {
					if(response == 'success') {
						$('#modal').modal('hide');
					} else {
						alert('error with message: ' + response);
					}
			  }
		 });
	});
</script>


