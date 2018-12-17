/* global Ext */

function setListeners_quick_search() {
    function quickSearch() {
        if (Ext.getCmp("miningSearchGrid"))
            Ext.getCmp('searchResultWindow').remove(Ext.getCmp("miningSearchGrid"));
        if (Ext.getCmp("markingSearchGrid"))
            Ext.getCmp('searchResultWindow').remove(Ext.getCmp("markingSearchGrid"));

        var searchKey = Ext.getCmp("tf_quicksearch").value;

        cqlFilter = 'strToLowerCase(description) like \'%' + searchKey + '%\'';
        markingStore.getProxy().extraParams.cql_filter = cqlFilter;
        markingStore.load();

        cqlFilter = 'strToLowerCase(hole) like \'%' + searchKey + '%\'';
        miningStore.getProxy().extraParams.cql_filter = cqlFilter;
        miningStore.load();

        Ext.getCmp("searchResultWindow").show();
        if (Ext.getCmp("eastpanel").collapsed) {
            Ext.getCmp("searchResultWindow").alignTo('mapPanel', 'tr-tr', [-51, 78]);
        } else {
            Ext.getCmp("searchResultWindow").alignTo('mapPanel', 'tr-tr', [-413, 78]);
        }
    }

    Ext.getCmp("tf_quicksearch").on('keypress', function (obj, e) {
        if (e.getKey() === e.ENTER) {
            quickSearch();
        }
        ;
    });

    Ext.getCmp("btn_quicksearchok").on('click', function (e) {
        quickSearch();
    });
}