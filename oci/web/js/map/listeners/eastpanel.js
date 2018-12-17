/* global Ext */

function setListeners_eastpanel() {
    Ext.getCmp("eastpanel").on("expand", function () {
        setTimeout(function () {
            map.updateSize();
            Ext.getCmp("searchResultWindow").alignTo('mapPanel', 'tr-tr', [-413, 78]);
        }, 100);
    });
    Ext.getCmp("eastpanel").on("collapse", function () {
        setTimeout(function () {
            map.updateSize();
            Ext.getCmp("searchResultWindow").alignTo('mapPanel', 'tr-tr', [-51, 78]);
        }, 100);
    });
}