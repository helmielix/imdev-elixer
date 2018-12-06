

<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Alert;
use dosamigos\datepicker\DatePicker;
use kartik\export\ExportMenu;


if(Yii::$app->controller->action->id == 'index') $this->title = Yii::t('app','Input BA Survey');
if(Yii::$app->controller->action->id == 'indexverify') $this->title = Yii::t('app','Verify BA Survey');
if(Yii::$app->controller->action->id == 'indexapprove') $this->title = Yii::t('app','Approve BA Survey');

$this->registerCssFile('@commonpath/css/olmap_with_grid.css',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/mapresize.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/map/listeners/btn_drawpolygon.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/listeners/btn_zoomto.js',['depends' => [\yii\web\JqueryAsset::className()]]); 
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
		Homepass List
		<?=  Html::a('Setting', '#setting?header=List_Setting', ['class' => 'btn btn-success headerButton', 'id' => 'createModal', 'value'=>Url::to(['homepass/setting']), 'header'=> yii::t('app','List Setting')])?>
		
	</div>

	<div id="southPanelGrid"> 
	<?php function getFilterStatus() {
		if(Yii::$app->controller->action->id == 'index') 
			return [
				1 => 'Inputted',
				2 => 'Revised',
				3 => 'Need Revise',
				6 => 'Rejected',
				7 => 'Drafted',
				999 => 'No Status'
			];
	} ; ?>
	<?php \yii\widgets\Pjax::begin(['id' => 'pjax']); ?>
		<?php 
			$setting = \Yii::$app->session->get('homepass-setting');
			$columns = []; 
			array_push($columns,
				['class' => 'yii\grid\SerialColumn']
			);
			array_push($columns,
				[
					'class' => 'yii\grid\ActionColumn',
					'header' => 'Actions',
					'headerOptions' => ['style' => 'color:#337ab7'],
					'template' => '{view}{zoomto}',
					'buttons' => [
						'view' => function ($url, $model) {
									if(Yii::$app->controller->action->id == 'index') $viewurl = 'view'; 
									if(Yii::$app->controller->action->id == 'indexverify') $viewurl = 'viewverify'; 
									if(Yii::$app->controller->action->id == 'indexapprove') $viewurl = 'viewapprove'; 
									if(Yii::$app->controller->action->id == 'indexoverview') $viewurl = 'viewoverview'; 
									return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#'.$viewurl.'?id='.$model->id.'&header=Detail_Berita_Acara_Survey', [
											'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['/homepass/'.$viewurl, 'id' => $model->id]), 'header'=> yii::t('app','Detail Berita Acara Survey')
								]);
						},
						'draw' => function ($url, $model) {
									return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-edit"></span>', '#', [
											'title' => Yii::t('app', 'draw polygon'), 'class' => 'drawButton', 'value'=>$model->id
								]);
						},
						'zoomto' => function ($url, $model) {
							if($model->geom != '') {
									return Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-screenshot"></span>', '#', [
											'title' => Yii::t('app', 'zoom to map object'), 'class' => 'zoomtoButton', 'value'=>$model->id
								]);
							}
						},
						
			  
					],
				]
			
			);
			
			if(in_array("hp_type", $setting)) array_push($columns,"hp_type");
			if(in_array("id", $setting)) array_push($columns,"id");
			if(in_array("potency_type", $setting)) array_push($columns,"potency_type");
			if(in_array("iom_type", $setting)) array_push($columns,"iom_type");
			if(in_array("kodepos", $setting)) array_push($columns,"kodepos");
			if(in_array("streetname", $setting)) array_push($columns,"streetname");
			if(in_array("home_number", $setting)) array_push($columns,"home_number");
			
		?>
		
		<div>
			<?= ExportMenu::widget([
				'dataProvider' => $dataProvider,
				'columns' => $columns
			]); ?>
		</div>
		
		 <?= GridView::widget([
				'id' => 'gridView',
				'dataProvider' => $dataProvider,
				'filterModel' => $searchModel,
				'columns' => $columns,
			]); ?>
	<?php \yii\widgets\Pjax::end(); ?>
    </div>
</div>
