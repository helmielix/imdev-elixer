setListenersBtnStreetview = function() {
	function setFunctionStreetview(evt) {
		coordinates = ol.proj.transform(evt.coordinate, 'EPSG:3857','EPSG:4326');
		window.open('https://www.google.co.id/maps/?hl=en&cbll='+coordinates[1]+','+coordinates[0]+'&layer=c', '_blank');
		
		
	}
	
	$('.icon_streetview').click(function(){	
		if($(this).hasClass('selected')) {
			map.unByKey(btnListener);
			btnListener = map.on('singleclick', setFunctionStreetview);
		} 
	});
};

$(window).ready(setListenersBtnStreetview);
