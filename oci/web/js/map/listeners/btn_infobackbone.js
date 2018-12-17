/* global Ext, ol, map, geometry, geometries */


function setListenersBtnInfoBackbone() {
	
	var content = document.getElementById('popup-content');
	
	map.on('singleclick', function(evt) {
		var coordinate = evt.coordinate;
		var hdms = ol.coordinate.toStringHDMS(ol.proj.transform(
			coordinate, 'EPSG:3857', 'EPSG:4326'));

		content.innerHTML = '<p>You clicked here:</p><code>' + hdms +
			'</code>';
		console.log('aaaa');
		overlay.setPosition(coordinate);
	});
};
