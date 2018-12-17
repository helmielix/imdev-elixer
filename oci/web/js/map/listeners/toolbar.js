/* global Ext, map, ol, pointerMoveHandler, draw, drawend, source */
var coordinate;
var coordTimah;
function setListeners_toolbar() {
    Ext.getCmp("btn_measureline").on("toggle", function () {
        if (this.pressed) {
            mapPointerEvent = map.on('pointermove', pointerMoveHandler);
            $(map.getViewport()).on('mouseout', function () {
                $(helpTooltipElement).addClass('hidden');
            });
            createMeasureTooltip();
            createHelpTooltip();
            addInteraction('LineString');
            map.addInteraction(draw);
            draw.on('drawstart', function (evt) {
                drawstart(evt);
            }, this);
            draw.on('drawend', drawend, this);
        } else {
            map.removeInteraction(draw);
            if (!Ext.getCmp("btn_measurearea").pressed) {
                map.un('pointermove', pointerMoveHandler);
                helpTooltipElement = null;
                // remove any tooltip class
                var tooltip = document.getElementsByClassName('tooltip tooltip-static');
                var tooltipHidden = document.getElementsByClassName('tooltip hidden');
                for (var i = 0; i < tooltip.length; i++) {
                    $('.tooltip.tooltip-static').remove();
                }
                for (var i = 0; i < tooltipHidden.length; i++) {
                    $('.tooltip.hidden').remove();
                }
                source.clear();
                $.each(map.getOverlays(), function (i, v) {
                    map.removeOverlay(v);
                });
            }
        }
    });
    Ext.getCmp("btn_measurearea").on("toggle", function () {
        if (this.pressed) {
            mapPointerEvent = map.on('pointermove', pointerMoveHandler);
            $(map.getViewport()).on('mouseout', function () {
                $(helpTooltipElement).addClass('hidden');
            });
            createMeasureTooltip();
            createHelpTooltip();
            addInteraction('Polygon');
            map.addInteraction(draw);
            draw.on('drawstart', function (evt) {
                drawstart(evt);
            }, this);
            draw.on('drawend', drawend, this);
        } else {
            map.removeInteraction(draw);
            if (!Ext.getCmp("btn_measureline").pressed) {
                map.un('pointermove', pointerMoveHandler);
                helpTooltipElement = null;
                // remove any tooltip class
                var tooltip = document.getElementsByClassName('tooltip tooltip-static');
                var tooltipHidden = document.getElementsByClassName('tooltip hidden');
                for (var i = 0; i < tooltip.length; i++) {
                    $('.tooltip.tooltip-static').remove();
                }
                for (var i = 0; i < tooltipHidden.length; i++) {
                    $('.tooltip.hidden').remove();
                }
                source.clear();
                $.each(map.getOverlays(), function (i, v) {
                    map.removeOverlay(v);
                });
            }
        }
    });
    Ext.getCmp("btn_zoomtoextent").on("click", function () {
        map.setView(new ol.View({
            center: ol.proj.fromLonLat([106, -2]),
            zoom: 9
        }));
    });

    Ext.getCmp("btn_zoomtoxy").on("toggle", function () {
        if (this.pressed) {
            Ext.getCmp("tf_gotoX").show();
            Ext.getCmp("tf_gotoY").show();
            Ext.getCmp("btn_zoomtoxyok").show();

            if (Ext.getCmp("tf_gotoY").isValid() && Ext.getCmp("tf_gotoX").isValid()) {
                Ext.getCmp("btn_zoomtoxyok").setDisabled(false);
            } else {
                Ext.getCmp("btn_zoomtoxyok").setDisabled(true);
            }
        } else {
            Ext.getCmp("tf_gotoX").hide();
            Ext.getCmp("tf_gotoY").hide();
            Ext.getCmp("btn_zoomtoxyok").hide();

        }
    });

    Ext.getCmp("btn_zoomtoxyok").on("click", function () {
        var newZoomLevel = map.getView().getZoom();
        var positionX = Ext.getCmp("tf_gotoX").value;
        var positionY = Ext.getCmp("tf_gotoY").value;
        if (positionX > 500000 & positionY > 9000000) {
            var coord = new ol.proj.transform([positionX, positionY], 'EPSG:32748', 'EPSG:900913');
            map.setView(new ol.View({
                center: coord,
                zoom: newZoomLevel
            }));
        } else {
            map.setView(new ol.View({
                center: ol.proj.fromLonLat([positionX * 1, positionY * 1]),
                zoom: newZoomLevel
            }));
        }
    });
    
    Ext.getCmp("btn_marking").on("toggle", function (evt, record) {
        if (this.pressed) {
            Ext.getCmp('formAlert').getForm().reset();

            if(this.pressed) {
                // change pointer cursor when mouse move here
                $('html,body').css('cursor','crosshair');
            } else {
                $('html,body').css('cursor','default');
            }

            unlistenMarking = map.on('click', function (evt) {
                coordinate = evt.coordinate;
                coordTimah = ol.proj.transform(coordinate, 'EPSG:3857', 'EPSG:32748');

                Ext.getCmp('inputMarking').show();
                map.unByKey(unlistenMarking);
                $('html,body').css('cursor','default');
            });
        } else {
            map.unByKey(unlistenMarking);
            $('html,body').css('cursor','default');
        }

    });

    Ext.getCmp("logout").addListener("click", function () {
        Ext.MessageBox.show({
            title: 'Logout Confirmation',
            msg: 'Are you sure you want to logout?',
            buttons: Ext.MessageBox.YESNO,
            icon: 'icon_logout',
            fn: function (btn) {
                if (btn === 'yes') {
                    Ext.Ajax.request({
                        url: '/SIOPL/Logout.htm',
                        method: 'POST',
                        success: function () {
                            window.location = window.location.origin + '/SIOPL/Index';
                        }
                    });
                }
            }
        });
    });
}
