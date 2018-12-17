/* global Ext, workAreaStore, markingStore */

function construct_grid_markingsearch() {

    function idRenderer(val) {
        var id = val.substring(8,val.length);
        return id;
    }

    var grid = Ext.create("components.gridSearch", {
        title: 'Marking',
        closable: false,
        closeAction: 'hide',
        store: markingStore,
        id: 'markingSearchGrid',
        columns: [
            {text: 'Mark ID', width: 60, dataIndex: 'id', renderer: idRenderer},
            {text: 'Description', flex: 1, dataIndex: 'properties.description'},
            {text: 'Longitude', flex: 1, dataIndex: 'properties.lon', hidden: true},
            {text: 'Latitude', flex: 1, dataIndex: 'properties.lat', hidden: true}
        ],
        listeners: {
            'itemdblclick': function (dv, record) {
                var lon = record.data["properties.lon"];
                var lat = record.data["properties.lat"];

                var coord = ol.proj.transform([lon, lat], 'EPSG:32748', 'EPSG:900913');
                map.setView(new ol.View({center: coord, zoom: 17}));
            }
        }
    });

    return grid;
}
