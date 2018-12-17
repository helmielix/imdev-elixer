/* 
 * This project was created by
 * PT Elixer Reka Digita
 * ----------
 * For inquiry do not hesitate to contact us at info@elixer.co.id
 * or please visit our website elixer.co.id
 */
// Declaring Global Variable
var map;

function getCSRFToken() {
	var metas = document.getElementsByTagName('meta');

	for (var i = 0; i < metas.length; i++) {
		if (metas[i].getAttribute("name") == "csrf-token") {
			return metas[i].getAttribute("content");
		}
	}

	return "";
}

// Init Ext
Ext.application({
    // Unique ID of Application
    name: 'FOROGIS',
    // Launch App
    launch: function() {
	
        // Declare functions
        // Declare checkValidationZoomtoxy for checking textfield input. If all field isValid, then enable button.
        function checkValidationZoomtoxy() {
            if (Ext.getCmp("tf_gotoX").isValid() && Ext.getCmp("tf_gotoY").isValid()) {
                Ext.getCmp("btn_zoomtoxyok").setDisabled(false);
            } else {
                Ext.getCmp("btn_zoomtoxyok").setDisabled(true);
            }
        }


		var surveyStore = Ext.create('Ext.data.JsonStore', {
			autoLoad: true,
			fields: [
				'id',
				'location',
				'nama_area',
				'hari_survey',
				'tanggal_survey',
				'owner_type',
				'city',
				'kelurahan',
				'kecamatan',
				'id_iom_city',
				'regional',
				'coordinat_x',
				'coordinat_y',
				'home_pass',
				'jenis_properti_area',
				'klasifikasi_jenis_rumah',
				'rata_rata_okupansi',
				'mayoritas_penghuni_memiliki',
				'metode_pembangunan',
				'akses_penjualan',
				'kompetitor',
				'pengguna_dth',
				'pic',
				'note',
				'home_pass_potential',
				'recommendation'
			],
			proxy: {
				type: 'ajax',
				url: '/mnc_ca/backend/web/index.php?r=survey/get-all-survey',
				reader: {
					type: 'json',
					root: 'data',
					idProperty: 'id'
				}
			},
		});
		
        // Create Map Container
        var mainPanel = Ext.create('Ext.panel.Panel', {
            id: 'mainPanel',
            xtype: 'panel',
            layout: 'fit',
            region: 'center',
            items: [{
                title: "Map",
                html: "<div id='map' style='width:100%; height:100%;'></div>"
            }]
        });

        // Create West Panel for Layers and Basemap selector
        var westPanel = Ext.create('Ext.panel.Panel', {
            id: "westPanel",
            title: "Map Config",
            xtype: "panel",
            layout: 'border',
            region: 'west',
            width: 230,
            collapsed: true,
            collapsible: true,
            items: [{
                    title: 'Layer',
                    id: 'layerpanel',
                    xtype: 'tabpanel',
                    layout: 'fit',
                    autoScroll: true,
                    region: 'center',
                    header: false,
                    bodyStyle: 'opacity:0.9;',
                    split: true,
                    region: 'center',
                    items: [
                        // Create Layer Buttons Container. Listeners Separated on Listeners/layers.js
                        {
                            title: 'Layers',
                            layout: 'column',
                            autoScroll: true,
                            items: [
                                Ext.create("components.buttonLayer", {
                                    id: 'layer_basemap',
                                    tooltip: 'Basemap',
                                    height: 85,
                                    width: 85,
                                    iconCls: 'layer_hybrid',
                                    enableToggle: true,
                                    pressed: true
                                })
                            ]
                        },
                        // Create Basemap Buttons Container. Listeners separated on Listeners/basemaps.js
                        {
                            title: 'Basemaps',
                            layout: 'column',
                            autoScroll: true,
                            items: [
                                Ext.create("components.buttonLayer", {
                                    id: 'basemapGoogleStreet',
                                    tooltip: 'Google Street Map',
                                    iconCls: 'basemapGoogleStreet',
                                    pressed: true,
                                    toggleGroup: 'basemapButtons'
                                }),
                                Ext.create("components.buttonLayer", {
                                    id: 'basemapGoogleHybrid',
                                    tooltip: 'Google Hybrid',
                                    iconCls: 'basemapGoogleHybrid',
                                    toggleGroup: 'basemapButtons'
                                }),
                                Ext.create("components.buttonLayer", {
                                    id: 'basemapGoogleSatellite',
                                    tooltip: 'Google Satellite',
                                    iconCls: 'basemapGoogleSatellite',
                                    toggleGroup: 'basemapButtons'
                                }),
                                Ext.create("components.buttonLayer", {
                                    id: 'basemapGoogleTerrain',
                                    tooltip: 'Google Terrain',
                                    iconCls: 'basemapGoogleTerrain',
                                    toggleGroup: 'basemapButtons'
                                })

                            ]
                        },
                        // Create Legend Container

                    ]
                },
                {
                    title: 'Legend',
                    layout: 'fit',
                    region: 'south',
                    autoScroll: true,
                    split: true,
                    items: [{
                        autoScroll: true,
                        html: '',
                    }]

                }
            ]
        });

        // Create northPanel for Actions Container
        var northPanel = Ext.create('Ext.panel.Panel', {
            xtype: 'panel',
            layout: 'fit',
            region: 'north',
            header: false,
            dockedItems: [{
                xtype: 'toolbar',
                dock: 'top',
                id: 'mapToolbar',
                items: [{
                        xtype: 'box',
                        autoEl: {
                            tag: 'img',
                            src: '/mnc_ca/backend/web/images/logo_mnc.png',
                            height: 32
                        },
                    }, {
                        xtype: 'box',
                        autoEl: {
                            tag: 'div',
                            height: 32
                        },
                        html: '<span style="color:#183883;font-weight: 900; font-size: 16px; top: -13px; position: absolute; width: 89px"> <b>FORO GIS</b> </span>',
                        width: 78
                    },
                    '-',
                    // Create Information Button. Listeners Separated on Listeners/btn_info.js
                    {
                        id: 'btn_info',
                        tooltip: 'Get Object Information',
                        iconCls: 'icon_info',
                        enableToggle: true,
                        toggleGroup: 'toolbarAction'
                    },
                    // Create Zoom to Extent Button. Listeners Separated on Listeners/zoomtoextent.js
                    {
                        id: 'btn_zoomtoextent',
                        tooltip: 'Zoom To Extent',
                        iconCls: 'icon_zoomtoextent'
                    }, , '-',
                    // Create Zoom to XY Button. Listeners Separated on Listeners/zoomtoxy.js
                    {
                        id: 'btn_zoomtoxy',
                        tooltip: 'Zoom To XY',
                        iconCls: 'icon_zoomtoxy',
                        enableToggle: true,
                        toggleGroup: 'toolbarAction'
                    },
                    // Create Zoom to XY Textfield. Listeners Separated on Listeners/zoomtoxy.js
                    {
                        id: 'tf_gotoX',
                        xtype: 'textfield',
                        name: 'gotoY',
                        emptyText: 'Long',
                        width: 60,
                        hidden: true,
                        allowBlank: false,
                        listeners: {
                            // Check textfield validity. If all field isValid, then btn_zoomtoxyok is enable.
                            validitychange: function() {
                                checkValidationZoomtoxy();
                            }
                        }
                    },
                    {
                        id: 'tf_gotoY',
                        xtype: 'textfield',
                        name: 'gotoY',
                        emptyText: 'Lat',
                        width: 60,
                        hidden: true,
                        allowBlank: false,
                        listeners: {
                            // Check textfield validity. If all field isValid, then btn_zoomtoxyok is enable.
                            validitychange: function() {
                                checkValidationZoomtoxy();
                            },
                            'render': function(cmp) {
                                cmp.getEl().on('keypress', function(e) {
                                    if (e.getKey() === e.ENTER) {
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
                                    }
                                });
                            }
                        }
                    },
                    {
                        id: 'btn_zoomtoxyok',
                        tooltip: 'Confirm Goto XY',
                        iconCls: 'icon_zoomtoxyok',
                        hidden: true,
                        disabled: true
                    },
                    // TODO: debug prevzoom and nextzoom listeners
                    /*
                                                '-',
                                                {
                                                    id: 'btn_prevzoom',
                                                    tooltip: 'Prev Zoom',
                                                    iconCls: 'icon_zoomprev',
                                                    disabled: true
                                                }, {
                                                    id: 'btn_nextzoom',
                                                    tooltip: 'Next Zoom',
                                                    iconCls: 'icon_zoomnext',
                                                    disabled: true
                                                },
												*/
                    '-',
                    {
                        tooltip: 'Line Measurement',
                        iconCls: 'icon_measureline',
                        enableToggle: true,
                        toggleGroup: 'toolbarAction',
                        id: 'btn_measureline'
                    },
                    {
                        tooltip: 'Area Measurement',
                        iconCls: 'icon_measurearea',
                        enableToggle: true,
                        toggleGroup: 'toolbarAction',
                        id: 'btn_measurearea'
                    },

                    '-',
                    '->',
                    {
                        xtype: 'textfield',
                        id: 'tf_quicksearch',
                        emptyText: 'Quick Search',
                        enableKeyEvents: true
                    },
                    {
                        id: 'btn_quicksearchok',
                        tooltip: 'Confirm Search',
                        iconCls: 'icon_searchok'
                    },
                    {
                        id: 'logout',
                        tooltip: 'Logout...',
                        iconCls: 'icon_logout'
                    }
                ]
            }]
        });
        // Create Information Panel
        var eastPanel = Ext.create('Ext.panel.Panel', {

            id: "eastpanel",
            xtype: "panel",
            title: "Information",
            layout: "fit",
            region: "east",
            width: 400,
            split: true,
            collapsible: true,
            collapsed: true,
            autoScroll: true,
            items: [{
                xtype: 'tabpanel',
                items: [{
                    xtype: 'panel',
                    layout: 'border',
					title: 'Potensial CA',
                    items: [{
                            xtype: 'gridpanel',
							id: 'surveyGridPanel',
                            region: 'north',
                            split: true,
                            flex: 1,
                            columns: [{
                                    header: 'Kota',
                                    dataIndex: 'city'
                                },
                                {
                                    header: 'Kecamatan',
                                    dataIndex: 'kecamatan'
                                },
                                {
                                    header: 'Kelurahan',
                                    dataIndex: 'kelurahan'
                                },
                                {
                                    header: 'Nama Area',
                                    dataIndex: 'nama_area'
                                },
                                {
                                    header: 'Tanggal Survey',
                                    dataIndex: 'tanggal_survey'
                                },
                                {
                                    header: 'Prioritas',
                                    dataIndex: 'prioritas',
                                    hidden: true
                                }
                            ],
							store: surveyStore,
                            tbar: [{
                                    text: "Buat Baru",
                                    iconCls: 'icon-create',
                                    handler: function() {
                                        Ext.getCmp('surveyDetailPanel').getLayout().setActiveItem(1);
                                    }
                                },
                                {
                                    text: "Perbaharui",
                                    iconCls: 'icon-update',
                                    handler: function() {
										var grid = Ext.getCmp('surveyGridPanel');
										console.log(grid.getSelectionModel());
                                        var record = grid.getSelectionModel().getSelection()[0];
										Ext.getCmp('updateSurveyForm').loadRecord(record);
                                        Ext.getCmp('surveyDetailPanel').getLayout().setActiveItem(2);
                                    }
                                },
								{
                                    text: "Buat Polygon",
                                    iconCls: 'icon-drawpolygon',
									id: 'createPolygonButton'
                                },
                                {
                                    text: "Hapus",
                                    iconCls: 'icon-delete',
                                    handler: function() {
                                        //var record = grid.getSelectionModel().getSelection()[0];
                                        //TODO: create delete feature
										alert('Sedang dalam proses pembuatan');
                                    }
                                }
                            ],
							listeners : {
								itemdblclick: function(dv, record, item, index, e) {
									Ext.getCmp('surveyDetailPanel').getLayout().setActiveItem(0);
									Ext.getCmp('detailSurveyForm').loadRecord(record);
								}
							}
                        },
                        {
                            xtype: 'panel',
                            id: 'surveyDetailPanel',
                            region: 'center',
                            flex: 2,
                            layout: 'card',
                            items: [
								{
                                    xtype: 'form',
                                    title: 'Detail Survey',
									id: 'detailSurveyForm',
                                    autoScroll: true,
                                    items: [{
                                            xtype: 'hidden',
                                            name: '_csrf',
                                            value: getCSRFToken()
                                        },
                                        {
                                            xtype: 'fieldset',
                                            title: 'Basic Data',
                                            collapsible: true,
                                            defaultType: 'textfield',
                                            defaults: {
                                                anchor: '100%',
												labelWidth: 140,
                                            },
                                            layout: 'anchor',
                                            margin: 10,
                                            items: [{
                                                fieldLabel: 'Location/Complex',
                                                name: 'location'
                                            }, {
                                                xtype: 'datefield',
												anchor: '100%',
												fieldLabel: 'Tanggal Survey',
												name: 'tanggal_survey',
												maxValue: new Date()
                                            }, {
                                                fieldLabel: 'Nama Area',
                                                name: 'nama_area'
                                            }, {
                                                fieldLabel: 'RW/Developer',
                                                name: 'owner_type'
                                            }, {
                                                fieldLabel: 'Kelurahan',
                                                name: 'kelurahan'
                                            }, {
                                                fieldLabel: 'Kecamatan',
                                                name: 'kecamatan'
                                            }, {
                                                fieldLabel: 'Kota',
                                                name: 'city'
                                            }, {
                                                fieldLabel: 'Regional',
                                                name: 'regional'
                                            }, {
                                                fieldLabel: 'Koordinat X',
                                                name: 'coordinat_x'
                                            }, {
                                                fieldLabel: 'Koordinat Y',
                                                name: 'coordinat_y'
                                            }, {
                                                fieldLabel: 'Qty HP All',
                                                name: 'home_pass'
                                            }, {
                                                fieldLabel: 'Qty HP Potensial',
                                                name: 'home_pass_potential'
                                            }, {
                                                fieldLabel: 'Rekomendasi Untuk Dibangun',
                                                name: 'recommendation'
                                            }]
                                        },
                                        {
                                            xtype: 'fieldset',
                                            columnWidth: 0.8,
                                            title: 'Detail Data',
                                            collapsible: true,
                                            defaultType: 'textfield',
                                            defaults: {
                                                anchor: '100%',
												labelWidth: 140,
                                            },
                                            layout: 'anchor',
                                            margin: 10,
                                            items: [{
                                                fieldLabel: 'Jenis Properti Area',
                                                name: 'jenis_properti_area'
                                            }, {
                                                fieldLabel: 'Klasifikasi Jenis Rumah',
                                                name: 'klasifikasi_jenis_rumah'
                                            }, {
                                                fieldLabel: 'Rata-rata Tingkat Okupansi di Area',
                                                name: 'rata_rata_okupansi'
                                            }, {
                                                fieldLabel: 'Mayoritas Penghuni Memiliki',
                                                name: 'mayoritas_penghuni_memiliki'
                                            }, {
                                                fieldLabel: 'Metode Pembangunan',
                                                name: 'metode_pembangunan'
                                            }, {
                                                fieldLabel: 'Akses Untuk Melakukan Penjualan',
                                                name: 'akses_penjualan'
                                            }, {
                                                fieldLabel: 'Kompetitor',
                                                name: 'kompetitor'
                                            }, {
                                                fieldLabel: 'Mayoritas Penghuni Menggunakan Provider DTH',
                                                name: 'pengguna_dth'
                                            }, {
                                                fieldLabel: 'PIC Survey',
                                                name: 'pic'
                                            }, {
                                                fieldLabel: 'Note',
                                                name: 'note'
                                            }]
                                        }
                                    ],
                                },
                                {
                                    xtype: 'form',
                                    title: 'Membuat Data Survey Baru',
                                    autoScroll: true,
                                    url: '/mnc_ca/backend/web/index.php?r=survey/create',
                                    labelSeparator: '    ',
                                    items: [{
                                            xtype: 'hidden',
                                            name: '_csrf',
                                            value: getCSRFToken()
                                        },
                                        {
                                            xtype: 'fieldset',
                                            title: 'Basic Data',
                                            collapsible: true,
                                            defaultType: 'textfield',
                                            defaults: {
                                                anchor: '100%',
												labelWidth: 140
                                            },
                                            layout: 'anchor',
                                            margin: 10,
                                            items: [{
                                                fieldLabel: 'Location/Complex',
                                                name: 'location'
                                            }, {
                                                xtype: 'datefield',
												anchor: '100%',
												fieldLabel: 'Tanggal Survey',
												name: 'tanggal_survey',
												maxValue: new Date()
                                            }, {
                                                fieldLabel: 'Nama Area',
                                                name: 'nama_area'
                                            }, {
                                                fieldLabel: 'RW/Developer',
                                                name: 'owner_type'
                                            }, {
                                                fieldLabel: 'Kelurahan',
                                                name: 'kelurahan'
                                            }, {
                                                fieldLabel: 'Kecamatan',
                                                name: 'kecamatan'
                                            }, {
                                                fieldLabel: 'Kota',
                                                name: 'city'
                                            }, {
                                                fieldLabel: 'Regional',
                                                name: 'regional'
                                            }, {
                                                fieldLabel: 'Koordinat X',
                                                name: 'coordinat_x'
                                            }, {
                                                fieldLabel: 'Koordinat Y',
                                                name: 'coordinat_y'
                                            }, {
                                                fieldLabel: 'Qty HP All',
                                                name: 'home_pass'
                                            }, {
                                                fieldLabel: 'Qty HP Potensial',
                                                name: 'home_pass_potential'
                                            }, {
                                                fieldLabel: 'Rekomendasi Untuk Dibangun',
                                                name: 'recommendation'
                                            }]
                                        },
                                        {
                                            xtype: 'fieldset',
                                            columnWidth: 0.8,
                                            title: 'Detail Data',
                                            collapsible: true,
                                            defaultType: 'textfield',
                                            defaults: {
                                                anchor: '100%',
												labelWidth: 140
                                            },
                                            layout: 'anchor',
                                            margin: 10,
                                            items: [{
                                                fieldLabel: 'Jenis Properti Area',
                                                name: 'jenis_properti_area'
                                            }, {
                                                fieldLabel: 'Klasifikasi Jenis Rumah',
                                                name: 'klasifikasi_jenis_rumah'
                                            }, {
                                                fieldLabel: 'Rata-rata Tingkat Okupansi di Area',
                                                name: 'rata_rata_okupansi'
                                            }, {
                                                fieldLabel: 'Mayoritas Penghuni Memiliki',
                                                name: 'mayoritas_penghuni_memiliki'
                                            }, {
                                                fieldLabel: 'Metode Pembangunan',
                                                name: 'metode_pembangunan'
                                            }, {
                                                fieldLabel: 'Akses Untuk Melakukan Penjualan',
                                                name: 'akses_penjualan'
                                            }, {
                                                fieldLabel: 'Kompetitor',
                                                name: 'kompetitor'
                                            }, {
                                                fieldLabel: 'Mayoritas Penghuni Menggunakan Provider DTH',
                                                name: 'pengguna_dth'
                                            }, {
                                                fieldLabel: 'PIC Survey',
                                                name: 'pic'
                                            }, {
                                                fieldLabel: 'Note',
                                                name: 'note'
                                            }]
                                        }
                                    ],
                                    buttons: [{
                                        text: 'Buat Baru',
                                        handler: function() {
                                            var form = this.up('form').getForm();
                                            if (form.isValid()) {
                                                form.submit({
                                                    success: function(form, action) {
                                                        Ext.Msg.alert('Success', action.result.message);
                                                    },
                                                    failure: function(form, action) {
                                                        Ext.Msg.alert('Messages', action.result ? action.response.responseText: 'No response');
														surveyStore.load();
                                                    }
                                                });
                                            }
                                        }
                                    }]
                                },
                                {
                                    xtype: 'form',
                                    title: 'Memperbaharui Data Survey',
									id: 'updateSurveyForm',
                                    autoScroll: true,
                                    url: '/mnc_ca/backend/web/index.php?r=survey/update',
                                    items: [{
                                            xtype: 'hidden',
                                            name: '_csrf',
                                            value: getCSRFToken()
                                        },
                                        {
                                            xtype: 'fieldset',
                                            title: 'Basic Data',
                                            collapsible: true,
                                            defaultType: 'textfield',
                                            defaults: {
                                                anchor: '100%',
												labelWidth: 140
                                            },
                                            layout: 'anchor',
                                            margin: 10,
                                            items: [{
                                                fieldLabel: 'Location/Complex',
                                                name: 'location'
                                            }, {
                                                xtype: 'datefield',
												anchor: '100%',
												fieldLabel: 'Tanggal Survey',
												name: 'tanggal_survey',
												maxValue: new Date()
                                            }, {
                                                fieldLabel: 'Nama Area',
                                                name: 'nama_area'
                                            }, {
                                                fieldLabel: 'RW/Developer',
                                                name: 'owner_type'
                                            }, {
                                                fieldLabel: 'Kelurahan',
                                                name: 'kelurahan'
                                            }, {
                                                fieldLabel: 'Kecamatan',
                                                name: 'kecamatan'
                                            }, {
                                                fieldLabel: 'Kota',
                                                name: 'city'
                                            }, {
                                                fieldLabel: 'Regional',
                                                name: 'regional'
                                            }, {
                                                fieldLabel: 'Koordinat X',
                                                name: 'coordinat_x'
                                            }, {
                                                fieldLabel: 'Koordinat Y',
                                                name: 'coordinat_y'
                                            }, {
                                                fieldLabel: 'Qty HP All',
                                                name: 'home_pass'
                                            }, {
                                                fieldLabel: 'Qty HP Potensial',
                                                name: 'home_pass_potential'
                                            }, {
                                                fieldLabel: 'Rekomendasi Untuk Dibangun',
                                                name: 'recommendation'
                                            }]
                                        },
                                        {
                                            xtype: 'fieldset',
                                            columnWidth: 0.8,
                                            title: 'Detail Data',
                                            collapsible: true,
                                            defaultType: 'textfield',
                                            defaults: {
                                                anchor: '100%',
												labelWidth: 140
                                            },
                                            layout: 'anchor',
                                            margin: 10,
                                            items: [{
                                                fieldLabel: 'Jenis Properti Area',
                                                name: 'jenis_properti_area'
                                            }, {
                                                fieldLabel: 'Klasifikasi Jenis Rumah',
                                                name: 'klasifikasi_jenis_rumah'
                                            }, {
                                                fieldLabel: 'Rata-rata Tingkat Okupansi di Area',
                                                name: 'rata_rata_okupansi'
                                            }, {
                                                fieldLabel: 'Mayoritas Penghuni Memiliki',
                                                name: 'mayoritas_penghuni_memiliki'
                                            }, {
                                                fieldLabel: 'Metode Pembangunan',
                                                name: 'metode_pembangunan'
                                            }, {
                                                fieldLabel: 'Akses Untuk Melakukan Penjualan',
                                                name: 'akses_penjualan'
                                            }, {
                                                fieldLabel: 'Kompetitor',
                                                name: 'kompetitor'
                                            }, {
                                                fieldLabel: 'Mayoritas Penghuni Menggunakan Provider DTH',
                                                name: 'pengguna_dth'
                                            }, {
                                                fieldLabel: 'PIC Survey',
                                                name: 'pic'
                                            }, {
                                                fieldLabel: 'Note',
                                                name: 'note'
                                            }]
                                        }
                                    ],
                                    buttons: [{
                                        text: 'Perbaharui',
                                        handler: function() {
                                            var form = this.up('form').getForm();
                                            if (form.isValid()) {
                                                form.submit({
                                                    success: function(form, action) {
                                                        Ext.Msg.alert('Success', action.result.message);
                                                    },
                                                    failure: function(form, action) {
                                                        Ext.Msg.alert('Failed', action.result ? action.result.message : 'No response');
                                                    }
                                                });
                                            }
                                        }
                                    }]
                                },
                                {
                                    xtype: 'form',
                                    layout: 'fit',
                                    title: 'Upload Data Survey'
                                }
                            ]
                        }
                    ]
                },{
					xtype: 'panel',
					title: 'Batch Potensial CA',
					items: [{
						xtype: 'gridpanel',
						columns: [{xtype: 'rownumberer'},
							{
								header: 'Nama File',
								dataIndex: 'filename'
							},
							{
								header: 'Tanggal Upload',
								dataIndex: 'create_date'
							},
							{
								header: 'Diupload oleh',
								dataIndex: 'create_by'
							}
						],
						tbar: [
							{
								text: "Upload",
								iconCls: 'icon-upload',
								handler: function() {
									uploadWindow.show();
								}
							},
							{
								text: "Delete",
								iconCls: 'icon-delete',
								handler: function() {
									//var record = grid.getSelectionModel().getSelection()[0];
									//TODO: create delete feature
								}
							}
						],
						listeners : {
							itemdblclick: function(dv, record, item, index, e) {
								Ext.getCmp('detailSurveyForm').loadRecord(record);
							}
						},
					}]
				}]
            }]
        });

        // Create viewport
        Ext.create('Ext.container.Viewport', {
            layout: 'border',
			id: 'mainViewport',
            items: [mainPanel, westPanel, eastPanel, northPanel],
            listeners: {
                afterrender: function() {
                    setTimeout(function() {
                        initMap();
                        initListeners();
                    }, 200);
                }
            }
        });


        var searchWindow = new Ext.Window({
            title: 'Search Result',
            id: 'searchResultWindow',
            layout: 'accordion',
            width: 300,
            height: 400,
            closeAction: 'hide',
            items: [],
            renderTo: Ext.getBody()
        });
		
		var uploadWindow = Ext.create('Ext.window.Window', {
			title: 'Upload Survey Batch',
			height: 160,
			width: 400,
			layout: 'fit',
			closeAction: 'hide',
			items: {  
				xtype: 'form',
				bodyPadding: '10 10 0',

				defaults: {
					anchor: '100%',
					allowBlank: false,
					msgTarget: 'side',
					labelWidth: 80
				},

				items: [{
					xtype: 'textfield',
					fieldLabel: 'Nama Batch'
				},{
					xtype: 'filefield',
					id: 'form-file',
					emptyText: 'Pilih file...',
					fieldLabel: 'Batch File',
					name: 'photo-path',
					buttonText: '',
					buttonConfig: {
						iconCls: 'icon-upload'
					}
				}],

				buttons: [{
					text: 'Save',
					handler: function(){
						var form = this.up('form').getForm();
						if(form.isValid()){
							form.submit({
								url: 'file-upload.php',
								waitMsg: 'Uploading your photo...',
								success: function(fp, o) {
									msg('Success', 'Processed file "' + o.result.file + '" on the server');
								}
							});
						}
					}
				},{
					text: 'Reset',
					handler: function() {
						this.up('form').getForm().reset();
					}
				}]
			}
		});


    }
});