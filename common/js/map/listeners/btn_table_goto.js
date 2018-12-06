/* global Ext, ol, map, geometry, geometries */



setListenerBtnTableGotoPotensiPjax = function() {
	setTimeout(function(){
		$('.gotoPotensiButton').click(function(){
			zoomtoPointPotensi($(this).attr('id')*1);
		});
	},1000);
}

setListenerBtnTableGotoWkpPjax = function() {
	setTimeout(function(){
		$('.gotoWkpButton').click(function(){
			zoomtoPointWkp($(this).attr('id')*1);
		});
	},1000);
}

setListenerBtnTableGotoWpspPjax = function() {
	setTimeout(function(){
		$('.gotoWpspButton').click(function(){
			zoomtoPointWpsp($(this).attr('id')*1);
		});
	},1000);
}

setListenerBtnTableGotoWpspePjax = function() {
	setTimeout(function(){
		$('.gotoWpspeButton').click(function(){
			zoomtoPointWpspe($(this).attr('id')*1);
		});
	},1000);
}

setListenerBtnTableGotoPltpPjax = function() {
	setTimeout(function(){
		$('.gotoPltpButton').click(function(){
			zoomtoPointPltp($(this).attr('id')*1);
			console.log($(this).attr('id')*1);
		});
	},1000);
}

setListenerBtnTableGotoPencarianPjax = function() {
	setTimeout(function(){
		$('.gotoPencarianButton').click(function(){
			switch ($(this).attr('source')) {
				case 'POTENSI':
					zoomtoPointPotensi($(this).attr('nama'));
					break;
				case 'WKP':
					zoomtoPointWkp($(this).attr('nama'));
					break;
				case 'WPSP':
					zoomtoPointWpsp($(this).attr('nama'));
					break;
				case 'WPSPE':
					zoomtoPointWpspe($(this).attr('nama'));
					break;
			}
			
		});
	},1000);
}

$(document).on('ready pjax:success', setListenerBtnTableGotoPotensiPjax);
$(document).on('ready pjax:success', setListenerBtnTableGotoWkpPjax);
$(document).on('ready pjax:success', setListenerBtnTableGotoWpspPjax);
$(document).on('ready pjax:success', setListenerBtnTableGotoWpspePjax);
$(document).on('ready pjax:success', setListenerBtnTableGotoPltpPjax);
$(document).on('ready pjax:success', setListenerBtnTableGotoPencarianPjax);

