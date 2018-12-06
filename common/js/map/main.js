var map;
var printTask;
var params;
var drawTool;
var mapIdentifyListener;
var executeIdentifyTask;
var hasMapIdentifyListener = true;
var zoomtoCoordinates;

function showModalODP(id) {
	$('#modalFlipbook').modal('show')
		.find('#modalFlipbookContent')
		.load('/foro/osp/web/index.php?r=odp/view_modal&id='+id);
	$('#modalFlipbookHeader').html('<h3> Detail ODP </h3>');
}

function showModalODC(id) {
	$('#modalFlipbook').modal('show')
		.find('#modalFlipbookContent')
		.load('/foro/osp/web/index.php?r=odc/view_modal&id='+id);
	$('#modalFlipbookHeader').html('<h3> Detail ODC </h3>');
}

function showModalPelanggan(id) {
	$('#modalFlipbook').modal('show')
		.find('#modalFlipbookContent')
		.load('/foro/osp/web/index.php?r=subscriber/view_modal&id='+id);
	$('#modalFlipbookHeader').html('<h3> Detail Pelanggan </h3>');
}

$(document).ready(function() {
    require([
        "esri/map",
		"esri/tasks/PrintTask",
		"esri/tasks/PrintParameters",
		"esri/tasks/PrintTemplate",
        "esri/InfoTemplate",
        "esri/layers/ArcGISDynamicMapServiceLayer",
        "esri/symbols/SimpleFillSymbol",
        "esri/symbols/SimpleLineSymbol",
        "esri/tasks/IdentifyTask",
        "esri/tasks/IdentifyParameters",
        "esri/dijit/Popup",
		"esri/tasks/query",
		"esri/tasks/QueryTask",
        "esri/toolbars/draw",
        "esri/graphic",

        "esri/symbols/SimpleMarkerSymbol",

		"esri/dijit/Measurement",
		
        "dojo/_base/array",
        "esri/Color",
        "dojo/dom-construct",
		"dojo/dom",
		
        "dojo/keys",
        "dojo/parser",

        "esri/config",
        "esri/sniff",
        "esri/map",
        "esri/SnappingManager",
        "esri/dijit/Measurement",
        "esri/layers/FeatureLayer",
        "esri/renderers/SimpleRenderer",
        "esri/tasks/GeometryService",
        "esri/symbols/SimpleLineSymbol",
        "esri/symbols/SimpleFillSymbol",
		"esri/geometry/Polygon",
		
		"esri/geometry/webMercatorUtils",
		"esri/dijit/Scalebar",
        "dijit/layout/BorderContainer",
        "dijit/layout/ContentPane",
        "dijit/TitlePane",
        "dijit/form/CheckBox",
		
        "dojo/domReady!",
    ], function(
        Map, PrintTask, PrintParameters, PrintTemplate, InfoTemplate, ArcGISDynamicMapServiceLayer, SimpleFillSymbol,
        SimpleLineSymbol, IdentifyTask, IdentifyParameters, Popup, Query, QueryTask, Draw, Graphic, SimpleMarkerSymbol, Measurement,
        arrayUtils, Color, domConstruct, dom, keys, parser,
        esriConfig, has, Map, SnappingManager, Measurement, FeatureLayer, SimpleRenderer, GeometryService, SimpleLineSymbol, SimpleFillSymbol, Polygon,
		webMercatorUtils, Scalebar
    ) {
		
		var baseUrl = 'http://158.140.181.100';//location.protocol+'//'+location.hostname;
		
		esriConfig.defaults.io.proxyUrl = baseUrl+":8020/arcgisproxy/proxy.php"
		esriConfig.defaults.io.alwaysUseProxy = false;

        var identifyTask, identifyParams;

        var popup = new Popup({
            fillSymbol: new SimpleFillSymbol(SimpleFillSymbol.STYLE_SOLID,
                new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,
                    new Color([255, 0, 0]), 2), new Color([255, 255, 0, 0.25]))
        }, domConstruct.create("div"));

        map = new Map("map", {
            center: [106.8650, -6.1751],
            zoom: 12,
            basemap: "osm",
			slider:false,
			"lods": [{
                      "level": 0,
                      "resolution": 156543.033928,
                      "scale": 591657527.591555
                    }, {
                      "level": 1,
                      "resolution": 78271.5169639999,
                      "scale": 295828763.795777
                    }, {
                      "level": 2,
                      "resolution": 39135.7584820001,
                      "scale": 147914381.897889
                    }, {
                      "level": 3,
                      "resolution": 19567.8792409999,
                      "scale": 73957190.948944
                    }, {
                      "level": 4,
                      "resolution": 9783.93962049996,
                      "scale": 36978595.474472
                    }, {
                      "level": 5,
                      "resolution": 4891.96981024998,
                      "scale": 18489297.737236
                    }, {
                      "level": 6,
                      "resolution": 2445.98490512499,
                      "scale": 9244648.868618
                    }, {
                      "level": 7,
                      "resolution": 1222.99245256249,
                      "scale": 4622324.434309
                    }, {
                      "level": 8,
                      "resolution": 611.49622628138,
                      "scale": 2311162.217155
                    }, {
                      "level": 9,
                      "resolution": 305.748113140558,
                      "scale": 1155581.108577
                    }, {
                      "level": 10,
                      "resolution": 152.874056570411,
                      "scale": 577790.554289
                    }, {
                      "level": 11,
                      "resolution": 76.4370282850732,
                      "scale": 288895.277144
                    }, {
                      "level": 12,
                      "resolution": 38.2185141425366,
                      "scale": 144447.638572
                    }, {
                      "level": 13,
                      "resolution": 19.1092570712683,
                      "scale": 72223.819286
                    }, {
                      "level": 14,
                      "resolution": 9.55462853563415,
                      "scale": 36111.909643
                    }, {
                      "level": 15,
                      "resolution": 4.77731426794937,
                      "scale": 18055.954822
                    }, {
                      "level": 16,
                      "resolution": 2.38865713397468,
                      "scale": 9027.977411
                    }, {
                      "level": 17,
                      "resolution": 1.19432856685505,
                      "scale": 4513.988705
                    }, {
                      "level": 18,
                      "resolution": 0.597164283559817,
                      "scale": 2256.994353
                    }, {
                      "level": 19,
                      "resolution": 0.298582141647617,
                      "scale": 1128.497176
                    }, {
                      "level": 20,
                      "resolution": 0.149291070823808,
                     "scale": 564.248588
                    },{
                      "level": 21,
                      "resolution": 0.07464553541190416,
                     "scale": 282.124294
                    }]
			
        });

        map.on("load", mapReady);
		urlAdminkemdagri = "http://gis.dukcapil.kemendagri.go.id:6080/arcgis/rest/services/batas_admin_baru/MapServer";
		urlMain = baseUrl+":6080/arcgis/rest/services/mnc/main/MapServer";
		
        map.addLayer(new ArcGISDynamicMapServiceLayer(urlAdminkemdagri, {opacity: 0.7, id: 'adminkemdagri'}));
        map.addLayer(new ArcGISDynamicMapServiceLayer(urlMain,{id: 'main'}));
		
		var maplayer = map.getLayer('main');
		maplayer.setVisibleLayers([0,1,2,3,4,5,6,7,8]);
		

		$('.drawingToolButton.toggleButton').click(activateDrawTool);
		$('.icon_draw_clear').click(function(){
			map.graphics.clear();
			$('#drawingHelp').hide();
		});
		$('.icon_measurement,.icon_draw').click(function(){
			if($(this).hasClass('selected')) {
				mapIdentifyListener.remove();
				hasMapIdentifyListener = false;
			} 
		});
		
		function activateDrawTool() {
			var tool = $(this).attr('title').toUpperCase().replace(/ /g, "_");
			drawTool.activate(Draw[tool]);
			$('#drawingHelp').show();
			switch(tool) {
				case "POINT": $('#drawingHelp').html('CLICK to create point <br /> Press ESC to cancel');  break;
				default: $('#drawingHelp').html('CLICK to start <br /> DOUBLE CLICK to end <br /> Press ESC to cancel'); break;
			}
        }
		  
        function mapReady() {
            mapIdentifyListener = map.on("click", executeIdentifyTask);
            identifyTask = new IdentifyTask(urlMain);

            identifyParams = new IdentifyParameters();
            identifyParams.tolerance = 5;
            identifyParams.returnGeometry = true;
            identifyParams.layerIds = [0,1, 6];
            identifyParams.layerOption = IdentifyParameters.LAYER_OPTION_ALL;
            identifyParams.width = map.width;
            identifyParams.height = map.height;
			
			drawTool = new Draw(map);
			drawTool.on("draw-end", addToMap);
			
			map.on("mouse-move", showCoordinates);
			map.on("mouse-drag", showCoordinates);
        }
		
		function showCoordinates(evt) {
			var mp = webMercatorUtils.webMercatorToGeographic(evt.mapPoint);
			
			$('#mapCoordinates').html(mp.x.toFixed(3) + ", " + mp.y.toFixed(3));
        }
		
		var scalebar = new Scalebar({
			map: map,
			scalebarUnit: "dual"
        }, dom.byId("mapScalebar"));
		
		
		function addToMap(evt) {
			var symbol;
			drawTool.deactivate();
			map.showZoomSlider();
			switch (evt.geometry.type) {
				case "point":
				case "multipoint":
				symbol = new SimpleMarkerSymbol();
				break;
            case "polyline":
				symbol = new SimpleLineSymbol();
				break;
            default:
				symbol = new SimpleFillSymbol();
				break;
			}
			var graphic = new Graphic(evt.geometry, symbol);
			map.graphics.add(graphic);
			$('.drawingToolButton').removeClass('selected');
			$('#drawingHelp').hide();
		}

        executeIdentifyTask = function(event) {
			resetMapPanel();
            identifyParams.geometry = event.mapPoint;
            identifyParams.mapExtent = map.extent;

            var deferred = identifyTask
                .execute(identifyParams)
                .addCallback(function(response) {
                    // response is an array of identify result objects
                    // Let's return an array of features.
                    return arrayUtils.map(response, function(result) {
                        var feature = result.feature;
                        var layerName = result.layerName;

                        feature.attributes.layerName = layerName;
                        if (layerName === 'ODP') {
                            var infoTemplate = new InfoTemplate("ODP",
								"<button onclick='showModalODP(${objectid})' class='mapPopupButton'> view detail</button>" +
                                "<Table>" +
									"<tr><td><b>ID ODP</b></td><td>&nbsp:&nbsp</td><td> ${id} </td></tr> " +
									"<tr><td><b>Type BOQ</b></td><td>&nbsp:&nbsp</td><td> ${type_boq} </td></tr> " +
									"<tr><td><b>PON</b></td><td>&nbsp:&nbsp</td><td> ${pon} </td></tr> " +
									"<tr><td><b>OLT</b></td><td>&nbsp:&nbsp</td><td> ${olt} </td></tr> " +
									"<tr><td><b>HUB</b></td><td>&nbsp:&nbsp</td><td>  ${hub} </td></tr> " +
									"<tr><td><b>Cable No.</b></td><td>&nbsp:&nbsp</td><td> ${cable_no} </td></tr> " +
									"<tr><td><b>Core In</b></td><td>&nbsp:&nbsp</td><td> ${core_in} </td></tr> " +
									"<tr><td><b>HP Handle</b></td><td>&nbsp:&nbsp</td><td> ${hp_handle} </td></tr> " +
									"<tr><td><b>Material</b></td><td>&nbsp:&nbsp</td><td> ${material} </td></tr> " +
									"<tr><td><b>PON IP</b></td><td>&nbsp:&nbsp</td><td> ${pon_ip} </td></tr> " +
									"<tr><td><b>VLAN</b></td><td>&nbsp:&nbsp</td><td> ${vlan} </td></tr> " +
									"<tr><td><b>Homepass</b></td><td>&nbsp:&nbsp</td><td> ${homepass} </td></tr> " +
									"<tr><td><b>Lokasi</b></td><td>&nbsp:&nbsp</td><td> ${lokasi} </td></tr> " +
									"<tr><td><b>Koordinat</b></td><td>&nbsp:&nbsp</td><td> ${koordinat} </td></tr> " +
                                "</table>"
                            );
                            feature.setInfoTemplate(infoTemplate);
                        } else if (layerName === 'ODC') {
                            var infoTemplate = new InfoTemplate("ODC",
                                "<button onclick='showModalODC(${objectid})' class='mapPopupButton'> view detail</button>" +
                                "<Table>" +
									"<tr><td><b>ODC Name</b></td><td>&nbsp:&nbsp</td><td> ${odc_name} </td></tr> " +
									"<tr><td><b>Homepass</b></td><td>&nbsp:&nbsp</td><td> ${homepass} </td></tr> " +
									"<tr><td><b>F2_8</b></td><td>&nbsp:&nbsp</td><td> ${f2_8} </td></tr> " +
									"<tr><td><b>Reference</b></td><td>&nbsp:&nbsp</td><td> ${refname} </td></tr> " +
                                "</table>"
                            );
                            feature.setInfoTemplate(infoTemplate);
                        } else if (layerName === 'BANGUNAN') {
                            var infoTemplate = new InfoTemplate("BANGUNAN RW ${rw}",
                                "<button onclick='showModalBangunan(${objectid})' class='mapPopupButton'> view detail</button>" +
                                "<Table>" +
									"<tr><td><b>Kecamatan</b></td><td>&nbsp:&nbsp</td><td> ${kecamatan} </td></tr> " +
									"<tr><td><b>Kelurahan</b></td><td>&nbsp:&nbsp</td><td> ${kelurahan} </td></tr> " +
									"<tr><td><b>Nama Jalan</b></td><td>&nbsp:&nbsp</td><td> ${nama_jalan} </td></tr> " +
									"<tr><td><b>No. Rumah</b></td><td>&nbsp:&nbsp</td><td> ${no_rumah} </td></tr> " +
								"</table>"

                            );
                            feature.setInfoTemplate(infoTemplate);
                        }
						
                        return feature;
                    });
                });

            // InfoWindow expects an array of features from each deferred
            // object that you pass. If the response from the task execution
            // above is not an array of features, then you need to add a callback
            // like the one above to post-process the response and return an
            // array of features.
            map.infoWindow.setFeatures([deferred]);
            map.infoWindow.show(event.mapPoint);
        }
		
		
		printTask = new PrintTask(baseUrl+":6080/arcgis/rest/services/sisterpabum/printingtools/GPServer/Export%20Web%20Map");
		params = new PrintParameters();
		var template = new PrintTemplate();
		template.layout = "A4 Landscape";
		params.template = template;
		
		var measurement = new Measurement({
			map: map,
			defaultLengthUnit: "esriKilometers",
			defaultAreaUnit: "esriSquareKilometers"
        }, dom.byId("measurementDiv"));
        measurement.startup();
		
		zoomtoPointPotensi = function(id) {
			if (!isNaN(id) || typeof id == "string") {
				var query = new Query();
				var queryTask = new QueryTask(urlMain+"/3");
				if (typeof id == "string") {
					query.where = "area = '"+id+"'";
				} else {
					query.where = "objectid = "+id;
				}
				query.outSpatialReference = {wkid:900913}; 
				query.returnGeometry = true;
				query.outFields = ["objectid"];
				queryTask.execute(query, function(result){
					pt = result['features'][0]['geometry'];
					symbol = new SimpleMarkerSymbol();
					var graphic = new Graphic(pt, symbol);
					map.graphics.clear();
					map.graphics.add(graphic);
					map.centerAndZoom(pt,12);
				});
			}
		};
		
		zoomtoPointWkp = function(id) {
			if (!isNaN(id) || typeof id == "string") {
				var query = new Query();
				var queryTask = new QueryTask(urlMain+"/4");
				if (typeof id == "string") {
					query.where = "nama_wkp = '"+id+"'";
				} else {
					query.where = "objectid = "+id;
				}
				query.outSpatialReference = {wkid:900913}; 
				query.returnGeometry = true;
				query.outFields = ["objectid"];
				queryTask.execute(query, function(result){
					pt = result['features'][0]['geometry'];
					map.setExtent(pt.getExtent(), true);
				});
			}
		};
		
		zoomtoPointWpsp = function(id) {
			if (!isNaN(id) || typeof id == "string") {
				var query = new Query();
				var queryTask = new QueryTask(urlMain+"/5");
				if (typeof id == "string") {
					query.where = "nama_wpsp = '"+id+"'";
				} else {
					query.where = "objectid = "+id;
				}
				query.outSpatialReference = {wkid:900913}; 
				query.returnGeometry = true;
				query.outFields = ["objectid"];
				queryTask.execute(query, function(result){
					pt = result['features'][0]['geometry'];
					map.setExtent(pt.getExtent(), true);
				});
			}
		};
		
		zoomtoPointWpspe = function(id) {
			if (!isNaN(id) || typeof id == "string") {
				var query = new Query();
				var queryTask = new QueryTask(urlMain+"/1");
				if (typeof id == "string") {
					query.where = "nama_wpspe = '"+id+"'";
				} else {
					query.where = "objectid = "+id;
				}
				query.outSpatialReference = {wkid:900913}; 
				query.returnGeometry = true;
				query.outFields = ["objectid"];
				queryTask.execute(query, function(result){
					pt = result['features'][0]['geometry'];
					map.setExtent(pt.getExtent(), true);
				});
			}
		};
		
		zoomtoPointPltp = function(id) {
			if (!isNaN(id) || typeof id == "string") {
				var query = new Query();
				var queryTask = new QueryTask(urlMain+"/2");
				if (typeof id == "string") {
					query.where = "pltp = '"+id+"'";
				} else {
					query.where = "objectid = "+id;
				}
				query.outSpatialReference = {wkid:900913}; 
				query.returnGeometry = true;
				query.outFields = ["objectid"];
				queryTask.execute(query, function(result){
					pt = result['features'][0]['geometry'];
					symbol = new SimpleMarkerSymbol();
					var graphic = new Graphic(pt, symbol);
					map.graphics.clear();
					map.graphics.add(graphic);
					map.centerAndZoom(pt,12);
				});
			}
		};
		
		setInputcoordinatesPolygon = function(polygonArray) {
			pt = new Polygon(polygonArray);
			console.log(pt);
			symbol = new SimpleFillSymbol();
			var graphic = new Graphic(pt, symbol);
			map.graphics.clear();
			map.graphics.add(graphic);
			map.setExtent(pt.getExtent(), true);
		}
		
    });
});