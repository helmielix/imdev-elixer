/* global Ext, shipSearchStore, miningSearchStore, workAreaStore, map, ol */

function setListeners_zoom() {
    var Zoom =[];
    var Extent =[];
    var IndexArray = 0; 
    var IndexArrayNow = 0;   
    var action = null;
    var extentLevel =[];
    var zoomLevel =[];
    
    extentLevel[IndexArray] = map.getView().getCenter();
    zoomLevel[IndexArray] = map.getView().getZoom();

    map.on('moveend', checknewzoom);
    function checknewzoom(evt)
    {
        if (action == null ){
            IndexArray = IndexArray + 1;
            IndexArrayNow = IndexArrayNow + 1;
            Zoom[IndexArray] = map.getView().getZoom();
            Extent[IndexArray] = map.getView().getCenter();
            Ext.getCmp("btn_prevzoom").setDisabled(true);
            Ext.getCmp("btn_nextzoom").setDisabled(true);
        }
        else {
            action = null;   
        }

        if (IndexArrayNow <= 1) {
            Ext.getCmp("btn_prevzoom").setDisabled(true);
        } else {
            Ext.getCmp("btn_prevzoom").setDisabled(false);
        }
        
        if (IndexArrayNow >= IndexArray) {
            Ext.getCmp("btn_nextzoom").setDisabled(true);
        } else {
            Ext.getCmp("btn_nextzoom").setDisabled(false);
        }
        
    }

    Ext.getCmp("btn_nextzoom").on("click", function () {     
        IndexArrayNow = IndexArrayNow + 1;   
        map.setView(new ol.View({
            center: Extent[IndexArrayNow],
            zoom:Zoom[IndexArrayNow]
        }));
        action = "next"; 
            
    });
    
    Ext.getCmp("btn_prevzoom").on("click", function () {
        IndexArrayNow = IndexArrayNow - 1;
        map.setView(new ol.View({
            center: Extent[IndexArrayNow],
            zoom: Zoom[IndexArrayNow]
        }));
        action = "back";
    });

    Ext.getCmp("eastpanel").on("expand", function () {
        action = "expand";
    });
    Ext.getCmp("eastpanel").on("collapse", function () {
        action = "collapse";
    });
    Ext.getCmp("layerpanel").on("expand", function () {
        action = "expand";
    });
    Ext.getCmp("layerpanel").on("collapse", function () {
        action = "collapse";
    });
    Ext.getCmp("shipGrid").on("collapse", function () {
        action = "collapse";
    });
}