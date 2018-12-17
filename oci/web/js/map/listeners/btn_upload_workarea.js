/* 
 * This project was created by
 * Rizky Firmansyah
 * PT Elixer Reka Digita
 * ----------
 * For inquiry do not hesitate to contact us at info@elixer.co.id
 * or please visit our website elixer.co.id
 */


function setListeners_upload_work_area() {

    Ext.getCmp("btn_upload").addListener("click", function () {
        uploadWorkArea.show();
    });

    var uploadWorkArea = new Ext.Window({
        title: 'Upload New Work Area',
        fileUpload: true,
        width: 380,
        id: 'uploadRencanaKerja',
        autoHeight: true,
        closeAction: 'hide',
        renderTo: 'mapPanel',
        items: [
            {
                xtype: 'form',
                layout: 'anchor',
                id: 'formRencanaKerja',
                margin: '5 5 5 5',
                defaults: {
                    anchor: '100%'
                },
                frame: false,
                items: [{
                        xtype: 'textfield',
                        fieldLabel: 'Work Area ID',
                        labelWidth: 140,
                        name: 'formNamaRk',
                        id: 'workAreaId',
                        emptyText: 'Write your work area ID here...',
                        msgTarget: 'side',
                        allowBlank: false,
                        buttonText: '',
                        vtype: 'rkRegex'
                    }
                ]
            },
            {
                xtype: 'form',
                layout: 'anchor',
                id: 'formRencanaKerjaName',
                margin: '5 5 5 5',
                defaults: {
                    anchor: '100%'
                },
                frame: false,
                items: [{
                        xtype: 'textfield',
                        fieldLabel: 'Work Area Name',
                        labelWidth: 140,
                        name: 'formWorkAreaName',
                        id: 'workAreaName',
                        emptyText: 'Write your work area name here...',
                        msgTarget: 'side',
                        allowBlank: false,
                        buttonText: ''
                    }
                ]
            },
            {
                xtype: 'form',
                layout: 'anchor',
                id: 'formShipName',
                margin: '5 5 5 5',
                defaults: {
                    anchor: '100%'
                },
                frame: false,
                items: [{
                        xtype: 'combobox',
                        fieldLabel: 'Shipname',
                        labelWidth: 140,
                        name: 'comboboxkapal',
                        id: 'comboboxkapal',
                        allowBlank: false,
                        forceSelection: true,
                        emptyText: 'Select your ship here...',
                        displayField: 'shipname',
                        valueField: 'idship',
                        store: shipStore
                    }]
            },
            {
                xtype: 'form', // form wilayah kerja
                id: 'formWilayahKerja',
                layout: 'anchor',
                margin: '5 5 5 5',
                defaults: {
                    anchor: '100%'
                },
                frame: false,
                items: [{
                        xtype: 'filefield',
                        fieldLabel: 'Working Area',
                        labelWidth: 140,
                        name: 'fileWorkArea',
                        emptyText: 'Select your working area file...',
                        msgTarget: 'side',
                        allowBlank: false,
                        buttonText: '',
                        regex: (/.(out)$/i),
                        regexText: 'File must have .out extension. Example: Blok_Tmh17.OUT',
                        buttonConfig: {
                            iconCls: 'icon-upload'
                        }
                    }]
            },
            {
                xtype: 'form', // form profil titik gali
                id: 'formProfilTg',
                layout: 'anchor',
                margin: '5 5 5 5',
                defaults: {
                    anchor: '100%'
                },
                frame: false,
                items: [{
                        xtype: 'filefield',
                        fieldLabel: 'Mining Point Profile',
                        labelWidth: 140,
                        name: 'fileProfil',
                        emptyText: 'Select your profile file...',
                        msgTarget: 'side',
                        allowBlank: false,
                        buttonText: '',
                        regex: (/_A.(dat)$/i), // $ is regex for match end of input; i defines modifier for the search to be case-sensitive
                        regexText: 'File must have .dat extension. Example: Tmh17_A.DAT',
                        buttonConfig: {
                            iconCls: 'icon-upload'
                        }
                    }]

            }, {
                xtype: 'form', // form titik gali
                frame: false,
                layout: 'anchor',
                margin: '5 5 5 5',
                defaults: {
                    anchor: '100%'
                },
                id: 'formTitikGali',
                items: [{
                        xtype: 'filefield',
                        fieldLabel: 'Mining Point',
                        labelWidth: 140,
                        name: 'fileTitikGali',
                        emptyText: 'Select your mining point file...',
                        msgTarget: 'side',
                        allowBlank: false,
                        buttonText: '',
                        regex: (/_C.(dat)$/i),
                        regexText: 'File must have .dat extension. Example: Tmh17_C.DAT',
                        buttonConfig: {
                            iconCls: 'icon-upload'
                        }
                    }]
            }],
        buttons: [{
                text: 'Save',
                frame: false,
                handler: function () {
                    shipname = Ext.getCmp("formShipName").getForm();
                    wkform = Ext.getCmp("formWilayahKerja").getForm();
                    profiletgform = Ext.getCmp("formProfilTg").getForm();
                    titikgaliform = Ext.getCmp("formTitikGali").getForm();
                    rencanaKerjaForm = Ext.getCmp("formRencanaKerja").getForm();
                    workAreaNameForm = Ext.getCmp("workAreaName").value;
                    workAreaId = Ext.getCmp('workAreaId').value.toUpperCase();
                    var idship = Ext.getCmp('comboboxkapal').value;
                    if (rencanaKerjaForm.isValid()) {
                        if (shipname.isValid() && wkform.isValid()) {
                            if (profiletgform.isValid()) {
                                if (titikgaliform.isValid()) {
                                    wkform.submit({
                                        url: '/SIOPL/wilayahkerja/upload',
                                        waitMsg: 'Uploading your file...',
                                        params: {
                                            work_area_id: workAreaId,
                                            id_kapal: idship
                                        }
                                    });
                                    titikgaliform.submit({
                                        url: '/SIOPL/titikgali/upload',
                                        waitMsg: 'Uploading your file...',
                                        params: {
                                            work_area_id: workAreaId,
                                            id_kapal: idship
                                        }
                                    });
                                    profiletgform.submit({
                                        url: '/SIOPL/profiltitikgali/upload',
                                        waitMsg: 'Uploading your file...',
                                        method: 'POST',
                                        params: {
                                            work_area_id: workAreaId,
                                            id_kapal: idship
                                        },
                                        success: function (form, action) {
                                            Ext.Ajax.request({
                                                url: '/SIOPL/rencanakerja/insertrk',
                                                method: 'POST',
                                                params: {
                                                    work_area_id: workAreaId,
                                                    id_kapal: idship,
                                                    work_area_name: workAreaNameForm
                                                }
                                            });
                                            Ext.Msg.alert('Success', 'You have created Work Area with the name ' + workAreaId);
                                            Ext.Ajax.request({
                                                url: '/SIOPL/rencanakerja/querytoshapefile',
                                                method: 'POST',
                                                params: {
                                                    work_area_id: workAreaId,
                                                    idship: idship
                                                }
                                            });
                                        },
                                        failure: function (form, action) {
                                            Ext.Msg.alert('Failure', 'There must be an error in your connection...');
                                        }
                                    });
                                } else if (!titikgaliform.isValid()) {
                                    Ext.Msg.alert('Warning', 'Please select your titik gali file first.');
                                }
                            } else if (!profiletgform.isValid() && !titikgaliform.isValid()) {
                                Ext.Msg.alert('Warning', 'Please select your profile titik gali and titik gali file..');
                            } else {
                                Ext.Msg.alert('Warning', 'Please select one of your file..');
                            }
                        } else if (shipname.isValid() && !wkform.isValid() && !profiletgform.isValid() && !titikgaliform.isValid()) {
                            Ext.Msg.alert('Warning', 'Please select your working area, profile titik gali and titik gali file..');
                        } else if (titikgaliform.isValid() && !shipname.isValid() && !wkform.isValid() && !profiletgform.isValid()) {
                            Ext.Msg.alert('Warning', 'Please select your shipname, working area and profile titik gali file..');
                        } else if (profiletgform.isValid() && !titikgaliform.isValid() && !shipname.isValid() && !wkform.isValid()) {
                            Ext.Msg.alert('Warning', 'Please select your shipname, working area and titik gali file..');
                        } else if (wkform.isValid() && !profiletgform.isValid() && !titikgaliform.isValid() && !shipname.isValid()) {
                            Ext.Msg.alert('Warning', 'Please select your shipname, profile titik gali and titik gali file..');
                        } else {
                            Ext.Msg.alert('Warning', 'Please select your shipname, working area, profile titik gali, and titik gali file..');
                        }
                    } else {
                        Ext.Msg.alert('Warning', 'Please input Rencana Kerja with valid name...');
                    }

                }
            }, {
                text: 'Reset',
                frame: false,
                handler: function () {
                    Ext.getCmp('formRencanaKerja').getForm().reset();
                    Ext.getCmp('formShipName').getForm().reset();
                    Ext.getCmp('formWilayahKerja').getForm().reset();
                    Ext.getCmp('formTitikGali').getForm().reset();
                    Ext.getCmp('formProfilTg').getForm().reset();
                }
            }]

    });
}