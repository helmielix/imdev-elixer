/* global Ext, ol, map, geometry, geometries, cesiumWindow, cesiumViewer */
var dragBox3d;

function setListeners_btn_3d() {
	var minx = 1000000;
	var maxx = 0;
	var miny = 1000000;
	var maxy = 0;
	var records3d = [];
	var recordsLayerHasilGali = [];
	var store3dLoaded = false;
	var storeLayerHasilGaliLoaded = false;
    var urlKontur3D = '/geoserver/wfs?service=wfs&' +
            'version=1.1.0&request=GetFeature&typeName=siopl:kontur3d&' +
            'propertyName=x_real,y_real,tlr&format_options=callback:loadFeatures&' +
            'outputFormat=application/json&exceptions=application/json&srsName=EPSG:32748&';

    store3d = new Ext.data.JsonStore({
        remoteSort: false,
        autoLoad: false,
        proxy: {
            type: 'ajax',
            url: 'http://' + window.location.hostname + ':8084' + urlKontur3D,
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
	
	 var urlLayerHasilGali = '/geoserver/wfs?service=wfs&' +
            'version=1.1.0&request=GetFeature&typeName=siopl:layer_hasil_gali&' +
            'propertyName=es_x,es_y,tlr&format_options=callback:loadFeatures&' +
            'outputFormat=application/json&exceptions=application/json&srsName=EPSG:32748&';

    storeLayerHasilGali = new Ext.data.JsonStore({
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

	function prepareRecords() {
		var records = [];
		for (i=0;i<maxy-miny;i++) {
			for (j=0;j<maxx-minx;j++) {
				var tlr = records3d[minx+j][miny+i];
				if (recordsLayerHasilGali[minx+j] !== undefined) {
					if (recordsLayerHasilGali[minx+j][miny+i] !== undefined) {
						if (recordsLayerHasilGali[minx+j][miny+i] < records3d[minx+j][miny+i]) {
							tlr = recordsLayerHasilGali[minx+j][miny+i];
						} 
					}
				}
				records.push(tlr);
			}
		}
		construct3dMap(records,maxx-minx,maxy-miny);
	}
	
    store3d.on('load', function () {
		store3dLoaded = true;
        records3d = [];
        store3d.each(function (record)
        {
			var x = Math.floor((record.data["properties.x_real"] - 500000) / 2.5);
			var y = -Math.floor((record.data["properties.y_real"] - 9840000) / 2.5);
			if (minx > x ) minx = x;
			if (maxx < x ) maxx = x;
			if (miny > y ) miny = y;
			if (maxy < y ) maxy = y;
			var tlr = record.data['properties.tlr'];
			if (records3d[x] === undefined) records3d[x] = [];
			records3d[x][y] = tlr;
        }, this);
		if (store3dLoaded && storeLayerHasilGaliLoaded) {
			records = prepareRecords();
			//construct3dMap(records3d);
			store3dLoaded = false;
			storeLayerHasilGaliLoaded = false;
		}
    });
	
	storeLayerHasilGali.on('load', function () {
		
		storeLayerHasilGaliLoaded = true;
        recordsLayerHasilGali = [];
        storeLayerHasilGali.each(function (record)
        {
			var x = record.data['properties.es_x'];
			var y = record.data['properties.es_y'];
			var tlr = record.data['properties.tlr'];
			if (recordsLayerHasilGali[x] === undefined) recordsLayerHasilGali[x] = [];
			recordsLayerHasilGali[x][y] = -tlr;
        }, this)
        if (store3dLoaded && storeLayerHasilGaliLoaded) {
			records = prepareRecords();
			//construct3dMap(records3d);
			store3dLoaded = false;
			storeLayerHasilGaliLoaded = false;
		}
    });

    function drawstart(evt) {
        // set sketch
        sketch = evt.feature;
        /** @type {ol.Coordinate|undefined} */
        var tooltipCoord = evt.coordinate;
        listener = sketch.getGeometry().on('change', function (evt) {
            var geom = evt.target;
            var output;
            if (geom instanceof ol.geom.Polygon) {
                output = formatArea(/** @type {ol.geom.Polygon} */ (geom));
                tooltipCoord = geom.getInteriorPoint().getCoordinates();
            } else if (geom instanceof ol.geom.LineString) {
                output = formatLength(/** @type {ol.geom.LineString} */ (geom));
                tooltipCoord = geom.getLastCoordinate();
            }
        });
    }

    Ext.getCmp("btn_3d").on("toggle", function () {

         if (this.pressed) {

        // Select area by polygon
        var source = new ol.source.Vector();
        // get coordinates on polygon
        source.on('addfeature', function (evt) {
            var feature = evt.feature;
            var geometry = feature.getGeometry().getCoordinates();
			var geometry = ol.proj.transform(geometry, 'EPSG:900913', 'EPSG:32748');
			records3d = [];
			recordsLayerHasilGali = [];
			records = [];
			store3dLoaded = false;
			storeLayerHasilGaliLoaded = false;
			minx = 1000000;
			maxx = 0;
			miny = 1000000;
			maxy = 0;
            // looping to get each coordinate
          
            var bbox = []; // An array for CQL Filter in Intersects Query
			var vertices = [];
			vertices[0] = geometry[0] - 375; 
			vertices[1] = geometry[1] - 375;
			bbox.push(vertices.join().replace(",", " "));
			vertices[0] = geometry[0] - 375; 
			vertices[1] = geometry[1] + 375;
			bbox.push(vertices.join().replace(",", " "));
			vertices[0] = geometry[0] + 375; 
			vertices[1] = geometry[1] + 375;
			bbox.push(vertices.join().replace(",", " "));
			vertices[0] = geometry[0] + 375; 
			vertices[1] = geometry[1] - 375;
			bbox.push(vertices.join().replace(",", " "));
			vertices[0] = geometry[0] - 375; 
			vertices[1] = geometry[1] - 375;
			bbox.push(vertices.join().replace(",", " "));
            var cqlFilter = 'INTERSECTS(geom, POLYGON((' + bbox + ')))';
            store3d.getProxy().extraParams.cql_filter = cqlFilter;
            store3d.load();
			//storeLayerHasilGali.getProxy().extraParams.cql_filter = cqlFilter;
            storeLayerHasilGali.load();
            map.removeInteraction(draw);
			cesiumWindow.show();
        });
        function addInteraction(type) {
            draw = new ol.interaction.Draw({
                source: source,
                type: /** @type {ol.geom.GeometryType} */ (type),
                style: new ol.style.Style({
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
        }
        ;

        function drawend() {
            // unset sketch
            sketch = null;
            ol.interaction.defaults({
                doubleClickZoom: false
            });

            ol.Observable.unByKey(listener);
            map.removeInteraction(draw);
        }
        addInteraction('Point');
        map.addInteraction(draw);
        draw.on('drawstart', function (evt) {
            drawstart(evt);
        }, this);
        draw.on('drawend', function (e) {
            Ext.getCmp("btn_3d").toggle(false, true);
            drawend;
        }, this);

        }

        else {
            if (!Ext.getCmp("btn_3d").pressed) {
                map.removeInteraction(draw);
            };
        };

    });

}
;