//declare global variables
var basemapGoogleStreet;
var basemapGoogleHybrid;
var basemapGoogleSatellite;
var basemapGoogleTerrain;
	  
initMap = function () {
	// set Center of Jakarta
	var center = [11894377, -692885];
	// Declare Google Layers
	basemapGoogleStreet = new olgm.layer.Google();
	basemapGoogleSatellite = new olgm.layer.Google({mapTypeId: google.maps.MapTypeId.SATELLITE});
	basemapGoogleHybrid = new olgm.layer.Google({mapTypeId: google.maps.MapTypeId.HYBRID});
	basemapGoogleTerrain = new olgm.layer.Google({mapTypeId: google.maps.MapTypeId.TERRAIN});
	
	// Declare Layer Potensial CA
	layer_potentialca = new ol.layer.Image({
        source: new ol.source.ImageWMS({
            url: 'http://' + window.location.hostname + ':8010' + '/geoserver/mnc/wms',
            params: {
                'LAYERS': [
                    'mnc:survey_polygon_status_ca'
                ]
            },
            serverType: 'geoserver',
			projection: ol.proj.get("EPSG:4326")
        })
    });
	
	// Declare Layer Potensial CA By Modul
	layer_potentialca_modul = new ol.layer.Image({
        source: new ol.source.ImageWMS({
            url: 'http://' + window.location.hostname + ':8010' + '/geoserver/mnc/wms',
            params: {
                'LAYERS': [
                    'mnc:survey_polygon_status_modul'
                ]
            },
            serverType: 'geoserver',
			projection: ol.proj.get("EPSG:4326")
        })
    });
	
	// Declare Layer Backbone
	layer_backbone = new ol.layer.Image({
        source: new ol.source.ImageWMS({
            url: 'http://' + window.location.hostname + ':8010' + '/geoserver/mnc/wms',
            params: {
                'LAYERS': [
                    'mnc:backbone_line'
                ]
            },
            serverType: 'geoserver'
        })
    });
	
	source = new ol.source.Vector({wrapX: false});

	drawVector = new ol.layer.Vector({
		source: source
	});
	
	modifyVector = new ol.layer.Vector({
		source: source,
		style: new ol.style.Style({
			fill: new ol.style.Fill({
				color: 'rgba(255, 255, 255, 0.2)'
			}),
			stroke: new ol.style.Stroke({
				color: '#ffcc33',
				width: 2
			}),
			image: new ol.style.Circle({
				radius: 7,
				fill: new ol.style.Fill({
					color: '#ffcc33'
				})
			})
		})
	});
	
	map = new ol.Map({
		// use OL3-Google-Maps recommended default interactions
		interactions: olgm.interaction.defaults(),
		layers: [
			basemapGoogleStreet,
			basemapGoogleHybrid,
			basemapGoogleSatellite,
			basemapGoogleTerrain,
			layer_potentialca_modul,
			layer_potentialca,
			layer_backbone
		],
		target: 'map',
		view: new ol.View({
			center: center,
			zoom: 9
		}),
	});

	basemapGoogleSatellite.setVisible(false);
	basemapGoogleHybrid.setVisible(false);
	basemapGoogleTerrain.setVisible(false);
	layer_potentialca_modul.setVisible(false);
	
	
	var olGM = new olgm.OLGoogleMaps({
		map: map
	}); // map is the ol.Map instance
	olGM.activate();
	
	
	  
	var draw; // global so we can remove it later
    
	
		
}

$(window).ready(initMap);