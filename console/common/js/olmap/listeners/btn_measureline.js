setListenersBtnMeasureline = function() {
	var helpTooltip;
	var measureTooltip;
	
	measurelineFunction = function(e) {
		if (e.key  == 'z' && e.ctrlKey)  
			drawMeasurementline.removeLastPoint()
	}
	
				
	$('.icon_measureline').click(function(){
		if($(this).hasClass('selected')) {
			document.addEventListener('keydown', measurelineFunction);
			var wgs84Sphere = new ol.Sphere(6378137);
			
			pointerMoveHandler = function(evt) {
				if (evt.dragging) {
				  return;
				}
				/** @type {string} */
				var helpMsg = 'Klik kiri untuk memulai';

				if (sketch) {
					helpMsg = continueLineMsg;
				}

				helpTooltipElement.innerHTML = helpMsg;
				helpTooltip.setPosition(evt.coordinate);

				helpTooltipElement.classList.remove('hidden');
			};
			
			var sketch;
			var helpTooltipElement;
			var measureTooltipElement;
			var continueLineMsg = 'Dobel Klik untuk selesai atau Klik Kiri untuk melanjutkan';
			
			addPointerMoveListener = map.on('pointermove', pointerMoveHandler);
			map.getViewport().addEventListener('mouseout', function() {
				helpTooltipElement.classList.add('hidden');
			});
			
			var formatLength = function(line) {
				var length;
				var coordinates = line.getCoordinates();
				length = 0;
				var sourceProj = map.getView().getProjection();
				for (var i = 0, ii = coordinates.length - 1; i < ii; ++i) {
					var c1 = ol.proj.transform(coordinates[i], sourceProj, 'EPSG:4326');
					var c2 = ol.proj.transform(coordinates[i + 1], sourceProj, 'EPSG:4326');
					length += wgs84Sphere.haversineDistance(c1, c2);
				}
				var output;
				if (length > 100) {
				  output = (Math.round(length / 1000 * 100) / 100) +
					  ' ' + 'km';
				} else {
				  output = (Math.round(length * 100) / 100) +
					  ' ' + 'm';
				}
				return output;
			};
			
			function addInteraction() {
				drawMeasurementline = new ol.interaction.Draw({
					source: sourceMeasurement,
					type: 'LineString',
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
				map.addInteraction(drawMeasurementline);
				
				createMeasureTooltip();
				createHelpTooltip();

				var listener;
				

				drawMeasurementline.on('drawstart',
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

				drawMeasurementline.on('drawend',
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

$(window).ready(setListenersBtnMeasureline);
