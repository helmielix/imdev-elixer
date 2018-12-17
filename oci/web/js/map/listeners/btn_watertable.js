/* 
 * This project was created by
 * Rizky Firmansyah
 * PT Elixer Reka Digita
 * ----------
 * For inquiry do not hesitate to contact us at info@elixer.co.id
 * or please visit our website elixer.co.id
 */


/* global Ext */

function setListeners_watertable() {

    var locationStore = Ext.create('Ext.data.Store', {
        fields: ['key', 'value'],
        data: [
            {"key": "PK", "value": "Penyusuk"},
            {"key": "TB", "value": "Toboali"},
            {"key": "MT", "value": "Muntok"},
            {"key": "SL", "value": "Sungai Liat"},
            {"key": "BR", "value": "Batu Rusa"},
            {"key": "PB", "value": "Pulau Nangka"},
            {"key": "TK", "value": "Teluk Kelabat"},
            {"key": "AT", "value": "Alang Tiga"},
            {"key": "CB", "value": "Cebia"},
            {"key": "MG", "value": "Manggar"},
            {"key": "TP", "value": "Tanjung Pandan"},
            {"key": "DS", "value": "Dabo Singkep"},
            {"key": "KP", "value": "Kenipaan"}
        ]
    });
    
    var waterTableStore = new Ext.data.JsonStore({
        remoteSort: false,
        autoLoad: false,
        proxy: {
            type: 'ajax',
            url: '/SIOPL/tabelair/loadbynow.htm',
            reader: {
                type: 'json',
                root: 'records',
                idProperty: 'id'
            },
            simpleSortMode: true
        },
        sorters: [{
                property: 'id',
                direction: 'ASC'
            }],
        fields: [
            {name: 'id'},
            {name: 'date'},
            {name: 'location'},
            {name: 'pasut'},
            {name: 'hour'},
            {name: 'upload_by'},
            {name: 'upload_date'}
        ]
    });
    
    var waterTableGrid = Ext.create('Ext.grid.Panel', {
        loadMask: true,
        columnLines: true,
        store: waterTableStore,
        autoLoad: false,
        width: 270,
        height: 330,
        autoScroll: true,
        viewConfig: {
            stripeRows: true
        },
        columns: [{
                header: 'Hour',
                dataIndex: 'hour',
                flex: 1,
                align: 'center',
                renderer: Ext.util.Format.numberRenderer('0')
            }, {
                header: 'Pasut',
                dataIndex: 'pasut',
                flex: 1,
                align: 'center',
                renderer: Ext.util.Format.numberRenderer('0.00000000')
            }]
    });
    
    var waterTable = new Ext.Window({
        title: 'Water Table',
        renderTo: 'mapPanel',
        id: 'waterTableWindow',
        closeAction: 'hide',
        items: [waterTableGrid],
        dockedItems: [
            {
                xtype: 'toolbar',
                items: [{
                        itemId: 'locationField',
                        xtype: 'combobox',
                        fieldLabel: '',
                        name: 'displaytabelair',
                        id: 'inputLocation',
                        emptyText: 'Select your location...',
                        msgTarget: 'side',
                        allowBlank: false,
                        buttonText: '',
                        store: locationStore,
                        queryMode: 'remote',
                        displayField: 'value',
                        valueField: 'value'
                    }]
            },
            {
                xtype: 'toolbar',
                items: [{
                        xtype: 'datefield',
                        name: 'to_date',
                        id: 'inputDate',
                        value: new Date()
                    }]
            }
        ]
    });
    
    var selectEvent = function (record) {
        var location = Ext.getCmp('inputLocation').value;
        var date = Ext.getCmp('inputDate').value;
        waterTableStore.getProxy().extraParams.location = location;
        waterTableStore.getProxy().extraParams.date = date;
        waterTableStore.load();
    };

    var combobox = waterTable.down('combobox');
    combobox.on('select', selectEvent, this);
    
    var datefield = waterTable.down('datefield');
    datefield.on('select', selectEvent, this);
    
    Ext.getCmp("window_water_table").on("click", function () {
        Ext.getCmp("waterTableWindow").show();
        Ext.getCmp("waterTableWindow").alignTo('mapPanel', 'tr-tr', [-810, 80]);
    });
}