/* 
 * This project was created by
 * Rizky Firmansyah
 * PT Elixer Reka Digita
 * ----------
 * For inquiry do not hesitate to contact us at info@elixer.co.id
 * or please visit our website elixer.co.id
 */

/* global Ext, workareastore */

function constructStoreShipSearch() {
    
    var store = new Ext.data.JsonStore({
        remoteSort: false,
        pageSize: 25,
        leadingBufferZone: 1000,
        buffered: true,
        autoLoad: true,
        storeId: 'shipSearchStore',
        proxy: {
            type: 'ajax',
            url: '/SIOPL/map/getshipname.htm',
            reader: {
                type: 'json',
                root: 'records',
                idProperty: 'id'
            }
        },
        sorters: [{
                property: 'idship',
                direction: 'ASC'
            }],
        fields: [
            {name: 'idship.id'},
            {name: 'shipname'},
            {name: 'date', type: 'date'},
            {name: 'gid'},
            {name: 'x'},
            {name: 'y'},
            {name: 'lon'},
            {name: 'lat'},
            {name: 'heading'},
            {name: 'pitch'},
            {name: 'roll'},
            {name: 'rad_per_minute'},
            {name: 'round_delta_hour'},
            {name: 'ship_speed'},
            {name: 'status'},
            {name: 'working_status'},
            {name: 'ladder_pitch'},
            {name: 'ladder_roll'},
            {name: 'cutter_x'},
            {name: 'cutter_y'},
            {name: 'pressure_cutter'}
        ]
    });

    store.on('load', function (records) {
        if (records.data.items.length != 0) {
            Ext.getCmp('searchResultWindow').add(construct_grid_shipsearch());
        }
        ;
    });

    return store;

}

