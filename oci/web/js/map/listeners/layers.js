// Create Function for add Listeners to Basemap Button
setListenersLayer = function() {
	
	// Add Listeners for layer_potentialca button
	$("#layer_potentialca_modul").click(function() {
		if($(this).hasClass('selected')) {layer_potentialca_modul.setVisible(true)} else {layer_potentialca_modul.setVisible(false)};
	});
	
	// Add Listeners for layer_potentialca button
	$("#layer_potentialca").click(function() {
		if($(this).hasClass('selected')) {layer_potentialca.setVisible(true)} else {layer_potentialca.setVisible(false)};
	});
	
	// Add Listeners for layer_backbone button
	$("#layer_backbone").click(function() {
		if($(this).hasClass('selected')) {layer_backbone.setVisible(true)} else {layer_backbone.setVisible(false)};
	});
}

$(window).ready(setListenersLayer);