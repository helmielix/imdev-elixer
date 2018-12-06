setListenersBtnZoomToRegion = function() {
	$('#zoomtoRegionPanel select').change(function() { 
		arrCoordinate = regionCoordinates[$(this)[0].selectedIndex-1].split(',');
		console.log(arrCoordinate);
		if(arrCoordinate[0] != '') {
			arrCoordinateMercator = ol.proj.transform([arrCoordinate[0]*1,arrCoordinate[1]*1],'EPSG:4326','EPSG:3857');
			map.getView().setZoom(12);
			map.getView().setCenter(arrCoordinateMercator);
		}
	});
};

$(window).ready(setListenersBtnZoomToRegion);

