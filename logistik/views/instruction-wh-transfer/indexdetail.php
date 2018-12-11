<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use common\models\Reference;

$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);

?>
<div class="instruction-wh-transfer-detail-index">

	<?php if( /*($this->context->action->id == 'view' && $model->status_listing != 6) || */$this->context->action->id == 'deletedetail' || $this->context->action->id == 'indexdetail' ){ ?>
    <p>
        <?= Html::button(Yii::t('app','Add'), ['id'=>'createButton','class' => 'btn btn-success']) ?>
    </p>
	<?php } ?>
	<?php Pjax::begin([
			'id' => 'pjaxindexdetail',
			'timeout' => false,
			'enablePushState' => false,
			'clientOptions' => ['method' => 'GET', 'backdrop' => false,
			// "container" => "#pjaxindexdetail"
			],
		]); ?>
    <?= GridView::widget([
        'id' => 'gridViewindexdetail',
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'floatHeader'=>true,
		'floatOverflowContainer' => true,
        // 'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {delete}',
                'buttons'=>[
                    'delete' => function ($url, $model) {
						return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-trash"></span>', '', [
                            'title' => Yii::t('app', 'delete'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/deletedetail', 'id' => $model->id]), 'header'=> yii::t('app','Detail Instruksi Warehouse Transfer')
                        ]);
                    },

                    'update' => function ($url, $model) {
						return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>', '#', [
                            'title' => Yii::t('app', 'update'), 'class' => 'viewButton', 'value'=>Url::to([$this->context->id.'/updatedetail', 'idDetail'=> $model->id]), 'header'=> yii::t('app','Update Detail Warehouse Transfers Instruction')
                        ]);
                    },
                ],
				'visible' => ( $this->context->action->id == 'deletedetail' || $this->context->action->id == 'indexdetail' ),
				// 'visible' => ($this->context->action->id == 'view' || $this->context->action->id == 'deletedetail'),
            ],

			[
				'attribute' => 'id_item_im',
				// 'value' => 'idMasterItemImDetail.idMasterItemIm.im_code',
				'value' => 'idMasterItemIm.im_code',
			],
			[
				'attribute' => 'name',
				// 'value' => 'idMasterItemImDetail.idMasterItemIm.name',
				'value' => 'idMasterItemIm.name',
			],
			[
				'attribute' => 'brand',
				// 'value' => 'idMasterItemImDetail.idMasterItemIm.referenceBrand.description',
				'value' => 'idMasterItemIm.referenceBrand.description',
                'filter' => Arrayhelper::map(Reference::find()->andWhere(['table_relation' => 'brand'])->all(), 'id', 'description'),
			],
			[
				'attribute' => 'warna',
				// 'value' => 'idMasterItemImDetail.idMasterItemIm.referenceWarna.description',
				'value' => 'idMasterItemIm.referenceWarna.description',
                'filter' => Arrayhelper::map(Reference::find()->andWhere(['table_relation' => 'warna'])->all(), 'id', 'description'),
			],
			[
				'attribute' => 'sn_type',
				// 'value' => 'idMasterItemImDetail.idMasterItemIm.referenceSn.description',
				'value' => 'idMasterItemIm.referenceSn.description',
				'filter' => ArrayHelper::map(Reference::find()->andWhere(['table_relation' => 'sn_type'])->all(), 'id_grouping', 'description'),
			],

			
            [
                'attribute' => 'req_good',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'req_not_good',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'req_reject',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'req_dismantle',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'req_revocation',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'req_good_rec',
                'enableSorting' => false,
            ],
            [
                'attribute' => 'req_good_for_recond',
                'enableSorting' => false,
            ],			

        ],
    ]); ?>
	<?php yii\widgets\Pjax::end() ?>
	<?php if( /*($this->context->action->id == 'view' && $model->status_listing != 6) || */$this->context->action->id == 'deletedetail' || $this->context->action->id == 'indexdetail' ){ ?>
    <p>
		<?php if(Yii::$app->controller->action->id == 'indexdetail' || $this->context->action->id == 'deletedetail')
			echo Html::button(Yii::t('app','Previous'), ['id'=>'previousButton','class' => 'btn btn-primary']);  ?>
		<?= Html::button(Yii::t('app','Submit Instruction'), ['id'=>'submitButton','class' => 'btn btn-success']) ?>
		<?= Html::button(Yii::t('app','cancle'), ['id'=>'cancelButton','class' => 'btn btn-success hidden']) ?>
    </p>
	<?php } ?>
</div>

<script>

    $('#createButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php
			$par = null;
			if (basename(Yii::$app->request->pathInfo) == 'indexdetail'){
				$par = 'indexdetail';
			}
			echo Url::to([$this->context->id.'/createdetail', 'par' => $par]) ;?>');
        $('#modalHeader').html('<h3> Create Detail Instruksi Warehouse Transfer</h3>');
    });

    $('#previousButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load('<?php echo Url::to([$this->context->id.'/update','id'=>Yii::$app->session->get('idInstWhTr')]) ;?>');
        $('#modalHeader').html('<h3> Detail Instruksi Warehouse Transfer </h3>');
    });

    $('#submitButton').click(function () {
		var button = $(this);
		button.prop('disabled', true);
        button.append(' <i id="spinRefresh" class="fa fa-spin fa-refresh"></i>');

		$.ajax({
            url: '<?php echo Url::to([$this->context->id.'/submit', 'id' => Yii::$app->session->get('idInstWhTr')]) ;?>',
            type: 'post',
            processData: false,
            contentType: false,
            success: function (response) {
                if(response == 'success') {
                    $('#modal').modal('hide');
                } else {
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
