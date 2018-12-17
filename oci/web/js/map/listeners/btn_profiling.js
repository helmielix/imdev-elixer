function setListeners_btn_profiling() {
	var drawProfiling;
	var geomProfiling = [];
	var	storeProfilingLoaded = false;
	var	storeLayerHasilGaliLoaded = false;
    var urlKonturProfiling = '/geoserver/wfs?service=wfs&' +
            'version=1.1.0&request=GetFeature&typeName=siopl:kontur3d&' +            
            'propertyName=x_real,y_real,tlr&format_options=callback:loadFeatures&' +
            'outputFormat=application/json&exceptions=application/json&srsName=EPSG:4326&';
			
	var urlLayerHasilGali = '/geoserver/wfs?service=wfs&' +
            'version=1.1.0&request=GetFeature&typeName=siopl:layer_hasil_gali&' +            
            'propertyName=es_x,es_y,tlr&format_options=callback:loadFeatures&' +
            'outputFormat=application/json&exceptions=application/json&srsName=EPSG:32748&';

    var storeProfiling = new Ext.data.JsonStore({
        remoteSort: false,
        autoLoad: false,
        proxy: {
            type: 'ajax',
            url: 'http://' + window.location.hostname + ':8084' + urlKonturProfiling,
            reader: {
                type: 'json',
                root: 'features',
                idProperty: 'properties.id'
            },
            simpleSortMode: true
        },
        fields: [
            {name: 'properties.id'},
            {name: 'properties.x_real'},
            {name: 'properties.y_real'},
            {name: 'properties.tlr'}
        ]

    });
	
	var storeLayerHasilGali = new Ext.data.JsonStore({
        remoteSort: false,
        autoLoad: false,
        proxy: {
            type: 'ajax',
            url: 'http://' + window.location.hostname + ':8084' + urlLayerHasilGali,
            reader: {
                type: 'json',
                root: 'features',
                idProperty: 'properties.gid'
            },
            simpleSortMode: true
        },
        fields: [
            {name: 'properties.gid'},
            {name: 'properties.es_x'},
            {name: 'properties.es_y'},
            {name: 'properties.tlr'}
        ]

    });

    storeProfiling.on('load', function () {
		storeProfilingLoaded = true;
		profilingWindow.show();
		if(storeLayerHasilGaliLoaded) {
			constructProfiling(storeProfiling,storeLayerHasilGali,geomProfiling);
		}
    });
	
	storeLayerHasilGali.on('load', function () {
		storeLayerHasilGaliLoaded = true;
		profilingWindow.show();
		if(storeProfilingLoaded) {
			constructProfiling(storeProfiling,storeLayerHasilGali,geomProfiling);
		}
    });
	
	var profilingPanel = Ext.create('Ext.panel.Panel', {
		layout: 'fit',
        id: 'profilingPanel'
	})
									
	profilingWindow = new Ext.Window({
						layout: 'fit',
						id: 'profilingWindow',
						width: 600,
						height: 400,
						// maximizable: true,
						closeAction: 'hide',
						title: "Landscape Profile",
						items: [profilingPanel]
					});

    Ext.getCmp("btn_profiling").on("toggle", function () {
		if (this.pressed) {
			// draw line
			var sourceProfiling = new ol.source.Vector();
			drawProfiling = new ol.interaction.Draw({
				source: sourceProfiling,
				maxPoints: 2,
				type: 'LineString',
				style: new ol.style.Style({
					fill: new ol.style.Fill({
						color: 'rgba(255, 255, 255, 0.2)'
					}),
					stroke: new ol.style.Stroke({
						color: 'rgba(0, 0, 0, 0.5)',
						lineDash: [10, 10],
						width: 2
					}),
					image: new ol.style.Circle({
						radius: 5,
						stroke: new ol.style.Stroke({
							color: 'rgba(0, 0, 0, 0.7)'
						}),
						fill: new ol.style.Fill({
							color: 'rgba(255, 255, 255, 0.2)'
						})
					})
				})
			});
			
			map.addInteraction(drawProfiling);
			// get coordinates on polygon
			sourceProfiling.on('addfeature', function (evt) {
				var	storeProfilingLoaded = false;
				var	storeLayerHasilGaliLoaded = false;
				var feature = evt.feature;
				var geometry = feature.getGeometry().getCoordinates();
				var pointStart = ol.proj.transform(geometry[0], 'EPSG:900913', 'EPSG:32748');
				var pointEnd = ol.proj.transform(geometry[1], 'EPSG:900913', 'EPSG:32748');
				
				if (pointStart[0] < pointEnd[0]) {
					pointStart[0] = pointStart[0] - 2.5;
					pointEnd[0] = pointEnd[0] + 2.5;
				} else {
					pointStart[0] = pointStart[0] + 2.5;
					pointEnd[0] = pointEnd[0] - 2.5;
				}
				if (pointStart[1] < pointEnd[1]) {
					pointStart[1] = pointStart[1] - 2.5;
					pointEnd[1] = pointEnd[1] + 2.5;
				} else {
					pointStart[1] = pointStart[1] + 2.5;
					pointEnd[1] = pointEnd[1] - 2.5;
				}
				
				bbox =  pointStart[0] + " " + pointStart[1] + "," + 
						pointStart[0] + " " + pointEnd[1] + "," + 
						pointEnd[0] + " " + pointEnd[1] + "," + 
						pointEnd[0] + " " + pointStart[1] + "," + 
						pointStart[0] + " " + pointStart[1] 

				
				var cqlFilter = 'INTERSECTS(geom, POLYGON((' + bbox + ')))';
				storeProfiling.getProxy().extraParams.cql_filter = cqlFilter;
				storeProfiling.load();
				storeLayerHasilGali.getProxy().extraParams.cql_filter = cqlFilter;
				storeLayerHasilGali.load();
				geomProfiling = [pointStart,pointEnd];
			});
		} else {
			if (!Ext.getCmp("btn_profiling").pressed) {
            map.removeInteraction(drawProfiling);
        	};
		};
    });
	
	
}
;