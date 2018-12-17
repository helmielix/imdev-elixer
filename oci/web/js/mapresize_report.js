setViewport = function () {
	
	var viewportHeight = $(window).height();
	var viewportWidth = $(window).width();
	var adjustTop = $('.navbar-static-top').height();
	var adjustLeft = $('.sidebar').width();
	var southPanelHeaderHeight = 30;
	var fullPanelWidth = (viewportWidth - adjustLeft);
	var halfPanelWidth = (viewportWidth - adjustLeft) / 2;
	var thirdPanelWidth = (viewportWidth - adjustLeft) / 3;
	var contentPadding = 15
	var contentHeader = $('.content-header').height();
	var panelHeader = 30;
	var mapToolbarHeight = $('#mapToolbar').height();
	
	/*
	$('#eastNorthPanel').width(eastPanelWidth - (contentPadding*2)-40);
	$('#eastNorthPanel').height((viewportHeight - adjustTop - (contentPadding*3) - contentHeader)/2);
	$('#eastSouthPanel').width(eastPanelWidth - (contentPadding*2)-40);
	$('#eastSouthPanel').height((viewportHeight - adjustTop - (contentPadding*3) - contentHeader)/2);
	
	$('#mapContainer').height(viewportHeight - adjustTop - (contentPadding*2) - contentHeader);
	$('#mapContainer').width(viewportWidth - adjustLeft - eastPanelWidth - contentPadding);
	$('#map').height($('#mapContainer').height() -  panelHeader - mapToolbarHeight);
	$('#map').width($('#mapContainer').width());
	$('#mapToolbar').width(viewportWidth - adjustLeft - eastPanelWidth - contentPadding);
	*/
	
	$('#firstRowRightPanel').width(thirdPanelWidth - (contentPadding)-40);
	$('#firstRowRightPanel').height(400);
	$('#secondRowLeftPanel').width(thirdPanelWidth - (contentPadding));
	$('#secondRowLeftPanel').height(400);
	$('#secondRowRightPanel').width((thirdPanelWidth - (contentPadding*2))*2);
	$('#secondRowRightPanel').height(400);
	$('#thirdRowFullPanel').width(fullPanelWidth - (contentPadding*3));
	$('#thirdRowFullPanel').height(400);
	
	$('#mapContainer').height(400);
	$('#mapContainer').width(viewportWidth - adjustLeft - thirdPanelWidth - contentPadding);
	$('#map').height($('#mapContainer').height() -  panelHeader - mapToolbarHeight);
	$('#map').width($('#mapContainer').width());
	$('#mapToolbar').width(viewportWidth - adjustLeft - thirdPanelWidth - contentPadding);
}
$(window).ready(setViewport);
//$(window).resize(setViewport);