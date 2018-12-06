//declare global variables
var basemapGoogleStreet;
var basemapGoogleHybrid;
var basemapGoogleSatellite;
var basemapGoogleTerrain;
var btnListener;
var sourceMeasurement;
var drawMeasurementline;
var drawMeasurementarea;
var addPointerMoveListener;
var source_potentialca;
var setActiveBasemap;
var overlay;

function resetInteraction() {
	map.unByKey(btnListener);
	sourceMeasurement.clear();
	map.removeInteraction(drawMeasurementline);
	map.removeInteraction(drawMeasurementarea);
	map.getOverlays().clear();
	map.unByKey(addPointerMoveListener);
	//document.removeEventListener('keydown', measurelineFunction);
	//document.removeEventListener('keydown', measureareaFunction);
	//document.removeEventListener('keydown', drawpolygonFunction);
}
	  
initMap = function () {
	
	// set Center of Jakarta
	var center = [12973503, -78271];
	// Declare Google Layers
	basemapGoogleStreet = new olgm.layer.Google();
	basemapGoogleSatellite = new olgm.layer.Google({mapTypeId: google.maps.MapTypeId.SATELLITE});
	basemapGoogleHybrid = new olgm.layer.Google({mapTypeId: google.maps.MapTypeId.HYBRID});
	basemapGoogleTerrain = new olgm.layer.Google({mapTypeId: google.maps.MapTypeId.TERRAIN});
	
	mapUrl = 'http://10.9.39.43:8080' + '/geoserver/foro/wms';
	
	
	
	// Declare layer_ca_boundary
	source_caboundary = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:status_area'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_caboundary = new ol.layer.Image({
        source: source_caboundary
    });
	
	// Declare layer_area_redline
	source_area_redline = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:area_redline'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_area_redline = new ol.layer.Image({
        source: source_area_redline
    });
	
	// Declare layer_corporate_boundary
	source_corporate_boundary = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:corporate_boundary'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_corporate_boundary = new ol.layer.Image({
        source: source_corporate_boundary
    });
	
	// Declare layer_homepass_plan
	source_homepass_plan = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:homepass'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_homepass_plan = new ol.layer.Image({
        source: source_homepass_plan,
    });
	
	// Declare layer_homepass_built
	source_homepass_built = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:homepass_built'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_homepass_built = new ol.layer.Image({
        source: source_homepass_built,
    });
	
	// Declare layer_jalan
	source_jalan = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:jalan'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_jalan = new ol.layer.Image({
        source: source_jalan,
    });
	
	// Declare layer_jalur_backbone_plan
	source_jalur_backbone_plan = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:jalur_backbone_plan'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_jalur_backbone_plan = new ol.layer.Image({
        source: source_jalur_backbone_plan,
    });
	
	// Declare layer_jalur_backbone_built
	source_jalur_backbone_built = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:jalur_backbone_built'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_jalur_backbone_built = new ol.layer.Image({
        source: source_jalur_backbone_built,
    });
	
	// Declare layer_olt_plan
	source_olt_plan = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:olt_plan'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_olt_plan = new ol.layer.Image({
        source: source_olt_plan,
    });
	
	// Declare layer_olt_plan
	source_olt_built = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:olt_built'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_olt_built = new ol.layer.Image({
        source: source_olt_built,
    });
	
	// Declare layer_odc_plan
	source_odc_plan = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:odc_plan'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_odc_plan = new ol.layer.Image({
        source: source_odc_plan,
    });
	
	// Declare layer_odc_plan
	source_odc_built = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:odc_built'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_odc_built = new ol.layer.Image({
        source: source_odc_built,
    });
	
	
	// Declare layer_odp_plan
	source_odp_plan = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:odp_plan'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_odp_plan = new ol.layer.Image({
        source: source_odp_plan,
    });
	
	// Declare layer_odp_plan
	source_odp_built = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:odp_built'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_odp_built = new ol.layer.Image({
        source: source_odp_built,
    });
	
	
	// Declare layer_pole_plan
	source_pole_plan = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:pole_plan'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_pole_plan = new ol.layer.Image({
        source: source_pole_plan,
    });
	
	// Declare layer_pole_plan
	source_pole_history = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:pole_history'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_pole_history = new ol.layer.Image({
        source: source_pole_history,
    });
	
	// Declare layer_pole_plan
	source_pole_built = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:pole_built'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_pole_built = new ol.layer.Image({
        source: source_pole_built,
    });
	
	
	// Declare layer_jalur_feeder_plan
	source_jalur_feeder_plan = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:jalur_feeder_plan'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_jalur_feeder_plan = new ol.layer.Image({
        source: source_jalur_feeder_plan,
    });
	
	// Declare layer_jalur_feeder_plan
	source_jalur_feeder_built = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:jalur_feeder_built'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_jalur_feeder_built = new ol.layer.Image({
        source: source_jalur_feeder_built,
    });
	
	
	// Declare layer_pole_plan
	source_pole_plan = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:pole_plan'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_pole_plan = new ol.layer.Image({
        source: source_pole_plan,
    });
	
	// Declare layer_pole_plan
	source_pole_built = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:pole_built'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_pole_built = new ol.layer.Image({
        source: source_pole_built,
    });
	
	
	// Declare layer_closure_plan
	source_closure_plan = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:closure_plan'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_closure_plan = new ol.layer.Image({
        source: source_closure_plan,
    });
	
	// Declare layer_closure_plan
	source_closure_built = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:closure_built'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_closure_built = new ol.layer.Image({
        source: source_closure_built,
    });
	
	
	// Declare layer_slack_support_plan
	source_slack_support_plan = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:slack_support_plan'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_slack_support_plan = new ol.layer.Image({
        source: source_slack_support_plan,
    });
	
	// Declare layer_slack_support_plan
	source_slack_support_built = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:slack_support_built'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_slack_support_built = new ol.layer.Image({
        source: source_slack_support_built,
    });
	
	
	// Declare layer_hand_hole_plan
	source_hand_hole_plan = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:hand_hole_plan'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_hand_hole_plan = new ol.layer.Image({
        source: source_hand_hole_plan,
    });
	
	// Declare layer_hand_hole_plan
	source_hand_hole_built = new ol.source.ImageWMS({
		url: mapUrl,
		params: {
			'LAYERS': [
				'foro:hand_hole_built'
			]
		},
		serverType: 'geoserver',
		projection: ol.proj.get("EPSG:4326")
	})
	layer_hand_hole_built = new ol.layer.Image({
        source: source_hand_hole_built,
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
	
	
	
	sourceMeasurement = new ol.source.Vector();

	var vectorMeasurement = new ol.layer.Vector({
        source: sourceMeasurement,
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
			layer_area_redline,
			layer_caboundary,
			//layer_corporate_boundary,
			layer_homepass_plan,
			layer_homepass_built,
			layer_jalan,
			layer_jalur_backbone_plan,
			layer_jalur_backbone_built,
			layer_olt_plan,
			layer_olt_built,
			layer_odc_plan,
			layer_odc_built,
			layer_odp_plan,
			layer_odp_built,
			layer_pole_plan,
			//layer_pole_built,
			layer_pole_history,
			layer_jalur_feeder_plan,
			layer_jalur_feeder_built,
			layer_closure_plan,
			layer_closure_built,
			layer_slack_support_plan,
			layer_slack_support_built,
			layer_hand_hole_plan,
			layer_hand_hole_built,
			vectorMeasurement
		],
		target: 'map',
		view: new ol.View({
			center: center,
			zoom: 5,
			maxZoom: 19
		}),
	});

	basemapGoogleSatellite.setVisible(false);
	basemapGoogleHybrid.setVisible(false);
	basemapGoogleTerrain.setVisible(false);
	layer_jalur_backbone_plan.setVisible(false);
	layer_olt_plan.setVisible(false);
	layer_odc_plan.setVisible(false);
	layer_odp_plan.setVisible(false);
	layer_pole_plan.setVisible(false);
	layer_jalur_feeder_plan.setVisible(false);
	layer_closure_plan.setVisible(false);
	layer_slack_support_plan.setVisible(false);
	layer_hand_hole_plan.setVisible(false);
	
	
	olGM = new olgm.OLGoogleMaps({
		map: map
	}); // map is the ol.Map instance
	olGM.activate();
	
	var draw; // global so we can remove it later
    
	setTimeout(function() {
		
		map.updateSize();
	},400);
	
}

$(document).ready(initMap);