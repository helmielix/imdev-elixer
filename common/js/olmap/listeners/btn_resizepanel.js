panelState = 1;

function refreshMap() {
	if (selectedBasemap != 'basemapGoogleSatellite') {
		setActiveBasemap('basemapGoogleSatellite');setActiveBasemap(selectedBasemap);
	} else {
		setActiveBasemap('basemapGoogleTerrain');setActiveBasemap(selectedBasemap);
	}
	map.updateSize();
}

setListenersBtnReizePanel = function() {
	$('.panelZoomButton.down').click(function(){
		if(panelState == 1) {
			panelState = 2;
			$(this).hide(0);
			$('#southPanelGrid').animate({height:'0'},400);
			$('#southPanel').animate({height:'30'},400);
			$('#map').animate({height:'+=270'},400,function(){setTimeout(function(){refreshMap()},400)});
			
		} else if(panelState == 3) {
			panelState = 1;
			var viewportHeight = $(window).height();
			var adjustTop = $('.navbar-static-top').height();
			$('.panelZoomButton.up').show(0);
			$('#southPanelGrid').animate({height:'270'},400);
			$('#southPanel').animate({height:'300'},400);
			$('#map').animate({height:viewportHeight-adjustTop-300},400,function(){setTimeout(function(){refreshMap()},400)});
			$('#mapToolbar').show(0);
			
		}
		
	});
	
	$('.panelZoomButton.up').click(function(){
		if(panelState == 2) {
			panelState = 1;
			$('.panelZoomButton.down').show(0);
			$('#southPanelGrid').animate({height:'270'},400);
			$('#southPanel').animate({height:'300'},400);
			$('#map').animate({height:'-=270'},400,function(){setTimeout(function(){refreshMap()},400)});
		} else if(panelState == 1) {
			panelState = 3;
			$(this).hide(0);
			var viewportHeight = $(window).height();
			var adjustTop = $('.navbar-static-top').height();
			$('#southPanelGrid').animate({height:viewportHeight-adjustTop-30},400);
			$('#southPanel').animate({height:viewportHeight-adjustTop},400);
			$('#map').animate({height:'0'},400,function(){setTimeout(function(){refreshMap()},400)});
			$('#mapToolbar').hide(0);
		}
		
	});
};



$(window).ready(setListenersBtnReizePanel);
