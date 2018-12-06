setListenersBtnMeasurearea = function() {
	var helpTooltip;
	var measureTooltip;
	
	measureareaFunction = function(e) {
		if (e.key  == 'z' && e.ctrlKey)  
			drawMeasurementarea.removeLastPoint()
	}
	
	$('.icon_measurearea').click(function(){
		if($(this).hasClass('selected')) {
			document.addEventListener('keydown', measureareaFunction);
			var wgs84Sphere = new ol.Sphere(6378137);
			
			var pointerMoveHandler = function(evt) {
				if (evt.dragging) {
				  return;
				}
				/** @type {string} */
				var helpMsg = 'Klik kiri untuk memulai';

				if (sketch) {
					helpMsg = continuePolygonMsg;
				}

				helpTooltipElement.innerHTML = helpMsg;
				helpTooltip.setPosition(evt.coordinate);

				helpTooltipElement.classList.remove('hidden');
			};
			
			var sketch;
			var helpTooltipElement;
			var measureTooltipElement;
			var continuePolygonMsg = 'Dobel Klik untuk selesai atau Klik Kiri untuk melanjutkan';
			
			addPointerMoveListener = map.on('pointermove', pointerMoveHandler);
			map.getViewport().addEventListener('mouseout', function() {
				helpTooltipElement.classList.add('hidden');
			});
			
			var formatArea = function(polygon) {
				var area;
				var sourceProj = map.getView().getProjection();
				var geom = /** @type {ol.geom.Polygon} */(polygon.clone().transform(
					  sourceProj, 'EPSG:4326'));
				var coordinates = geom.getLinearRing(0).getCoordinates();
				area = Math.abs(wgs84Sphere.geodesicArea(coordinates));
				var output;
				if (area > 10000) {
				  output = (Math.round(area / 1000000 * 100) / 100) +
					  ' ' + 'km<sup>2</sup>';
				} else {
				  output = (Math.round(area * 100) / 100) +
					  ' ' + 'm<sup>2</sup>';
				}
				return output;
			};
			
			function addInteraction() {
				drawMeasurementarea = new ol.interaction.Draw({
					source: sourceMeasurement,
					type: 'Polygon',
					style: new ol.style.Style({
						fill: new ol.style.Fill({
							color: 'rgba(255, 255, 255, 0.2)'
						}),
						stroke: new ol.style.Stroke({
							color: 'rgba(0, 0, 0, 0.5)',
							lineDash: [10, 10],
							width: 2
						}),
						image: new ol.style.Circle({
							radius: 5,
							stroke: new ol.style.Stroke({
								color: 'rgba(0, 0, 0, 0.7)'
							}),
							fill: new ol.style.Fill({
								color: 'rgba(255, 255, 255, 0.2)'
							})
						})
					})
				});
				map.addInteraction(drawMeasurementarea);
				
				createMeasureTooltip();
				createHelpTooltip();

				var listener;
				drawMeasurementarea.on('drawstart',
					function(evt) {
						// set sketch
						sketch = evt.feature;

						/** @type {ol.Coordinate|undefined} */
						var tooltipCoord = evt.coordinate;

						listener = sketch.getGeometry().on('change', function(evt) {
							var geom = evt.target;
							var output;
							if (geom instanceof ol.geom.Polygon) {
							  output = formatArea(geom);
							  tooltipCoord = geom.getInteriorPoint().getCoordinates();
							} else if (geom instanceof ol.geom.LineString) {
							  output = formatLength(geom);
							  tooltipCoord = geom.getLastCoordinate();
							}
							measureTooltipElement.innerHTML = output;
							measureTooltip.setPosition(tooltipCoord);
						});
					}, this);

				drawMeasurementarea.on('drawend',
					function() {
					  measureTooltipElement.className = 'tooltip tooltip-static';
					  measureTooltip.setOffset([0, -7]);
					  // unset sketch
					  sketch = null;
					  // unset tooltip so that a new one can be created
					  measureTooltipElement = null;
					  createMeasureTooltip();
					  ol.Observable.unByKey(listener);
					}, this);
			}
			

			function createHelpTooltip() {
				if (helpTooltipElement) {
				  helpTooltipElement.parentNode.removeChild(helpTooltipElement);
				}
				helpTooltipElement = document.createElement('div');
				helpTooltipElement.className = 'tooltip hidden';
				helpTooltip = new ol.Overlay({
					element: helpTooltipElement,
					offset: [15, 0],
					positioning: 'center-left'
				});
				map.addOverlay(helpTooltip);
			}
		  
			function createMeasureTooltip() {
				if (measureTooltipElement) {
					measureTooltipElement.parentNode.removeChild(measureTooltipElement);
				}
				measureTooltipElement = document.createElement('div');
				measureTooltipElement.className = 'tooltip tooltip-measure';
				measureTooltip = new ol.Overlay({
				  element: measureTooltipElement,
				  offset: [0, -15],
				  positioning: 'bottom-center'
				});
				map.addOverlay(measureTooltip);
			}
			
			addInteraction();
		}
	});
};

$(window).ready(setListenersBtnMeasurearea);
