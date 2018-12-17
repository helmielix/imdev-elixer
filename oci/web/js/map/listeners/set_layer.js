/* global Ext, map, ol, loadTrackingByIdStore */

var layer_outline, layer_rencana_kerja;
            
			
function setListeners_layer() {
    var coord;
	var contourGridStoreLoaded = 0;
    // Adding 2d vector ship static data 
    source = new ol.source.Vector();
    sourceZoomOut = new ol.source.Vector();
    sourceZoomIn = new ol.source.Vector();
    sourceLadderZoom = new ol.source.Vector();
    sourceOutputMining = new ol.source.Vector();

    vector = new ol.layer.Vector({
        source: source
    });

    vectorKapal = new ol.layer.Vector({
        source: sourceZoomOut
    });

    vectorKapalZoom = new ol.layer.Vector({
        source: sourceZoomIn
    });
    
    vectorLadderZoom = new ol.layer.Vector({
        source: sourceLadderZoom
    });
    
    vectorOutputMining = new ol.layer.Vector({
        source: sourceOutputMining
    });

    function setGridContour(records) {
        records.each(function (record, index) {
            var feature = new ol.Feature({
                name: "contourGrid"
            });
            var es_x = record.data['properties.es_x'];
            var x = (es_x*2.5) + 500000;
            var es_y = record.data['properties.es_y'];
            var y = -(es_y*2.5) + 9840000;
            var tlr = record.data['properties.tlr'];
        
			var r = 0;
            var g = 0;
            var b = 0; 
            
            if (tlr <= 38) {
				r = 255;
                g = 255 - Math.floor(255*(tlr/38));
            } else {
                g = 0;
				r = 255 - Math.floor(255*((tlr-38)/7));
            }
                
            var style = new ol.style.Style({
                fill: new ol.style.Fill({
                    color: 'rgba('+r+', '+g+', '+b+', 0.8)'
                })
            });
                
            // Static 2d Vector Ship
            var polygonArray = [];
            polygonArray.push([x - 1.25, y - 1.25]);
            polygonArray.push([x - 1.25, y + 1.25]);
            polygonArray.push([x + 1.25, y + 1.25]);
            polygonArray.push([x + 1.25, y - 1.25]);
            var polygon = new ol.geom.Polygon([[
                    ol.proj.transform([polygonArray[0][0], polygonArray[0][1]], 'EPSG:32748', 'EPSG:3857'),
                    ol.proj.transform([polygonArray[1][0], polygonArray[1][1]], 'EPSG:32748', 'EPSG:3857'),
                    ol.proj.transform([polygonArray[2][0], polygonArray[2][1]], 'EPSG:32748', 'EPSG:3857'),
                    ol.proj.transform([polygonArray[3][0], polygonArray[3][1]], 'EPSG:32748', 'EPSG:3857'),
                ]]);
            feature.setGeometry(polygon);
            feature.setStyle(style);
            vectorOutputMining.getSource().addFeature(feature);
        
        });
    }
    
    function setViewShipOnTop(evt, record) {
        var store = Ext.StoreMgr.lookup('trackingCurrentStore');
        store.each(function (record, index) {
            coord = ol.proj.transform([record.data.lon * 1, record.data.lat * 1], 'EPSG:4326', 'EPSG:900913');
            var featureship2d = new ol.Feature({
                name: "ship2d"
            });
            var gid = record.data.gid;
            var long = record.data.lon;
            var lat = record.data.lat;
            var headingangle = record.data.heading;
            var pitchangle = record.data.pitch;
            var rollangle = record.data.roll;
            var ladderangle = record.data.ladder;
            var shipName = record.data.shipname;
            var cutterX = 500000 + (record.data.cutter_x*2.5);
            var cutterY = 9840000 - (record.data.cutter_y*2.5);

            // Changing ship status by displaying different colour. Red = Tidak Operasi, blue = Sedang Operasi.
            if (!record.data.pt_on) {
                var shipBigZoom = new ol.style.Style({
                    fill: new ol.style.Fill({
                        color: 'rgba(255, 0, 0, 0.6)'
                    }),
                    stroke: new ol.style.Stroke({
                        color: '#000000',
                        width: 2
                    }),
                    text: new ol.style.Text({
                        font: '24px Courier New',
                        text: shipName,
                        stroke: new ol.style.Stroke({
                            color: 'white',
                            width: 2
                        }),
                        fill: new ol.style.Fill({
                            color: 'black'
                        })
                    })

                });
            } else {
                var shipBigZoom = new ol.style.Style({
                    fill: new ol.style.Fill({
                        color: 'rgba(0, 0, 255, 0.6)'
                    }),
                    stroke: new ol.style.Stroke({
                        color: '#000000',
                        width: 2
                    }),
                    text: new ol.style.Text({
                        font: '24px Courier New',
                        text: shipName,
                        stroke: new ol.style.Stroke({
                            color: 'white',
                            width: 2
                        }),
                        fill: new ol.style.Fill({
                            color: 'black'
                        })
                    })

                });
            }
            ;
                
            var shipLadderPoint = new ol.geom.Point( ol.proj.transform([cutterX,cutterY], 'EPSG:32748', 'EPSG:3857'));

            var featureLadder = new ol.Feature({
                name: 'ladder'
            });

            var ladderStyle = new ol.style.Style({
                image: new ol.style.Circle({
                    fill: new ol.style.Fill({
                          color: 'blue'
                        }),
                    stroke: new ol.style.Stroke({
                      color: 'olive',
                      width: 1
                    }),
                    
                    radius: 8
                  }),
        
              });
            
            featureLadder.setGeometry(shipLadderPoint);
            featureLadder.setStyle(ladderStyle);
            vectorLadderZoom.getSource().addFeature(featureLadder);
            
            var featureShip = new ol.Feature({
                name: 'featureShip'
            });
            
            var shipX = coord[0];
            var shipY = coord[1];
            var shipPolygonArray = [];
            shipPolygonArray.push([shipX - 8.5, shipY - 42.5]);
            shipPolygonArray.push([shipX - 9.3, shipY - 41.2]);
            shipPolygonArray.push([shipX - 9.3, shipY + 10]);
            shipPolygonArray.push([shipX - 5, shipY + 25]);
            shipPolygonArray.push([shipX - 5, shipY + 41.5]);
            shipPolygonArray.push([shipX - 4.5, shipY + 42.5]);
            shipPolygonArray.push([shipX - 1.5, shipY + 42.5]);
            shipPolygonArray.push([shipX - 1.5, shipY - 10]);
            shipPolygonArray.push([shipX + 1.5, shipY - 10]);
            shipPolygonArray.push([shipX + 1.5, shipY + 42.5]);
            shipPolygonArray.push([shipX + 4.5, shipY + 42.5]);
            shipPolygonArray.push([shipX + 5, shipY + 41.5]);
            shipPolygonArray.push([shipX + 5, shipY + 25]);
            shipPolygonArray.push([shipX + 9.3, shipY + 10]);
            shipPolygonArray.push([shipX + 9.3, shipY - 41.2]);
            shipPolygonArray.push([shipX + 8.5, shipY - 42.5]);
            shipPolygonArray = rotateShip(shipPolygonArray,record.data.heading, coord)
            var shipPolygon = new ol.geom.Polygon([shipPolygonArray]);
            featureShip.setGeometry(shipPolygon);
            featureShip.setStyle(shipBigZoom);
            vectorKapalZoom.getSource().addFeature(featureShip);
            
        });
    }

    function setViewShipOnSide() {
        var store = Ext.StoreMgr.lookup('trackingCurrentStore');
        var shipTotal = store.data.items.length;
        var features = new Array(shipTotal);
        store.each(function (record, index) {
            var pt_on = record.data.pt_on;
            var shipname = record.data.shipname;
            var lon = record.data.lon;
            var lat = record.data.lat;
            var coordinates = [lon, lat];

            var ship2dXY = ol.proj.transform([lon, lat], 'EPSG:4326', 'EPSG:3857');
            var ship2dPoint = new ol.geom.Point([ship2dXY[0], ship2dXY[1]]);

            var featureship2d = new ol.Feature({
                name: shipname
            });

            if (!pt_on) {
                var shipStyle = new ol.style.Style({
                    image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                        anchor: [0.5, 46],
                        anchorXUnits: 'fraction',
                        anchorYUnits: 'pixels',
                        src: './resources/images/ship-2d-red.png',
                        scale: 0.1
                    })),
                    text: new ol.style.Text({
                        font: '18px Courier New',
                        text: shipname,
                        offsetY: -10,
                        stroke: new ol.style.Stroke({
                            color: 'white',
                            width: 2
                        }),
                        fill: new ol.style.Fill({
                            color: 'black'
                        })
                    })
                });
            } else {
                var shipStyle = new ol.style.Style({
                    image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                        anchor: [0.5, 46],
                        anchorXUnits: 'fraction',
                        anchorYUnits: 'pixels',
                        src: './resources/images/ship-2d-blue.png',
                        scale: 0.1
                    })),
                    text: new ol.style.Text({
                        font: '18px Courier New',
                        text: shipname,
                        offsetY: -10,
                        stroke: new ol.style.Stroke({
                            color: 'white',
                            width: 2
                        }),
                        fill: new ol.style.Fill({
                            color: 'black'
                        })
                    })
                });
            }
            ;
            featureship2d.setGeometry(ship2dPoint);
            featureship2d.setStyle(shipStyle);
            vectorKapal.getSource().addFeature(featureship2d);
        });
    }

      var viewZoom = map.on('moveend', function () {
        if (map.getView().getZoom() <= 15) {
            vectorKapal.setVisible(true)
            vectorKapalZoom.setVisible(false)
            vectorLadderZoom.setVisible(false)
        } else {

            vectorKapalZoom.setVisible(true)
            vectorLadderZoom.setVisible(true)
            vectorKapal.setVisible(false)
        }
    });

    var projection = new ol.proj.Projection({
        code: 'EPSG:32748'
    });
    var layer_osm = new ol.layer.Tile({source: new ol.source.OSM()});

    // Setting basemap default to OSM
    map.addLayer(layer_osm);

    var layer_mapquest = new ol.layer.Tile({source: new ol.source.MapQuest({layer: 'sat'})});
    var layer_basemap = new ol.layer.Tile({
        source: new ol.source.XYZ({
            url: 'http://server.arcgisonline.com/ArcGIS/rest/services/' +
                    'World_Topo_Map/MapServer/tile/{z}/{y}/{x}'
        })
    });
    layer_rencana_kerja = new ol.layer.Image({
        source: new ol.source.ImageWMS({
            url: 'http://' + window.location.hostname + ':8084' + '/geoserver/wms',
            params: {
                'LAYERS': [
                    'siopl:rencana_kerja'
                ]
            },
            serverType: 'geoserver',
            projection: ol.proj.transform([571900.765000, 9763500.34700], 'EPSG:32748', 'EPSG:900913')
        })
    });
    var layer_titik_gali = new ol.layer.Image({
        source: new ol.source.ImageWMS({
            url: 'http://' + window.location.hostname + ':8084' + '/geoserver/wms',
            params: {
                'LAYERS': [
                    'siopl:titik_gali'
                ]
            },
            serverType: 'geoserver',
            projection: ol.proj.transform([571900.765000, 9763500.34700], 'EPSG:32748', 'EPSG:900913')
        })
    });
    var layer_kontur = new ol.layer.Image({
        source: new ol.source.ImageWMS({
            url: 'http://' + window.location.hostname + ':8084' + '/geoserver/wms',
            params: {
                'LAYERS': [
                    'siopl:kontur2d'
                ]
            },
            serverType: 'geoserver',
            projection: ol.proj.transform([571900.765000, 9763500.34700], 'EPSG:32748', 'EPSG:900913')
        })
    });
    var layer_outline = new ol.layer.Image({
        source: new ol.source.ImageWMS({
            url: 'http://' + window.location.hostname + ':8084' + '/geoserver/wms',
            params: {
                'LAYERS': [
                    'siopl:outline_polygon'
                ]
            },
            serverType: 'geoserver',
            projection: ol.proj.transform([571900.765000, 9763500.34700], 'EPSG:32748', 'EPSG:900913')
        })
    });
    var iup_timah = new ol.layer.Image({
        source: new ol.source.ImageWMS({
            url: 'http://' + window.location.hostname + ':8084' + '/geoserver/wms',
            params: {
                'LAYERS': [
                    'siopl:iup_timah'
                ]
            },
            serverType: 'geoserver',
            projection: ol.proj.transform([571900.765000, 9763500.34700], 'EPSG:32748', 'EPSG:900913')
        })
    });

    vector_marking = new ol.layer.Image({
        source: new ol.source.ImageVector({
            source: new ol.source.Vector({
                url: 'http://' + window.location.hostname + ':8084/geoserver/siopl/ows?service=WFS&version=1.1.0&request=GetFeature&typeNames=siopl:marking&outputFormat=application/json&exceptions=application/json&srsName=EPSG:32748',
                format: new ol.format.GeoJSON({
                    defaultDataProjection: projection
                })
            }),
            style: new ol.style.Style({
                image: new ol.style.Icon({
                    src: './resources/images/warning.png' // change this style
                })
            })
        })
    });
    
    setTimeout(function () {
        map.addLayer(layer_basemap);
        map.addLayer(layer_kontur);
        map.addLayer(layer_rencana_kerja);
        map.addLayer(layer_outline);
        map.addLayer(vectorOutputMining);
        map.addLayer(vector);
        map.addLayer(vectorKapal);
        map.addLayer(vectorKapalZoom);
        map.addLayer(vectorLadderZoom);
        map.addLayer(vector_marking);
        map.addLayer(iup_timah);
        map.addLayer(layer_titik_gali);

        vector_marking.set('selectable', true);
        layer_basemap.setVisible(false);
        layer_kontur.setVisible(false);
        layer_rencana_kerja.setVisible(false);
        layer_outline.setVisible(false);
        vectorOutputMining.setVisible(false);
        vectorLadderZoom.setVisible(false);
        layer_titik_gali.setVisible(false);
        vector_marking.setVisible(false);
        vectorKapalZoom.setVisible(false);
        iup_timah.setVisible(false);
    }, 1000);

    Ext.getCmp("layer_basemap").on("toggle", function () {
        if (this.pressed) {
            layer_basemap.setVisible(false);
        } else {
            layer_basemap.setVisible(true);
        }
    });
    Ext.getCmp('layer_kapal').on("toggle", function () {
        if (this.pressed) {
			Ext.getCmp('shipGrid').getStore().load();
            map.on('moveend', function () {
                if (map.getView().getZoom() <= 15) {
                    vectorKapal.setVisible(true)
                    vectorKapalZoom.setVisible(false)
                    vectorLadderZoom.setVisible(false)
                } else {
                    vectorKapalZoom.setVisible(true)
                    vectorLadderZoom.setVisible(true)
                    vectorKapal.setVisible(false)
                }
            });
        } else {
            map.unByKey(viewZoom);
            sourceZoomIn.clear();
            sourceZoomOut.clear();
            sourceLadderZoom.clear();
            vectorKapal.setVisible(false);
            vectorKapalZoom.setVisible(false);
            vectorLadderZoom.setVisible(false); 
        }
    });
    Ext.getCmp('layer_iup').on("toggle", function () {
        if (this.pressed) {
            iup_timah.setVisible(true);
        } else {
            iup_timah.setVisible(false);
        }
    });
    Ext.getCmp('layer_output_mining').on("toggle", function () {
        if (this.pressed) {
            vectorOutputMining.setVisible(true);
        } else {
            vectorOutputMining.setVisible(false);
        }
    });
    Ext.getCmp('layer_outline').on("toggle", function () {
        if (this.pressed) {
            layer_outline.setVisible(true);
        } else {
            layer_outline.setVisible(false);
        }
    });
    // Popup showing the position when user click
    var popup = new ol.Overlay({
        element: document.getElementById('popup_titik_gali')
    });
    map.addOverlay(popup);
    Ext.getCmp('layer_titik_gali').on("toggle", function () {
        if (this.pressed) {
            // redraw layer
            var params = layer_titik_gali.getSource().getParams();
            params.t = new Date().getMilliseconds();
            layer_titik_gali.getSource().updateParams(params);
            layer_titik_gali.setVisible(true);
            var b = map.on('singleclick', function(evt) {
                var coordinate = evt.coordinate;
                var element = popup.getElement();
                var viewResolution = /** @type {number}  */ (map.getView().getResolution());
                var url = layer_titik_gali.getSource().getGetFeatureInfoUrl(
                    coordinate, viewResolution, 'EPSG:3857',
                    {'INFO_FORMAT': 'application/json'}
                    );
                if (url) {
                    $(element).popover('destroy');
                    Ext.Ajax.request({
                        method: 'GET',
                        url: url,
                        success: function(record, response) {
                            jsonString = record.responseText;
                            var json = JSON.parse(jsonString);
                            if (json.features.length > 0) {
                                var hole = json.features[0].properties.hole;
                                var tlr = json.features[0].properties.tlr;
                                var tebal = json.features[0].properties.tebal;
                                var dl_kong = json.features[0].properties.dl_kong;
                                var tdh = json.features[0].properties.tdh;
                                popup.setPosition(coordinate);
                                $(element).popover({
                                    'placement': 'top',
                                    'animation': false,
                                    'html': true,
                                    'content': '<p> Hole:\t' + hole + '</p> \n<p> TLR:\t' + tlr + '</p> \n<p> Tebal:\t' + tebal + '</p> \n<p> DL_Kong:\t' + dl_kong + '</p> \n<p> TDH:\t' + tdh + '</p>'
                                });
                                $(element).popover('show'); 
                            }
                            
                        }
                    });
                    
                } else {
                    map.unByKey(b);
                }
            })

        } else {
            layer_titik_gali.setVisible(false);
            map.unByKey(b);
            var element = popup.getElement();
            $(element).popover('destroy');
        }
    });
    Ext.getCmp('layer_kontur').on("toggle", function () {
        if (this.pressed) {
            layer_kontur.setVisible(true);
        } else {
            layer_kontur.setVisible(false);
        }
    });
    Ext.getCmp('layer_rencana_kerja').on("toggle", function () {
        if (this.pressed) {
            layer_rencana_kerja.setVisible(true);
        } else {
            layer_rencana_kerja.setVisible(false);
        }
    });
    Ext.getCmp('layer_marking').on("toggle", function () {
        if (this.pressed) {
            vector_marking.setVisible(true);
        } else {
            vector_marking.setVisible(false);
        }
    });

    Ext.getCmp('shipGrid').addListener("itemdblclick", function (evt, record) {
        var coord = ol.proj.transform([record.data.lon * 1, record.data.lat * 1], 'EPSG:4326', 'EPSG:900913');
        map.setView(new ol.View({center: coord, zoom: 18}));
        var headingangle = record.data.heading;
        var pitchangle = record.data.pitch;
        var rollangle = record.data.roll;
        var ladderangle = record.data.ladder_pitch;
        var ladderdepth = record.data.cutter_z;
        var sliderpitch = document.getElementById('gridpitchimg').style.transform = 'rotate(' + pitchangle + 'deg)';
        var sliderroll = document.getElementById('gridrollimg').style.transform = 'rotate(' + rollangle + 'deg)';
        var sliderheading = document.getElementById('gridheadingimg').style.transform = 'rotate(' + headingangle + 'deg)';
        var sliderladder = document.getElementById('gridladderimg').style.transform = 'translate(-65px, -65px) rotate(' + ladderangle + 'deg) translate(65px, 65px)';


        Ext.getCmp('eastpanel').getLayout().setActiveItem(0);
        Ext.getCmp('eastpanel').expand();
        Ext.getCmp("txt_pitch").setText(pitchangle+'&deg');
        Ext.getCmp("txt_roll").setText(rollangle+'&deg');
        Ext.getCmp("txt_heading").setText(headingangle+'&deg');
        Ext.getCmp("txt_ladder").setText(ladderangle+'&deg');
        Ext.getCmp("txt_ladderdepth").setText(ladderdepth+' m');

    });

    // rendering vector ship 2d in every time ship list panel reload
    Ext.getCmp('shipGrid').getStore().on('load', function () {
        sourceZoomIn.clear();
        sourceZoomOut.clear();
        sourceLadderZoom.clear();
        setViewShipOnSide();
        setViewShipOnTop();
		if(contourGridStoreLoaded == 0 || contourGridStoreLoaded == 20) {
			contourGridStore.load();
		} else {
			contourGridStoreLoaded++;
		}
    });
    
    contourGridStore.on('load', function (records) {
        vectorOutputMining.getSource().clear();
		contourGridStoreLoaded = 1;
        setGridContour(records);
    });

    ship = Ext.getCmp("comboboxInformation").value;
    if (ship !== null || typeof (ship) !== 'undefined') {
        var selectComboShipList = function (record) {
            var ship = Ext.getCmp("comboboxInformation").value;
            Ext.Ajax.request({
                url: '/SIOPL/map/loadTrackingByIdShip.htm',
                method: 'POST',
                params: {
                    idship: ship
                },
                success: function (record, response) {
                    var jsonString = record.responseText;
                    var store = JSON.parse(jsonString);

                    if (store.length > 0) {
                        var coord = ol.proj.transform([store[0].lon * 1, store[0].lat * 1], 'EPSG:4326', 'EPSG:900913');
                        map.setView(new ol.View({center: coord, zoom: 18}));
                        var pitchangle = store[0].pitch;
                        var rollangle = store[0].roll;
                        var headingangle = store[0].heading;
                        var ladderangle = store[0].ladder_pitch;
                        var ladderdepth = store[0].cutter_z;
                        var sliderpitch = document.getElementById('gridpitchimg').style.transform = 'rotate(' + pitchangle + 'deg)';
                        var sliderroll = document.getElementById('gridrollimg').style.transform = 'rotate(' + rollangle + 'deg)';
                        var sliderheading = document.getElementById('gridheadingimg').style.transform = 'rotate(' + headingangle + 'deg)';
                        var sliderladder = document.getElementById('gridladderimg').style.transform = 'translate(-65px, -65px) rotate(' + ladderangle + 'deg) translate(65px, 65px)';

                        Ext.getCmp('eastpanel').getLayout().setActiveItem(0);
                        Ext.getCmp('eastpanel').expand();
                        Ext.getCmp("txt_pitch").setText(pitchangle+'&deg');
                        Ext.getCmp("txt_roll").setText(rollangle+'&deg');
                        Ext.getCmp("txt_heading").setText(headingangle+'&deg');
                        Ext.getCmp("txt_ladder").setText(ladderangle+'&deg');
                        Ext.getCmp("txt_ladderdepth").setText(ladderdepth+' m');
                    }
                }
            });

        };

        var comboboxShip = Ext.getCmp("shipGrid").down("combobox");
        comboboxShip.on('select', selectComboShipList, this);
        Ext.getCmp('shipGrid').getStore().on('load', selectComboShipList);
    }


}