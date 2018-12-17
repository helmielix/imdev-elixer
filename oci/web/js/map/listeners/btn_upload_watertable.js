/* 
 * This project was created by
 * Rizky Firmansyah
 * PT Elixer Reka Digita
 * ----------
 * For inquiry do not hesitate to contact us at info@elixer.co.id
 * or please visit our website elixer.co.id
 */

function setListeners_upload_watertable() {

    var locationStore = Ext.create('Ext.data.Store', {
        fields: ['key', 'value'],
        data: [
            {"key": "PK", "value": "Penyusuk"},
            {"key": "TB", "value": "Toboali"},
            {"key": "MT", "value": "Muntok"},
            {"key": "SL", "value": "Sungai Liat"},
            {"key": "BR", "value": "Batu Rusa"},
            {"key": "PB", "value": "Pulau Bangka"},
            {"key": "TK", "value": "Teluk Kelabat"},
            {"key": "AT", "value": "Alang Tiga"},
            {"key": "CB", "value": "Cebia"},
            {"key": "MG", "value": "Manggar"},
            {"key": "TP", "value": "Tanjung Pandan"},
            {"key": "DS", "value": "Dabo Singkep"},
            {"key": "KP", "value": "Kenipaan"}
        ]
    });

    var waterTableForm = new Ext.FormPanel({
        id: 'uploadTabelAir',
        margin: '5 5 5 5',
        frame: false,
        defaults: {
            width: 350
        },
        items: [
            {
                xtype: 'combobox',
                fieldLabel: 'Location',
                name: 'comboboxtabelair',
                id: 'inputTabelAir',
                emptyText: 'Select your location...',
                msgTarget: 'side',
                allowBlank: false,
                buttonText: '',
                store: locationStore,
                displayField: 'value',
                valueField: 'key'
            }, {
                xtype: 'filefield',
                fieldLabel: 'Water Table File',
                name: 'fileWaterTable',
                emptyText: 'Select your Water Table file...',
                msgTarget: 'side',
                allowBlank: false,
                buttonText: '',
                buttonConfig: {
                    iconCls: 'icon-upload'
                }
            }
        ],
        buttons: [
            {
                text: 'Upload',
                frame: false,
                handler: function () {
                    namaTabelAir = Ext.getCmp('inputTabelAir').rawValue;
                    waterTableForm = Ext.getCmp('uploadTabelAir').getForm();
                    if (waterTableForm.isValid()) {
                        waterTableForm.submit({
                            url: '/SIOPL/tabelair/saveTabelAir',
                            method: 'POST',
                            waitMsg: 'Please wait...',
                            params: {
                                location: namaTabelAir
                            },
                            success: function (form, action) {
                                Ext.Msg.alert('Upload Success', 'Your file at ' + namaTabelAir + ' has been uploaded.');
                            },
                            failure: function (form, action) {
                                Ext.Msg.alert('Upload Failure', 'Sorry, there must be error in your connection. Please try again.');
                            }
                        });
                    } else {
                        Ext.Msg.alert('Warning', 'Please input your file');
                    }
                }
            }
        ]
    });

    var tabelAir = new Ext.Window({
        title: 'Upload File',
        defaults: {
            width: '95%'
        },
        margin: '5 5 5 5',
        autoHeight: true,
        closeAction: 'hide',
        frame: false,
        items: waterTableForm
    });

    Ext.getCmp("waterTableWindow").addDocked({
        xtype: 'toolbar',
        dock: 'bottom',
        ui: 'footer',
        layout: {
            pack: 'right'
        },
        items: ['->', {
                id: 'tabel_air',
                text: 'Upload',
                enableToggle: false,
                iconCls: 'icon-upload',
                handler: function () {
                    tabelAir.show();
                }
            }]
    });

}
