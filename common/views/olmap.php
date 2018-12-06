<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\Region;
use yii\web\View;
// Googlemaps Lib
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyA5gyjP3gjmHMWxYEuWv_MIAXl9tGYllI4');
$this->registerJsFile('@commonpath/js/lib/ol3-google-maps-v0.13.1/ol3gm.js');
$this->registerCssFile('@commonpath/js/lib/ol3-google-maps-v0.13.1/ol3gm.css');

// JqueryUI Lib
$this->registerCssFile('@commonpath/css/jquery-ui.css',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@commonpath/css/jquery-ui_override.css',['depends' => [\yii\web\JqueryAsset::className()]]);

// Map Lib
$this->registerCssFile('@commonpath/css/olmap.css',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@commonpath/css/olmap_with_grid.css',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/initmap.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/initcomponent.js',['depends' => [\yii\web\JqueryAsset::className()]]);

// Map Listeners
$this->registerJsFile('@commonpath/js/olmap/listeners/btn_featuresinfo.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/listeners/btn_featuressummary.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/listeners/btn_streetview.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/listeners/btn_zoomin.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/listeners/btn_zoomout.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/listeners/btn_zoomtoextent.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/listeners/btn_zoomtoregion.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/listeners/btn_measureline.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/listeners/btn_measurearea.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/listeners/btn_zoomtoregion.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/listeners/basemaps.js',['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@commonpath/js/olmap/listeners/layers.js',['depends' => [\yii\web\JqueryAsset::className()]]);


?>


    
<div id="map"> 
	<div id="mapToolbar">
	
		<button class="ui-button ui-widget ui-corner-all ui-button-icon-only icon_info toggleButton" title="Get Information"></button>
		
		<span class="buttonSeparator">  </span>
		<button class="ui-button ui-widget ui-corner-all ui-button-icon-only icon_streetview toggleButton" title="Street View"></button>
		<span class="buttonSeparator">  </span>
		<button class="ui-button ui-widget ui-corner-all ui-button-icon-only icon_zoomin" title="Zoom In"></button>
		<button class="ui-button ui-widget ui-corner-all ui-button-icon-only icon_zoomout" title="Zoom Out"></button>
		<button class="ui-button ui-widget ui-corner-all ui-button-icon-only icon_zoomtoextent" title="Zoom To Extent"></button>
		<button class="ui-button ui-widget ui-corner-all ui-button-icon-only icon_zoomtoregion toolbarPanelController toggleButton" title="Zoom To Region"></button>
		<span class="buttonSeparator">  </span>
		<button class="ui-button ui-widget ui-corner-all ui-button-icon-only icon_measurearea backgroundright toggleButton" title="Measure Area"></button>
		<button class="ui-button ui-widget ui-corner-all ui-button-icon-only icon_measureline toggleButton" title="Measure Line"></button>
		<span class="buttonSeparator">  </span>
		<button class="ui-button ui-widget ui-corner-all ui-button-icon-only icon_layer toolbarPanelController toggleButton" title="Layer Setting"></button>
		<button class="ui-button ui-widget ui-corner-all ui-button-icon-only icon_basemap backgroundright toolbarPanelController toggleButton" title="Basemap Setting"></button>
		<span class="buttonSeparator">  </span>
		<button class="ui-button ui-widget ui-corner-all ui-button-icon-only icon_legend right toolbarPanelController toggleButton" title="Legends"></button>
		<div id="zoomtoRegionPanel" class="toolbarPanel">
			<?= Html::dropDownList('region', null,  ArrayHelper::map(Region::find()->andWhere(['status'=>27])->andWhere(['not', ['latitude' => null]])->orderBy(['name'=> SORT_ASC])->all(), 'id', 'name'),  ['prompt'=>'Select Region...']); ?>
			
		</div>
		<div id="zoomtoXYPanel" class="toolbarFunctionPanel">
		</div>
		<div id="layerPanel" class="toolbarPanel">
			<div class="toolbarPanelButton layerButton selected" id="layer_caboundary">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText selected"> CA Boundary</div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton selected" id="layer_area_redline">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText selected"> Redline History</div>
				</div>
			</div>
			<!--
			<div class="toolbarPanelButton layerButton" id="layer_jalan">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText"> Coorporate Boundary </div>
				</div>
			</div>
			-->
			<div class="toolbarPanelButton layerButton selected" id="layer_homepass">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText selected"> Homepass (P)</div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton selected" id="layer_homepass">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText selected"> Homepass (B)</div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton" id="layer_jalur_backbone_plan">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText"> Backbone (P)</div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton selected" id="layer_jalur_backbone_built">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText selected"> Backbone (B)</div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton" id="layer_olt_plan">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText"> OLT (P)</div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton selected" id="layer_olt_built">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText selected"> OLT (B)</div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton" id="layer_odc_plan">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText"> ODC (P)</div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton selected" id="layer_odc_built">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText selected"> ODC (B)</div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton" id="layer_odp_plan">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText"> ODP (P)</div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton selected" id="layer_odp_built">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText selected"> ODP (B)</div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton" id="layer_pole_plan">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText"> Pole (P)</div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton selected" id="layer_pole_built">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText selected"> Pole (B)</div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton selected" id="layer_pole_history">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText"> Pole History</div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton" id="layer_jalur_feeder_plan">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText"> Feeder (P) </div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton selected" id="layer_jalur_feeder_built">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText selected"> Feeder (B) </div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton" id="layer_closure_plan">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText"> Closure (P) </div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton selected" id="layer_closure_built">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText selected"> Closure (B) </div>
				</div>	
			</div>
			<div class="toolbarPanelButton layerButton" id="layer_slack_support_plan">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText"> Slack Support (P) </div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton selected" id="layer_slack_support_built">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText selected"> Slack Support (B) </div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton" id="layer_hand_hole_plan">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText"> Hand Hole (P) </div>
				</div>
			</div>
			<div class="toolbarPanelButton layerButton selected" id="layer_hand_hole_built">
				<div class = "toolbarPanelButtonTextContainer"> 
					<div class = "toolbarPanelButtonText selected"> Hand Hole (B) </div>
				</div>
			</div>
		</div>
		<div id="basemapPanel" class="toolbarPanel">
			<div class="toolbarPanelButton basemapButton selected" id="basemap_googlestreetmap">
				<div class = "toolbarPanelButtonText selected"> Google Street</div>
			</div>
			<div class="toolbarPanelButton basemapButton" id="basemap_googlehybrid">
				<div class = "toolbarPanelButtonText"> Google Hybrid </div>
			</div>
			<div class="toolbarPanelButton basemapButton" id="basemap_googlesatellite">
				<div class = "toolbarPanelButtonText"> Google Sattelite </div>
			</div>
			<div class="toolbarPanelButton basemapButton" id="basemap_googleterrain">
				<div class = "toolbarPanelButtonText"> Google Terrain </div>
			</div>
		</div>
		<?php $arrayStatusColor = ArrayHelper::map(\common\models\MapBoundaryColor::find()->orderBy(['status_area'=>SORT_ASC])->select('*')->distinct()->all(), 'color', 'color') ; ?>
		<?php $arrayStatusCondition = ArrayHelper::map(\common\models\MapBoundaryColor::find()->orderBy(['status_area'=>SORT_ASC])->select('*')->distinct()->all(), 'color', 'note') ; ?>
		<div id="legendPanel" class="toolbarPanel" style="height:<?= ((count($arrayStatusCondition)*20) + 30)?>px">
			<div> 
				<span class="legend_header_block">Status Area</span>	
				<?php foreach($arrayStatusColor as $k => $v) { ?>
					<div class="legend_icon_block" style="background:<?= $arrayStatusColor[$k]?>"> </div>
					<div class="legend_text_block"> <?= $arrayStatusCondition[$k]?> </div>
				<?php } ?>
			</div>
		</div>
	</div>
	
</div>

<div id="popup" class="ol-popup">
	<div id="popup-button-container"> 
		<a href="#" id="popup-closer" class="ol-popup-button"></a>
		<a href="#" id="popup-next" class="ol-popup-button"></a>
		<span id="popup-pagination" class="ol-popup-pagination"></span>
		<a href="#" id="popup-prev" class="ol-popup-button"></a>
	</div>
	<div id="popup-content"></div>
</div>

<script>
	regionCoordinates = [
		<?php $regions = Region::find()->andWhere(['status'=>27])->andWhere(['not', ['latitude' => null]])->orderBy(['name'=> SORT_ASC])->all();
			for ($i=0; $i<count($regions); $i++) {
				echo "'".$regions[$i]->longitude.",".$regions[$i]->latitude."',";
			}
		?>
	];
	
</script>
