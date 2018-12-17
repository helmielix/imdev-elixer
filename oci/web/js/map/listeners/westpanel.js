/* global Ext */

function setListeners_westpanel() {
    Ext.getCmp("layerpanel").on("expand", function () {
        setTimeout(function () {
            map.updateSize();
            Ext.getCmp("sliderWindow").alignTo('mapPanel', 'tr-tr', [-1110, 80]);
        }, 100);
    });
    Ext.getCmp("layerpanel").on("collapse", function () {
        setTimeout(function () {
            map.updateSize();
            Ext.getCmp("sliderWindow").alignTo('mapPanel', 'tr-tr', [-1300, 80]);
        }, 100);
    });
}