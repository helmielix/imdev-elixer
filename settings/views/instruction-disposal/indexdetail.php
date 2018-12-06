<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\MasterItemIm;

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="instruction-disposal-detail-index">


    <p>
        <!-- <?= Html::button(Yii::t('app','Add'), ['id'=>'createButton','class' => 'btn btn-success']) ?> -->
        <?= Html::button(Yii::t('app','Upload'), ['id'=>'uploadButton','class' => 'btn btn-success']) ?>
        
    </p>

	<?php \yii\widgets\Pjax::begin(['id' => 'pjaxindexdetail', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]); ?>
    <?= GridView::widget([
        'id' => 'gridViewindexdetail',
        'dataProvider' => $dataProvider,
        'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {delete}',
                'buttons'=>[
                    'delete' => function ($url, $model) {
                        return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-trash"></span>', '#', [
                            'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['instruction-disposal/deletedetail', 'id' => $model->id]), 'header'=> yii::t('app','GRF Detail')
                        ]);
                    },
					
                    'update' => function ($url, $model) {
                        return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>', '#updatedetail?id='.$model->id.'&header=Update_GRF_Detail:_', [
                            'title' => Yii::t('app', 'update'), 'class' => 'viewButton', 'value'=>Url::to(['instruction-disposal/updatedetail', 'id'=> $model->id]), 'header'=> yii::t('app','Update GRF Detail ')
                        ]);
                    },
                ],
            ],
			[
                'label' => 'IM Code',
                'value' => function($model){
                    $model = MasterItemIm::find()->where(['id'=>$model->im_code])->one();
                    if($model){
                        return $model->im_code;                   
                    }
                }
            ],
            [
                'attribute' => 'name',
                'value' => 'imCode.name',
            ],
            [
                'attribute' => 'brand',
                'value' => 'imCode.brand',
            ],
            [
                'attribute' => 'uom_',
                'value' => 'imCode.type',
            ],
			'qty',
			'uom_sale',
            'qty_konversi',
            'uom_old',
            'konversi',
            'uom_new',
            'qty_total',
			'uom',

            
			// 'im_code',
			// 'nama_barang',
			// 'brand',
			// 'type',
			// 'warna',
			// 'sntype',
			// 'uom',
			// 'sgood',
			// 'sngood',
			// 'sreject',
			// 'rqgood',
			// 'rqngood',
			// 'rqreject',
			// 'remgood',
			// 'remngood',
			// 'remreject',
			
        ],
    ]); ?>
    <p>
        <?= Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-success']) ?>
        <?= Html::button(Yii::t('app','Submit Instruction'), ['id'=>'submitButton','class' => 'btn btn-success']) ?>
    </p>
	<?php yii\widgets\Pjax::end() ?>
</div>

<script>
    $('#createButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['/instruction-disposal/createdetail']) ;?>?id=<?= Yii::$app->session->get('idInstWhTr') ?>');
        $('#modalHeader').html('<h3> Create Detail Instruksi Disposal </h3>');
    });
    $('#uploadButton').click(function () {
        urlUpload = '<?php echo Url::to(['/instruction-disposal/uploaddetail']) ;?>';
        <?php if (Yii::$app->session->get('countGrfDetail') > 0) :?>
        var resp = confirm("Your action will replace data that is already inputted?\n\nCancel, Append Data Existing");
        if (resp == true) {
            urlUpload = '<?php echo Url::to(['/instruction-disposal/uploaddetail','upload' => 'replace']) ;?>';
        }else {
            urlUpload = '<?php echo Url::to(['/instruction-disposal/uploaddetail','upload' => 'append']) ;?>';
        }
        <?php endif; ?>
        $('#modal').modal('show')
            .find('#modalContent')
            .load(urlUpload);
        $('#modalHeader').html('<h3> Upload Material GRF </h3>');
    });
    $('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to(['instruction-disposal/update','idInbouncPo'=>Yii::$app->session->get('idInstWhTr')]) ;?>');
        $('#modalHeader').html('<h3> Detail Instruksi Disposal </h3>');
    });
    
    $('#submitButton').click(function () {
        $('#modal').modal('hide')
    });
    $('.viewButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
        $('#modalHeader').html('<h3> '+ $(this).attr('header') +'</h3>');
    });

</script>
