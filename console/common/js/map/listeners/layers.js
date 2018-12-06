// Create Function for add Listener to Layers Button
setListenersLayer = function() {
	$(".layerButton").click(function() {
		if($(this).hasClass('selected')) {
			if ($(this).attr('id') == ('layer_bangunan') ||$(this).attr('id') == ('layer_odc') || $(this).attr('id') == ('layer_odp') 
				|| $(this).attr('id') == ('layer_jalurdistribusi') || $(this).attr('id') == ('layer_boundary') || $(this).attr('id') == ('layer_tianginfokom')
				|| $(this).attr('id') == ('layer_tiangpln') || $(this).attr('id') == ('layer_jalan') || $(this).attr('id') == ('layer_batasrw')) {
				var index;
				var index2;
				var maplayer = map.getLayer('main');
				array = maplayer.visibleLayers;
				switch ($(this).attr('id')) {
					case 'layer_odc':
						index = array.indexOf(0);
						$('.layer_odc').addClass('hidden');
						break;
					case 'layer_odp':
						index = array.indexOf(1);
						$('.layer_odp').addClass('hidden');
						break;
					case 'layer_tiangpln':
						index = array.indexOf(2);
						$('.layer_tiangpln').addClass('hidden');
						break;
					case 'layer_tianginfokom':
						index = array.indexOf(3);
						$('.layer_tianginfokom').addClass('hidden');
						break;
					case 'layer_jalurdistribusi':
						index = array.indexOf(4);
						$('.layer_jalurdistribusi').addClass('hidden');
						break;
					case 'layer_boundary':
						index = array.indexOf(5);
						$('.layer_boundary').addClass('hidden');
						break;
					case 'layer_bangunan':
						index = array.indexOf(6);
						$('.layer_bangunan').addClass('hidden');
						break;
					case 'layer_jalan':
						index = array.indexOf(7);
						$('.layer_jalan').addClass('hidden');
						break;
					case 'layer_batasrw':
						index = array.indexOf(8);
						$('.layer_batasrw').addClass('hidden');
						break;
				}
				if (index > -1) {
					array.splice(index, 1);
				}
				
				maplayer.setVisibleLayers(array);
			} else {
				switch ($(this).attr('id')) {
					case 'layer_adminkemdagri':
						map.getLayer('adminkemdagri').setVisibility(false);
						break;
				}
			}
			$(this).removeClass('selected');
			$(this).find('.toolbarPanelButtonText').removeClass('selected');
		} else {
			
			if ($(this).attr('id') == ('layer_bangunan') ||$(this).attr('id') == ('layer_odc') || $(this).attr('id') == ('layer_odp') 
				|| $(this).attr('id') == ('layer_jalurdistribusi') || $(this).attr('id') == ('layer_boundary') || $(this).attr('id') == ('layer_tianginfokom')
				|| $(this).attr('id') == ('layer_tiangpln') || $(this).attr('id') == ('layer_jalan') || $(this).attr('id') == ('layer_batasrw')) {
				var index;
				var maplayer = map.getLayer('main');
				array = maplayer.visibleLayers;
				switch ($(this).attr('id')) {
					case 'layer_odc':
						index = 0;
						$('.layer_odc').removeClass('hidden');
						break;
					case 'layer_odp':
						index = 1;
						$('.layer_odp').removeClass('hidden');
						break;	
					case 'layer_tiangpln':
						index = 2;
						$('.layer_tiangpln').removeClass('hidden');
						break;
					case 'layer_tianginfokom':
						index = 3;
						$('.layer_tianginfokom').removeClass('hidden');
						break;
					case 'layer_jalurdistribusi':
						index = 4;
						$('.layer_jalurdistribusi').removeClass('hidden');
						break;
					case 'layer_boundary':
						index = 5;
						$('.layer_boundary').removeClass('hidden');
						break;
					case 'layer_bangunan':
						index = 6;
						$('.layer_bangunan').removeClass('hidden');
						break;
					case 'layer_jalan':
						index = 7;
						$('.layer_jalan').removeClass('hidden');
						break;
					case 'layer_batasrw':
						index = 8;
						$('.layer_batasrw').removeClass('hidden');
						break;
				}
				array.push(index);
				if (index2 != -1) array.push(index2);
				maplayer.setVisibleLayers(array);
			} else {
				switch ($(this).attr('id')) {
					case 'layer_adminkemdagri':
						map.getLayer('adminkemdagri').setVisibility(true);
						break;
				}
			}
			$(this).addClass('selected');
			$(this).find('.toolbarPanelButtonText').addClass('selected');
			
		}
		
	});
}

$(window).ready(setListenersLayer);

