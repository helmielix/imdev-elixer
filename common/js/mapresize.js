panelState = 1;

setViewport = function () {
	var viewportHeight = $(window).height();
	var viewportWidth = $(window).width();
	var adjustTop = $('.navbar-static-top').height();
	var adjustLeft = $('.sidebar').width();
	var southPanelHeaderHeight = 30;
	if (panelState == 1) {
		southPanelHeight = 300;
	} else if (panelState == 2) {
		southPanelHeight = 30;
	} else if (panelState == 3) {
		southPanelHeight = viewportHeight - adjustTop;
	} else {
		southPanelHeight = 300;
	}
	$('#southPanel').height(southPanelHeight);
	$('#southPanelGrid').height(southPanelHeight-southPanelHeaderHeight);
	$('#map').height(viewportHeight - adjustTop - southPanelHeight);
	$('#mapToolbar').width(viewportWidth-adjustLeft);
}
$(window).ready(setViewport);
$(window).resize(setViewport);