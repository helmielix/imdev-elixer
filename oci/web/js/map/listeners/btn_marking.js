function setListeners_marking() {
    
    sliderInput = new Ext.Window({
        title: 'Input Marking',
        fileUpload: true,
        width: 350,
        id: 'inputMarking',
        autoHeight: true,
        closeAction: 'hide',
        items: [
            {
                xtype: 'form',
                layout: 'anchor',
                id: 'formAlert',
                margin: '5 5 5 5',
                defaults: {
                    anchor: '100%'
                },
                frame: false,
                items: [{
                        xtype: 'textareafield',
                        fieldLabel: 'Alert Description',
                        labelWidth: 100,
                        name: 'formalert',
                        id: 'inputAlert',
                        emptyText: 'Write your description here...',
                        msgTarget: 'side',
                        allowBlank: false

                    }
                ]
            }],
        buttons: [{
                text: 'Save',
                frame: false,
                handler: function () {
                    markingForm = Ext.getCmp("formAlert").getForm();
                    description = Ext.getCmp("inputAlert").value;
                    markingForm.submit({
                        url: '/SIOPL/marking/addMarking',
                        method: 'POST',
                        params: {
                            lon: coordTimah[0],
                            lat: coordTimah[1],
                            description: description
                        },
                        success: function (form, action) {
                            Ext.Msg.alert('Marking Success', 'Your alert sign has been added to application.');
                            
                            vector_marking.getSource().getSource().changed();
                            var marking_position = ol.proj.transform([coordTimah[0],coordTimah[1]], 'EPSG:32748', 'EPSG:900913')
                            var feature = new ol.Feature({
                                geometry: new ol.geom.Point(marking_position)
                            });
                            vector_marking.getSource().getSource().addFeature(feature);
                            vector_marking.getSource().getSource().clear();
                        },
                        failure: function (form, action) {
                            Ext.Msg.alert('Marking Failure', 'Sorry, there must be error in your connection. Please try again.');
                        }
                    });
                    
                    Ext.getCmp("btn_marking").toggle(false, true);
                    Ext.getCmp('inputMarking').close();
                }
            }, {
                text: 'Reset',
                frame: false,
                handler: function () {
                    Ext.getCmp('formAlert').getForm().reset();

                }
            }
        ]
    });

    Ext.getCmp("inputMarking").on("close", function() {
        Ext.getCmp("btn_marking").toggle(false, true);
        map.unByKey(unlistenMarking);
    })

    Ext.getCmp('btn_delete_marking').on('toggle', function() {
        var selected_features = new ol.interaction.Select({
        condition: ol.events.condition.click
        });
        map.getInteractions().extend([selected_features]);

        var cursorHoverStyle = "pointer";
        var target = map.getTarget();

        //target returned might be the DOM element or the ID of this element dependeing on how the map was initialized
        //either way get a jQuery object for it
        jTarget = typeof target === "string" ? $("#"+target) : $(target);

        // change cursor style when pointer is move here
        map.on("pointermove", function (event) {
            var mouseCoordInMapPixels = [event.originalEvent.offsetX, event.originalEvent.offsetY];

            // detect feature
            var pixel = map.getEventPixel(event.originalEvent);
            var hit = map.hasFeatureAtPixel(pixel);            

            if (hit) {
                jTarget.css("cursor", cursorHoverStyle);
            } else {
                jTarget.css("cursor", "");
            }
        });

        // select vector marking to get its attributes
        selected_features.on('select', function(evt) {
            if (evt.selected.length > 0) {
                var coordinate = evt.coordinate;
                id = evt.selected[0].i.substring(8, evt.selected[0].i.length);
                Ext.Msg.confirm("Delete Marking", "Are you sure you want to delete this sign?", function(btn){
                    if (btn == 'yes') {
                    Ext.Ajax.request({
                        url: '/SIOPL/marking/deleteMarking',
                        method: 'POST',
                        params: {
                            id: id
                        },
                        success: function () {
                            Ext.Msg.alert('Delete Success', 'Your sign has been deleted.');
                            vector_marking.getSource().getSource().clear();
                            selected_features.getFeatures().clear();
                            map.addLayer(vector_marking);
                        },
                        failure: function ()  {
                            Ext.Msg.alert('Delete Failure', 'There must be an error in your connection. Please try again.');  
                        }
                    })
                    } else if (btn == 'no') {
                        selected_features.getFeatures().clear();
                    }
                });

            } else {
                Ext.getCmp("btn_delete_marking").toggle(false, true);
                map.removeInteraction(selected_features);
                $(map.getTargetElement()).css("cursor", "");
            }
                
        });
         
    });

}