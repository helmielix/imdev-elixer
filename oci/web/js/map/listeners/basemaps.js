// Create Function for add Listeners to Basemap Button
setListenersBasemap = function() {
	// Declare generic function for set active basemap. Only 1 basemap can be active at a time
	function setActiveBasemap(id) {
		if (id == 'basemapGoogleStreet') {basemapGoogleStreet.setVisible(true);} else {basemapGoogleStreet.setVisible(false);}
		if (id == 'basemapGoogleSatellite') {basemapGoogleSatellite.setVisible(true);} else {basemapGoogleSatellite.setVisible(false);}
		if (id == 'basemapGoogleHybrid') {basemapGoogleHybrid.setVisible(true);} else {basemapGoogleHybrid.setVisible(false);}
		if (id == 'basemapGoogleTerrain') {basemapGoogleTerrain.setVisible(true);} else {basemapGoogleTerrain.setVisible(false);}
	}
	
	// Add Listeners for basemapGoogleStreet button
	$("#basemap_googlestreetmap").click(function() {
		if($(this).hasClass('selected')) {setActiveBasemap('basemapGoogleStreet')} else {setActiveBasemap('')};
	});
	
	// Add Listeners for basemapGoogleSatellite button
	$("#basemap_googlesatellite").click(function() {
		if($(this).hasClass('selected')) {setActiveBasemap('basemapGoogleSatellite')} else {setActiveBasemap('')};
	});
	
	// Add Listeners for basemapGoogleHybrid button
	$("#basemap_googlehybrid").click(function() {
		if($(this).hasClass('selected')) {setActiveBasemap('basemapGoogleHybrid')} else {setActiveBasemap('')};
	});
	
	// Add Listeners for basemapGoogleTerrain button
	$("#basemap_googleterrain").click(function() {
		if($(this).hasClass('selected')) {setActiveBasemap('basemapGoogleTerrain')} else {setActiveBasemap('')};
	});
}

$(window).ready(setListenersBasemap);