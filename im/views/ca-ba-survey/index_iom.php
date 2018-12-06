<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\BasurveySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if(Yii::$app->controller->action->id == 'index_iom') $this->title = Yii::t('app','Input IOM');
if(Yii::$app->controller->action->id == 'indexverify_iom') $this->title = Yii::t('app','Verify IOM');
if(Yii::$app->controller->action->id == 'indexapprove_iom') $this->title = Yii::t('app','Approve IOM');

$this->registerCssFile('@commonpath/css/olmap_with_grid.css',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/mapresize.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/listeners/btn_drawpolygon.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/listeners/btn_resizepanel.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/popup_alert.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<?php Modal::begin([
		'header'=>'<h3 id="modalHeader"></h3>',
		'id'=>'modal',
		'size'=>'modal-lg'
	]);

	echo '<div id="modalContent"> </div>';

	Modal::end();
?>

<?= $this->render(
	'../../../common/views/olmap.php'
) ?>

<div id="southPanel" >
	<div id="southPanelHeader">
		BA Survey List
		<div class="panelZoomController">
			<span class="panelZoomButton up"> &#x2912; </span>
			<span class="panelZoomSeparator"> </span>
			<span class="panelZoomButton down"> &#x2913; </span>
		</div>
		<?=  Yii::$app->controller->action->id == 'index' ? Html::a('Create', '#create', ['class' => 'btn btn-success headerButton', 'id' => 'createModal', 'value'=>Url::to(['ca-ba-survey/create']), 'header'=> yii::t('app','Create BA Survey')]) : '' ?>
		<?=  Yii::$app->controller->action->id == 'index' ? Html::a('Upload', '#upload', ['class' => 'btn btn-success headerButton', 'id' => 'uploadModal', 'value'=>Url::to(['ca-ba-survey/upload']), 'header'=> yii::t('app','Upload BA Survey')]) : ''?>
	</div>

	<div id="southPanelGrid">
	<?php function getFilterStatus() {
		if(Yii::$app->controller->action->id == 'index_iom') 
			return [
				1 => 'Inputted',
				2 => 'Revised',
				3 => 'Need Revise',
				6 => 'Rejected',
				999 => 'Creatable'
			];
		if(Yii::$app->controller->action->id == 'indexverify_iom') 
			return [
				1 => 'Inputted',
				2 => 'Revised',
				4 => 'Verified',
			];
		if(Yii::$app->controller->action->id == 'indexapprove_iom') 
			return [
				5 => 'Approved',
				4 => 'Verified'
			];
		if(Yii::$app->controller->action->id == 'indexoverview') 
			return [
				1 => 'Inputted',
				2 => 'Revised',
				3 => 'Need Revise',
				5 => 'Approved',
				4 => 'Verified',
				6 => 'Rejected',
			];
	} ; ?>
	<?php \yii\widgets\Pjax::begin(['id' => 'pjax',]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view} {verify} {approve} {create}',
                'buttons' => [
					'view' => function ($viewurl, $model) {
									if(Yii::$app->controller->action->id == 'index_potensial') $viewurl = 'view_potensial';
									if(Yii::$app->controller->action->id == 'indexverify_potensial') $viewurl = 'viewverify_potensial';
									if(Yii::$app->controller->action->id == 'indexverify_iom') $viewurl = 'viewverify_iom';
									if(Yii::$app->controller->action->id == 'indexapprove_iom') $viewurl = 'viewapprove_iom';
									if(Yii::$app->controller->action->id == 'index_iom') $viewurl = 'view_iom';
									return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#'.$viewurl.'?id='.$model->id.'&header=Detail_Berita_Acara_Survey', [
											'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['/ca-ba-survey/'.$viewurl, 'id' => $model->id]), 'header'=> yii::t('app','Detail Berita Acara Survey')
							]);
					},


					'create' => function ($url, $model) {
						if(Yii::$app->controller->action->id == 'index_potensial') {
							if($model->status_iom == null || $model->status_iom == '') {
								return  Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-plus"></span>', '#create_iom?id='.$model->id.'&header=Create_IOM', [
												'title' => Yii::t('app', 'create'), 'class' => 'viewButton', 'value'=>Url::to(['ca-ba-survey/create_iom', 'id' => $model->id]), 'header'=> yii::t('app','Create IOM')
								]);
							} else {
								return  Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>', '#create_iom?id='.$model->id.'&header=Update_IOM', [
												'title' => Yii::t('app', 'update'), 'class' => 'viewButton', 'value'=>Url::to(['ca-ba-survey/create_iom', 'id' => $model->id]), 'header'=> yii::t('app','Update IOM')
								]);
							}
						} else {
							return '';
						}
					},

				],
				  'urlCreator' => function ($action, $model, $key, $index) {
					if ($action === 'view') {
						$url = Url::to(['view_potensial','id'=>$model->id]);
						return $url;
					}

					 if ($action === 'verify') {
						$url = Url::to(['viewverify_potensial','id'=>$model->id]);
						return $url;
					}

					if ($action === 'approve') {
						$url = Url::to(['viewapprove_potensial','id'=>$model->id]);
						return $url;
					}

					if ($action === 'create') {
						$url = Url::to(['create_iom','id'=>$model->id]);
						return $url;
					}

				  }
			],

			[
				'attribute' => 'status_iom',
				'format' => 'raw',
				'value' => function ($searchModel) {
						if ($searchModel->status_iom) {
							if($searchModel->status_iom == 999){
								return "<span class='label' style='background-color:grey'>Creatable</span>";
							}else{
								return "<span class='label' style='background-color:{$searchModel->statusReferenceIom->status_color}' >{$searchModel->statusReferenceIom->displayText()}</span>";
							}
                        }
					},
				'filter' => getFilterStatus(),
			],
			[
				'attribute' => 'city',
				'value' => 'idArea.idSubdistrict.idDistrict.idCity.name'
			],
			[
				'attribute' => 'district',
				'value' => 'idArea.idSubdistrict.idDistrict.name'
			],
			[
				'attribute' => 'subdistrict',
				'value' => 'idArea.idSubdistrict.name'
			],
			'id_area',

			[
				'attribute' => 'updated_date',
				'value'  => 'updated_date',
				'format' => 'datetime',
				'filter' => DatePicker::widget([
					'model' => $searchModel,
					'attribute' => 'updated_date',
					'clientOptions' => [
						'autoclose' => true,
						'format' => 'yyyy-mm-dd',
					],
				]),
			]

        ],
        ]); ?>
	<?php \yii\widgets\Pjax::end(); ?>
    </div>
</div>
