<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

use kartik\money\MaskMoney;

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

// $this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$arrQtyDetail = '';
?>
<div class="instruction-wh-transfer-detail-index">

            
<?php 
        Pjax::begin(['id' => 'gridpjax', 'timeout' => 5000, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST','reload'=>false]]) 
        // Pjax::begin()
    ?>
    
    <?php 
        $arrQtyDetail = Yii::$app->session->get('countQty');
        // foreach($arrQtyDetail as $key => $value) {
        //     echo $key.'->'.$value[0], '<br>';
        // }
        // $idForm = 'saveForm';
    ?>
	<?php
		$form = ActiveForm::begin([
           'id' => 'createForm',
           'enableClientValidation' => true,
           'layout' => 'horizontal',
           'options' => ['data-pjax' => true ],
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
		]);
	?>
	
	<div class="alert hidden" id="errorSummary">Please fix these following error: <ul id="ulerrorSummary"></ul></div>
    <?= GridView::widget([
        'id' => 'gridViewdetail',
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'options' => ['style' => 'overflow-x:scroll'],
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
		'responsive'=>true,
		'floatHeader'=>true,
		'floatOverflowContainer' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],			
            
			[
				'attribute' => 'item_code',
				'format' => 'raw',
			],
            [ 
                'format'=> 'raw',
                'label' => '',
                'value' => function ($model) use ($arrQtyDetail)
                    {
                        return Html::hiddenInput('item_code[]', $model->item_code);
                    },
            ],
            [
			'attribute'=>'item_desc',
            'value' =>'item_desc',
            ],
			[
                'attribute'=>'qty_request',
                'format' => 'raw',
                'label'=>'Qty Request',
                  'headerOptions' => ['style' => 'width:10%'],
                    'value' => function ($model) use ($arrQtyDetail)
                    {
                        $style = ['style'=>'width:100%','id'=>'idqtyreq'];
                       if(Yii::$app->controller->action->id == 'createdetail' && isset($arrQtyDetail[$model->item_code][0])){
                           $model->qty_request = $arrQtyDetail[$model->item_code][0];
                       }else {
                           $model->qty_request = null;
                       }
                        return Html::textInput('qty_request[]', $model->qty_request);
                    }
            ],
			
			
        ],
    ]); ?>
    <p>
        <?= Html::button('Previous', ['id'=>'prevButton','class' => 'btn btn-success','data-pjax' => false]);  ?>
        <?= Html::button('Submit', ['id'=>'submitedButton','class' => 'btn btn-success','data-pjax' => false]) ?>
    </p>
    <?php ActiveForm::end(); ?>
	<?php yii\widgets\Pjax::end() ?>
</div>

<script>

	<?php 
	$qString = Yii::$app->request->queryString;
	$idGrf = Yii::$app->session->get('idGrf');
    // $idGrf = null;
    if ($qString == ''){
        $goto = '/indexdetail';
    }else{
        $goto = '/view';
	}
	?>
    $(document).on('click', '#prevButton', function(event){
	// $('#prevButton').click(function () {
        // event.stopPropagation();
        // event.stopPropagation();
        // event.preventDefault();
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id.'/indexdetail','id'=>$idGrf]) ;?>');
        $('#modalHeader').html('<h3> Create Inbound PO </h3>');
    });
    
    $(document).on('click', '#submitedButton', function(event){
    // $('#submitedButton').click(function () {

        event.stopImmediatePropagation();
        console.log('klik');
        var form = $('#createForm');
		data = new FormData(form[0]);
		
		var button = $(this);
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');
		
		$('#errorSummary').addClass('hidden');
		$('#ulerrorSummary li').remove();
		$('tr[data-key').removeClass('info');		
		
		$.ajax({
            url: '<?php echo Url::to([$this->context->id.'/createdetail', 'id' => Yii::$app->session->get('idGrf')]) ;?>',
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
			dataType: 'json',
            success: function (response) {
                if(response.status == 'success') {
                    $('#modal').modal('show')
						.find('#modalContent')
						.load('<?php echo Url::to([$this->context->id.$goto, 'id' => $idGrf]) ;?>');
					$('#modalHeader').html('<h3>Detail Good Request Form</h3>');
                } else {
					pesan = response.pesan;
					pesan = pesan.split('\n');
					$('#errorSummary').addClass('alert-danger').removeClass('hidden');
					for(i = 0; i < pesan.length; i++){
						$('#ulerrorSummary').append('<li>'+pesan[i]+'</li>');
					}
					$('tr[data-key='+response.id+']').addClass('info');
                    alert('error with message: ' + response.pesan);
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
    });
	
    $('.viewButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
        $('#modalHeader').html('<h3> '+ $(this).attr('header') +'</h3>');
    });

   
</script>
