/* global Ext, ol, map, geometry, geometries */

	
function setListenersBtnPolygon() {
	function addNewInteraction(id_ca_ba_survey) {
		draw = new ol.interaction.Draw({
			source: source,
			type: 'Polygon'
		});
		
		addFeatureListener = function(evt){
			var feature = evt.feature;
			var coords = feature.getGeometry().getCoordinates();
			coordsString = 'MULTIPOLYGON(((';
			for (i=0; i < coords[0].length; i++) {
				if(i != coords[0].length -1) {
					coordsString = coordsString + coords[0][i][0] + ' ' + coords[0][i][1] + ',';
				} else {
					coordsString = coordsString + coords[0][i][0] + ' ' + coords[0][i][1] + ')))';
				}
			}
			$.ajax({
			    type: 'POST',
				url: "createpolygon", 
				data: { 
					'coordinates':coordsString,
					'id_ca_ba_survey': id_ca_ba_survey 
				},
				success: function(result){
					$('.drawButton').removeClass('selected');
					$('#map').removeClass('draw');
					center = map.getView().getCenter();
					map.getView().setCenter([center[0]+0.001, center[1]]);
				}
			});
			
			setTimeout(function(){
				map.removeLayer(drawVector);
				map.removeInteraction(draw);
				source.un('addfeature',addFeatureListener);
				source.clear();
				
				$.pjax.reload({container:'#pjax',timeout: false});
			},400);
		}
		
		source.on('addfeature', addFeatureListener);
		
		map.addInteraction(draw);
	}
	
	function addModifyInteraction(id_survey,geometry) {
		
		
		arrGeometries = geometry.split(",");
		arrVertices = [];
		for(var i=0 ; i < arrGeometries.length; i++ ) {
			arrVertices.push(arrGeometries[i].split(" "));
		}
		console.log(arrVertices);
		var modifyPolygon = new ol.geom.Polygon( [arrVertices] );var 
		featurePolygon = new ol.Feature({
			name: "modifyPolygon",
			geometry: modifyPolygon
		});
		
		console.log(featurePolygon);
		source.addFeature( featurePolygon );
		
		
		draw = new ol.interaction.Modify({
			features: featurePolygon,
		});
		
		setTimeout(function(){
			source.on('addfeature', function(evt){
				var feature = evt.feature;
				var coords = feature.getGeometry().getCoordinates();
				for (i=0; i < coords[0].length; i++) {
					if(i != coords[0].length -1) {
						coordsString = coordsString + coords[0][i][0] + ' ' + coords[0][i][1] + ',';
					} else {
						coordsString = coordsString + coords[0][i][0] + ' ' + coords[0][i][1] + '))';
					}
				}
				$.ajax({
					type: 'POST',
					url: "/create_polygon", 
					data: { 
						'coordinates':coordsString,
						'id_ca_ba_survey': id_ca_ba_survey 
					},
					success: function(result){
						$('.drawButton').removeClass('selected');
						$('#map').removeClass('draw');
						center = map.getView().getCenter();
						map.getView().setCenter([center[0]+0.001, center[1]]);
					}
				});
				
				setTimeout(function(){
					map.removeLayer(drawVector);
					map.removeInteraction(draw);
					source.un('addfeature');
					source.clear();
				},400);
			});
		},100);
		
		map.addInteraction(draw);
	}
	
	$('.drawButton').off();
	$('.drawButton').click(function(){
		if($(this).hasClass('selected')) {
			$('.drawButton').removeClass('selected');
			$('#map').removeClass('draw');
			map.removeLayer(drawVector);
			map.removeInteraction(draw);
			source.un('addfeature',addFeatureListener);
		} else {
			$('.drawButton').removeClass('selected');
			$(this).addClass('selected');
			map.addLayer(drawVector);
			var id_ca_ba_survey = $(this).attr('value');
			$('#map').addClass('draw');
			addNewInteraction(id_ca_ba_survey);
		}
		
	});
	
};

$(document).on('ready pjax:success',function() {
	setListenersBtnPolygon();
});
