panelState = 1;

setViewport = function () {
	setTimeout(function(){
		$('#mapToolbar').width($('#map').width());
	},100);
}
$(window).ready(setViewport);
$(window).resize(setViewport);