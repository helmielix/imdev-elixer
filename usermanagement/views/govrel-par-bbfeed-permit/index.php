<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\GovrelParBbfeedPermit;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel govrel\models\GovrelparbbfeedpermitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Govrel Parameter PIC Backbone Feeder Permit';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@commonpath/css/olmap_with_grid.css',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/mapresize.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/btn_modal.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/map/listeners/btn_modal_osp.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/map/listeners/btn_drawpolygon.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/popup_alert.js',['depends' => [\yii\web\JqueryAsset::className()]]); 
$this->registerJsFile('@commonpath/js/olmap/listeners/btn_resizepanel.js',['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<?php Modal::begin([
		'header'=>'<h3 id="modalHeader"></h3>',
		'id'=>'modal',
		'size'=>'modal-lg',
		 
	]); 

	echo '<div id="modalContent"> </div>';

	Modal::end();
?>

<?= $this->render(
	'../../../common/views/olmap.php'
) ?>

<div id="southPanel" > 
	<div id="southPanelHeader">
		Parameter PIC Backbone Feeder Permit 
		<div class="panelZoomController">
			<span class="panelZoomButton up"> &#x2912; </span>
			<span class="panelZoomSeparator"> </span>
			<span class="panelZoomButton down"> &#x2913; </span>
		</div>
		<?=  Yii::$app->controller->action->id == 'index' ? Html::a('Create', '#create', ['class' => 'btn btn-success headerButton', 'id' => 'createModal', 'value'=>Url::to(['govrel-par-bbfeed-permit/create']), 'header'=> yii::t('app','Create Parameter PIC Backbone Feeder Permit')]) : '' ?>
		<!--<?=  Yii::$app->controller->action->id == 'index' ? Html::a('Upload', '#upload', ['class' => 'btn btn-success headerButton', 'id' => 'uploadModal', 'value'=>Url::to(['backbonefeederpermit/upload']), 'header'=> yii::t('app','Upload Backbone Feeder Permit')]) : ''?>-->
	</div>

    <div id="southPanelGrid"> 
	<?php \yii\widgets\Pjax::begin(['id' => 'pjax',]); ?>
      <?php function getFilterStatus() {
	       if(Yii::$app->controller->action->id == 'index') 
								
				     return [
						 1 => 'Inputted',
						
						 
					] ;
					
					
			if   (Yii::$app->controller->action->id == 'indexverify') 
				
					
				    return [  
					    1 => 'Inputted',
						4 => 'Verified',
						2 => 'Revised',
						
					] ;
					
				
			 if (Yii::$app->controller->action->id == 'indexapprove') 
					
					 
				     return [
					    1 => 'Inputted',
                        5 => 'Approved',
					
                     ]   ;    
	         
	        } ; ?>
			
			<?php function getFilterStatusPar() {
	       if(Yii::$app->controller->action->id == 'index') 
								
				     return [
						 27 => 'Active',
						 18 => 'Non Active',
						 
					] ;
					
					
					
			 if (Yii::$app->controller->action->id == 'indexapprove') 
					
					 
				     return [
					    
                        27 => 'Active',
						18 => 'Non Active',
					
                     ]   ;    
	         
	             } ; ?>
	
	
	
   
     <?= GridView::widget([
        'id' => 'gridView',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => "<span style='float: right; margin-right: 10px'> Showing {begin} - {end} of {totalCount} items </span>",
        'columns' => [
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view} {verify} {approve} {update} {download}',
				'buttons' => [
				

                                'view' => function ($url, $model) {
							return Yii::$app->controller->action->id == 'index' ? Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#view?id='.$model->id.'&header=Detail_Parameter_PIC_Backbone_Feeder_Permit', [
										'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['govrel-par-bbfeed-permit/view', 'id' => $model->id]), 'header'=> yii::t('app','Detail Parameter PIC Backbone Feeder Permit')
							]) : '';
						},

			
				'verify' => function ($url, $model) {
							return Yii::$app->controller->action->id == 'indexverify' ? Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#viewverify?id='.$model->id.'&header=Detail_Parameter_PIC_Backbone_Feeder_Permit', [
										'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['govrel-par-bbfeed-permit/viewverify', 'id' => $model->id]), 'header'=> yii::t('app','Detail Parameter PIC Backbone Feeder Permit')
							]) : '';
						},

				
				'approve' => function ($url, $model) {
							return Yii::$app->controller->action->id == 'indexapprove' ?  Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-eye-open"></span>', '#viewapprove?id='.$model->id.'&header=Detail_Parameter_PIC_Backbone_Feeder_Permit', [
										'title' => Yii::t('app', 'view'), 'class' => 'viewButton', 'value'=>Url::to(['govrel-par-bbfeed-permit/viewapprove', 'id' => $model->id]), 'header'=> yii::t('app','Detail Parameter PIC Backbone Feeder Permit')
							]) : '';
						},

			

          
                'update' => function ($url, $model) {
							return Yii::$app->controller->action->id == 'index' ?  Html::a('<span style="margin:0px 2px" class="glyphicon glyphicon-pencil"></span>', '#update?id='.$model->id.'&header=Update_Parameter_PIC_Backbone_Feeder_Permit', [
										'title' => Yii::t('app', 'update'), 'class' => 'viewButton', 'value'=>Url::to(['govrel-par-bbfeed-permit/update', 'id' => $model->id]), 'header'=> yii::t('app','Update Parameter PIC Backbone Feeder Permit')
							]) : '';
						},
						
					

           
                'delete' => function ($url, $model) {
                        return Yii::$app->controller->action->id == 'index' ? Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('app', 'delete'),
					    'data' => [
					    'confirm' => 'Are you sure you want to delete this item?',
							'method' => 'post'
					],
					    
                ]): '';
				
				
            }

          ],
          'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='view?id='.$model->id.'#Detail Parameter Backbone Feeder Permit';
                return $url;
            }
			
			 if ($action === 'verify') {
                $url ='viewverify?id='.$model->id.'#Detail Parameter Backbone Feeder Permit';
                return $url;
            }
			
			if ($action === 'approve') {
                $url ='viewapprove?id='.$model->id.'#Approve Parameter Backbone Feeder Permit';
                return $url;
            }

            if ($action === 'update') {
                $url ='update?id='.$model->id.'#Update Parameter Backbone Feeder Permit';
                return $url;
            }
			
            if ($action === 'delete') {
                $url ='delete?id='.$model->id.'#Delete Parameter Backbone Feeder Permit';
                return $url;
            }

          }
          ],
            ['class' => 'yii\grid\SerialColumn'],

             [
                    'attribute' => 'status_listing',
                    'format' => 'raw',
                    'value' => function ($searchModel) {
                        return isset($searchModel->status_listing)  ? "<span class='label' style='background-color:{$searchModel->statusReference->status_color}' >{$searchModel->statusReference->status_listing}  </span>" : '';
												
                    },
                    'filter' => getFilterStatus()

            ],
            
               'name',
			   [
					'attribute' => 'status_par',
					'format' => 'raw',
					'value' => function ($searchModel) {
							if (isset($searchModel->status_par)){
								return "<span >{$searchModel->statusReferenceStatusParameter->status_listing}</span>" ;
							}					
						},
					'filter' => getFilterStatusPar() 
			],

     ],
    ]); ?>
<?php \yii\widgets\Pjax::end(); ?>
  </div>

</div>



