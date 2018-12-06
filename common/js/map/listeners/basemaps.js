// Create Function for add Listener to Basemaps Button
setListenersBasemap = function() {
	$(".basemapButton").click(function() {
		$(".basemapButton").removeClass('selected');
		$('.basemapButton .toolbarPanelButtonText').removeClass('selected');
		$(this).addClass('selected');
		$(this).find('.toolbarPanelButtonText').addClass('selected');
		switch($(this).attr('id')) {
			case 'basemap_hybrid': 
				map.setBasemap('hybrid');
				break;
			case 'basemap_satellite': 
				map.setBasemap('satellite');
				break;
			case 'basemap_street': 
				map.setBasemap('streets');
				break;
			case 'basemap_osm': 
				map.setBasemap('osm');
				break;
			case 'basemap_topo': 
				map.setBasemap('topo');
				break;
			case 'basemap_darkcanvas': 
				map.setBasemap('dark-gray');
				break;
			case 'basemap_lightcanvas': 
				map.setBasemap('gray');
				break;
			case 'basemap_natgeo': 
				map.setBasemap('national-geographic');
				break;
			case 'basemap_oceans': 
				map.setBasemap('oceans');
				break;
			case 'basemap_terrain': 
				map.setBasemap('terrain');
				break;
		}
	});
}

$(window).ready(setListenersBasemap);

