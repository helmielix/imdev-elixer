setViewport = function () {
	var viewportHeight = $(window).height();
	var viewportWidth = $(window).width();
	var adjustTop = $('.navbar-static-top').height();
	var adjustLeft = $('.sidebar').width();
	var southPanelHeaderHeight = 30;
	var southPanelHeight = 50;
	
	$('#southPanel').height(southPanelHeight);
	$('#southPanelGrid').height(southPanelHeight-southPanelHeaderHeight);
	$('#map').height(viewportHeight - adjustTop - southPanelHeight);
	// $('#map').height(viewportHeight - adjustTop - 100);
	$('#mapToolbar').width(viewportWidth-adjustLeft);
}
$(window).ready(setViewport);
$(window).resize(setViewport);