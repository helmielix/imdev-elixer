/* global Ext, map, ol, pointerMoveHandler, draw, drawend, source, sliderData, shipId, vectorMiningLayerLine */
function setListeners_tracking() {

    var sourceTracking = new ol.source.Vector();
    var sourceLadderTracking = new ol.source.Vector();
    var sourceMiningLayer = new ol.source.Vector();
    var sourceMiningLayerLine = new ol.source.Vector();

    var vectorTracking = new ol.layer.Vector({
        source: sourceTracking
    });

    var vectorLadderTracking = new ol.layer.Vector({
        source: sourceLadderTracking
    });

    var vectorMiningLayer = new ol.layer.Vector({
        source: sourceMiningLayer
    });

    vectorMiningLayerLine = new ol.layer.Vector({
        source: sourceMiningLayerLine
    });

    map.addLayer(vectorTracking);
    map.addLayer(vectorMiningLayer);
    map.addLayer(vectorMiningLayerLine);
    map.addLayer(vectorLadderTracking);

    var playBack = new Array();
    var coordArray = [];
    var i = 0;
    function setShipTracking(index) {
        var pointX = playBack[0].records[index].lon;
        var pointY = playBack[0].records[index].lat;
        var pt_on = playBack[0].records[index].pt_on;
        var heading = playBack[0].records[index].heading;
        var pitchangle = playBack[0].records[index].pitch;
        var rollangle = playBack[0].records[index].roll;
        var ladderangle = playBack[0].records[index].ladder;
        var ladderdepth = playBack[0].records[index].cutter_z;
        var date = playBack[0].records[index].date;
        var cutterX = 500000 + (playBack[0].records[index].cutter_x * 2.5);
        var cutterY = 9840000 - (playBack[0].records[index].cutter_y * 2.5);

        var sliderpitch = document.getElementById('gridpitchimg').style.transform = 'rotate(' + pitchangle + 'deg)';
        var sliderroll = document.getElementById('gridrollimg').style.transform = 'rotate(' + rollangle + 'deg)';
        var sliderheading = document.getElementById('gridheadingimg').style.transform = 'rotate(' + heading + 'deg)';
        var sliderladder = document.getElementById('gridladderimg').style.transform = 'translate(-65px, -65px) rotate(' + ladderangle + 'deg) translate(65px, 65px)';

        Ext.getCmp('eastpanel').getLayout().setActiveItem(0);
        Ext.getCmp('eastpanel').expand();
        Ext.getCmp("txt_pitch").setText(pitchangle + '&deg');
        Ext.getCmp("txt_roll").setText(rollangle + '&deg');
        Ext.getCmp("txt_heading").setText(heading + '&deg');
        Ext.getCmp("txt_ladder").setText(ladderangle + '&deg');
        Ext.getCmp("txt_ladderdepth").setText(ladderdepth + ' m');

        Ext.getCmp("playback_date").setText('Date: '+ date);
        var coord = ol.proj.transform([pointX, pointY], 'EPSG:4326', 'EPSG:900913');
        var shipLadderPoint = ol.proj.transform([cutterX, cutterY], 'EPSG:32748', 'EPSG:900913');

        // create geom line for drawing ladder when playback
        if (pt_on) {
            if (coordArray.length > 0) {
                if (cutterX !== coordArray[i][0] && cutterY !== coordArray[i][1]) {
                    coordArray.push(shipLadderPoint);
                    var cutterXShipLine = coordArray[i][0];
                    var cutterYShipLine = coordArray[i][1];
                    var coord2 = [cutterXShipLine, cutterYShipLine];
                    i++;
                }
            } else {
                coordArray.push(shipLadderPoint);
            }
        }

        var shipX = coord[0];
        var shipY = coord[1];
        if (shipX == null || shipY == null) {
            console.log(playBack[0].records[index]);
        } else {
            var polygonArray = [];
            polygonArray.push([shipX - 8.5, shipY - 42.5]);
            polygonArray.push([shipX - 9.3, shipY - 41.2]);
            polygonArray.push([shipX - 9.3, shipY + 10]);
            polygonArray.push([shipX - 5, shipY + 25]);
            polygonArray.push([shipX - 5, shipY + 41.5]);
            polygonArray.push([shipX - 4.5, shipY + 42.5]);
            polygonArray.push([shipX - 1.5, shipY + 42.5]);
            polygonArray.push([shipX - 1.5, shipY - 10]);
            polygonArray.push([shipX + 1.5, shipY - 10]);
            polygonArray.push([shipX + 1.5, shipY + 42.5]);
            polygonArray.push([shipX + 4.5, shipY + 42.5]);
            polygonArray.push([shipX + 5, shipY + 41.5]);
            polygonArray.push([shipX + 5, shipY + 25]);
            polygonArray.push([shipX + 9.3, shipY + 10]);
            polygonArray.push([shipX + 9.3, shipY - 41.2]);
            polygonArray.push([shipX + 8.5, shipY - 42.5]);
            polygonArray = rotateShip(polygonArray, heading, coord);
            var ship2d = new ol.geom.Polygon([polygonArray]);
        }

        var colorShip = new ol.style.Style({
            fill: new ol.style.Fill({
                color: 'rgba(0, 0, 255, 0.6)'
            }),
            stroke: new ol.style.Stroke({
                color: '#000000',
                width: 2
            })
        });

        var ladderTracking = new ol.geom.Point(shipLadderPoint);

        var featureLadder = new ol.Feature({
            geometry: ladderTracking,
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
            })

        });

        var featureship2d = new ol.Feature({
            name: "ship2d",
            geometry: ship2d
        });

        vectorKapalZoom.setVisible(false);
        vectorLadderZoom.setVisible(false);
        sourceZoomIn.clear();
        sourceTracking.clear();
        sourceLadderTracking.clear();
        sourceLadderZoom.clear();
        featureship2d.setStyle(colorShip);
        sourceTracking.addFeature(featureship2d);
        featureLadder.setStyle(ladderStyle);
        sourceLadderTracking.addFeature(featureLadder);

        var lineMining = new ol.geom.Point(shipLadderPoint);
        // create the feature
        var mineFeature = new ol.Feature({
            geometry: lineMining,
            name: 'Tracking Point'
        });

        if (typeof coord2 !== 'undefined') {
            var coordMiningLine = [shipLadderPoint, coord2];
        }
        var lineString = new ol.geom.LineString(coordMiningLine);
        var mineFeatureLine = new ol.Feature({
            geometry: lineString,
            name: 'Tracking Line'
        });

        var lineMiningStyleLine = new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: '#000000',
                width: 1
            })
        });

        var lineMiningStyle = new ol.style.Style({
            image: new ol.style.Circle({
                radius: 2,
                fill: new ol.style.Fill({
                    color: 'black'
                })
            })
        });

        sourceMiningLayer.addFeature(mineFeature);
        vectorMiningLayer.setStyle(lineMiningStyle);

        sourceMiningLayerLine.addFeature(mineFeatureLine);
        vectorMiningLayerLine.setStyle(lineMiningStyleLine);
    }

    var sliderBar = new Ext.Slider({
        width: 519,
        minValue: 0,
        maxValue: 100,
        plugins: tip,
        listeners: {
            drag: function (slider, e, opt) {
                var index = slider.getValue();
                setShipTracking(index);
            }
        }
    });

    var sliderWindow = new Ext.Window({
        title: 'Playback',
        layout: 'border',
        id: 'sliderWindow',
        y: 81,
        x: 84,
        width: 536,
        height: 135,
        resizeable: false,
        closeAction: 'hide',
        renderTo: 'mapPanel',
        items: new Ext.Container({
            region: 'center',
            items: sliderBar
        }),
        listeners: {
            close: function () {
                sourceTracking.clear();
                sourceMiningLayer.clear();
                sourceMiningLayerLine.clear();
                sourceLadderTracking.clear();
            }
        },
        dockedItems: [
            {
                dock: 'bottom',
                xtype: 'toolbar',
                id: 'playBackBottomToolbar',
                items: [
                    {
                        id: 'playback_date',
                        disabled: true,
                        xtype: 'tbtext',
                        text: 'Date:',
                        width: 100
                    },
                    '->',
                    {
                        id: 'loadButton',
                        iconCls: 'icon_playload',
                        cls: 'loadPlay',
                        tooltip: 'load',
                        handler: loadSlider,
                        disabled: true
                    },
                    {
                        id: 'playButton',
                        iconCls: 'icon_playplay', // icons can also be specified inline
                        cls: 'sliderPlay',
                        tooltip: 'play',
                        handler: playSlider,
                        disabled: true
                    }, {
                        id: 'pauseButton',
                        iconCls: 'icon_playpause', // icons can also be specified inline
                        cls: 'sliderPause',
                        tooltip: 'pause',
                        handler: pauseSlider,
                        disabled: true
                    }, {
                        id: 'stopButton',
                        iconCls: 'icon_playstop', // icons can also be specified inline
                        cls: 'sliderStop',
                        tooltip: 'stop',
                        handler: stopSlider,
                        disabled: true
                    }, {
                        id: "ffwdButton",
                        iconCls: 'icon_playforward', // icons can also be specified inline
                        cls: 'sliderFastForward',
                        tooltip: 'Fast Forward',
                        handler: ffwdSlider,
                        text: "1x",
                        disabled: true
                    },
                    {
                        id: "bfwdButton",
                        iconCls: 'icon_playrewind', // icons can also be specified inline
                        cls: 'sliderRewind',
                        tooltip: 'Rewind',
                        handler: bfwdSlider,
                        text: "1x",
                        disabled: true
                    }]
            },
            {
                dock: 'top',
                xtype: 'toolbar',
                id: 'playBackTopToolbar',
                items: [
                    {
                        xtype: 'combobox',
                        fieldLabel: '',
                        width: 140,
                        name: 'comboboxPlayback',
                        id: 'comboboxPlayback',
                        allowBlank: false,
                        emptyText: 'Select your ship',
                        displayField: 'value',
                        valueField: 'key',
                        store: shipStore,
                        listeners: {
                            validitychange: function () {
                                if (Ext.getCmp("comboboxPlayback").rawValue !== '') {
                                    Ext.getCmp("startDate").setDisabled(false);
                                    Ext.getCmp("endDate").setDisabled(false);
                                } else {
                                    Ext.getCmp("startDate").setDisabled(true);
                                    Ext.getCmp("endDate").setDisabled(true);
                                }
                            }
                        }

                    },
                    {
                        xtype: 'datetimefield',
                        id: 'startDate',
                        name: 'startdate',
                        format: 'd/m/Y',
                        emptyText: 'Select start date...',
                        width: 150,
                        allowBlank: false,
                        disabled: true,
                        listeners: {
                            validitychange: function () {
                                if (this.isValid() && Ext.getCmp("endDate").isValid()) {
                                    Ext.getCmp("loadButton").setDisabled(false);
                                    Ext.getCmp("playButton").setDisabled(false);
                                    Ext.getCmp("pauseButton").setDisabled(false);
                                    Ext.getCmp("stopButton").setDisabled(false);
                                    Ext.getCmp("ffwdButton").setDisabled(false);
                                    Ext.getCmp("bfwdButton").setDisabled(false);
                                } else {
                                    Ext.getCmp("loadButton").setDisabled(true);
                                    Ext.getCmp("playButton").setDisabled(true);
                                    Ext.getCmp("pauseButton").setDisabled(true);
                                    Ext.getCmp("stopButton").setDisabled(true);
                                    Ext.getCmp("ffwdButton").setDisabled(true);
                                    Ext.getCmp("bfwdButton").setDisabled(true);
                                }
                            }
                        }
                    },
                    {
                        xtype: 'datetimefield',
                        id: 'endDate',
                        name: 'enddate',
                        format: 'd/m/Y',
                        emptyText: 'Select end date...',
                        width: 150,
                        disabled: true,
                        allowBlank: false,
                        listeners: {
                            validitychange: function () {
                                if (this.isValid() && Ext.getCmp("startDate").isValid()) {
                                    Ext.getCmp("loadButton").setDisabled(false);
                                    Ext.getCmp("playButton").setDisabled(false);
                                    Ext.getCmp("pauseButton").setDisabled(false);
                                    Ext.getCmp("stopButton").setDisabled(false);
                                    Ext.getCmp("ffwdButton").setDisabled(false);
                                    Ext.getCmp("bfwdButton").setDisabled(false);
                                } else {
                                    Ext.getCmp("loadButton").setDisabled(true);
                                    Ext.getCmp("playButton").setDisabled(true);
                                    Ext.getCmp("pauseButton").setDisabled(true);
                                    Ext.getCmp("stopButton").setDisabled(true);
                                    Ext.getCmp("ffwdButton").setDisabled(true);
                                    Ext.getCmp("bfwdButton").setDisabled(true);
                                }
                            }
                        }

                    }
                ]
            }]
    });

    var sliderInterval;
    var isLoop = false;
    var sliderMaxValue = 100;

    function stopSlider() {

        clearInterval(sliderInterval);
        sliderBar.setValue(0);
        var sliderSpeed = 1;
        Ext.getCmp('ffwdButton').setText(sliderSpeed + "x");
        Ext.getCmp('bfwdButton').setText(sliderSpeed + "x");
        sourceMiningLayer.clear();
        sourceMiningLayerLine.clear();
    }

    function pauseSlider() {
        clearInterval(sliderInterval);
    }

    function playSlider() {
        if (playBack.length > 0) {
            clearInterval(sliderInterval);
            sliderSpeed = 1;
            Ext.getCmp('ffwdButton').setText(sliderSpeed + "x");
            Ext.getCmp('bfwdButton').setText(sliderSpeed + "x");
            sliderInterval = setInterval(function () {
                if (sliderBar.getValue() < sliderMaxValue) {
                    var index = sliderBar.getValue() + sliderSpeed;
                    if (index > sliderMaxValue) {
                        sliderBar.setValue(sliderMaxValue);
                        setShipTracking(sliderMaxValue);
                    } else {
                        sliderBar.setValue(index);
                        setShipTracking(index);
                    }
                    ;
                } else {
                    if (isLoop) {
                        sliderBar.setValue(0);
                    } else {
                        clearInterval(sliderInterval);
                    }
                }
            }, 200);
        } else {
            Ext.Msg.alert("Playback Message", "Please load the data first before play");
        }

    }

    function loadSlider() {
        shipname = Ext.getCmp("comboboxPlayback").rawValue;
        var idship = Ext.getCmp("comboboxPlayback").value;
        var startDate = Ext.getCmp("startDate").rawValue;
        var endDate = Ext.getCmp("endDate").rawValue;
        Ext.MessageBox.show({
            msg: 'Loading your data, please wait...',
            progressText: 'Loading...',
            buttons: Ext.Msg.CANCEL,
            fn: function (btn, text) {
                if (btn === 'cancel') {
                    Ext.Ajax.abort();
                    Ext.MessageBox.hide();
                };
            },
            width: 300,
            wait: true,
            waitConfig: {interval: 200}
        });

        sourceTracking.clear();
        sourceMiningLayer.clear();
        sourceMiningLayerLine.clear();
        sourceLadderTracking.clear();
        Ext.getCmp('ffwdButton').setText(sliderSpeed + "x");
        Ext.getCmp('bfwdButton').setText(sliderSpeed + "x");
        playBack = [];
        coordArray = [];
        i = 0;

        clearInterval(sliderInterval);
        Ext.Ajax.request({
            url: '/SIOPL/map/loadPlaybackByDate',
            method: 'POST',
            params: {
                idship: idship,
                startdate: startDate,
                enddate: endDate
            },
            success: function (record, response) {
                jsonString = record.responseText;
                var json = JSON.parse(jsonString);
                playBack.push(json);
                Ext.MessageBox.hide();
                sliderInterval = setInterval(function () {
                    if (shipname) {
                        if (startDate !== '' && endDate !== '') {
                            if (sliderBar.getValue() < sliderMaxValue) {
                                if (playBack[0].total <= 0) {
                                    Ext.Msg.alert("Playback Alert", "Sorry, there are no records in the date you choose. Please select in another range.");
                                    clearInterval(sliderInterval);
                                    sliderBar.setValue(0);
                                    playBack = [];
                                } else {
                                    var index = sliderBar.getValue();
                                    sliderBar.setValue(index);
                                    sliderBar.setMaxValue(playBack[0].total);
                                    sliderMaxValue = playBack[0].total - 1;
                                    var pointX = playBack[0].records[index].lon;
                                    var pointY = playBack[0].records[index].lat;
                                    var coord = ol.proj.transform([pointX, pointY], 'EPSG:4326', 'EPSG:900913');
                                    map.setView(new ol.View({center: coord, zoom: 18}));
                                    setShipTracking(index);
                                }
                            } else {
                                if (isLoop) {
                                    sliderBar.setValue(0);
                                    setShipTracking(0);
                                } else {
                                    clearInterval(sliderInterval);
                                }
                            }
                        } else {
                            Ext.Msg.alert('Warning', 'Please select start and end date before play');
                            clearInterval(sliderInterval);
                        }
                    } else {
                        Ext.Msg.alert('Warning', 'Please select ship before play');
                        clearInterval(sliderInterval);
                    }
                }, 1000);
            },
            failure: function () {
                Ext.MessageBox.hide();
                Ext.Msg.alert('Connection Timeout', 'Something error in your connection. Please try again.');
            }
        });
    }


    var sliderSpeed = 1;
    function ffwdSlider() {
        clearInterval(sliderInterval);
        switch (sliderSpeed) {
            case 1:
                sliderSpeed = 2;
                break;
            case 2:
                sliderSpeed = 4;
                break;
            case 4:
                sliderSpeed = 8;
                break;
            case 8:
                sliderSpeed = 16;
                break;
            case 16:
                sliderSpeed = 32;
                break;
            case 32:
                sliderSpeed = 64;
                break;
        }
        Ext.getCmp('ffwdButton').setText(sliderSpeed + "x");
        sliderInterval = setInterval(function () {
            if (sliderBar.getValue() < sliderMaxValue) {
                var index = sliderBar.getValue() + sliderSpeed;
                if (index > sliderMaxValue) {
                    sliderBar.setValue(sliderMaxValue);
                    setShipTracking(sliderMaxValue);
                } else {
                    sliderBar.setValue(index);
                    setShipTracking(index);
                }
                ;
            } else {
                if (isLoop) {
                    sliderBar.setValue(0);
                } else {
                    clearInterval(sliderInterval);
                }
            }
        }, 200);
    }

    var sliderSpeed = 1;
    function bfwdSlider() {
        clearInterval(sliderInterval);
        switch (sliderSpeed) {
            case 1:
                sliderSpeed = 2;
                break;
            case 2:
                sliderSpeed = 4;
                break;
            case 4:
                sliderSpeed = 8;
                break;
            case 8:
                sliderSpeed = 16;
                break;
            case 16:
                sliderSpeed = 32;
                break;
            case 32:
                sliderSpeed = 64;
                break;
        }
        Ext.getCmp('bfwdButton').setText("-" + sliderSpeed + "x");
        sliderInterval = setInterval(function () {
            if (sliderBar.getValue() < sliderMaxValue) {
                var index = sliderBar.getValue() - sliderSpeed;
                if (index <= 0) {
                    sliderBar.setValue(0);
                    setShipTracking(0);
                } else {
                    sliderBar.setValue(index);
                    setShipTracking(index);
                }
            } else {
                if (isLoop) {
                    sliderBar.setValue(0);
                } else {
                    clearInterval(sliderInterval);
                }
            }
        }, 200);
    }

    var tip = new Ext.slider.Tip({
        getText: function (thumb) {
            return String.format('<b>{0}</b>', sliderData[thumb.value].properties.time_stamp);
        }
    });
    Ext.getCmp("btn_playback").addListener("click", function () {
        sliderWindow.show();
    });

// returning to the initial value of forward button when it is reaching to the max
    Ext.getCmp("ffwdButton").addListener("click", function () {
        if (sliderSpeed >= 64) {
            sliderSpeed = 1;
        }
    });
// returning to the initial value of rewind button when it is reaching to the max
    Ext.getCmp("bfwdButton").addListener("click", function () {
        if (sliderSpeed >= 64) {
            sliderSpeed = 1;
        }
    });
}
