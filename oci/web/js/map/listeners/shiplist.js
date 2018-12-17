/* global Ext, map, ol, pointerMoveHandler, draw, drawend, source */

function setListeners_shiplist() {

    shipId = new Ext.data.JsonStore({
        remoteSort: false,
        autoLoad: true,
        proxy: new Ext.data.HttpProxy({
            url: '/SIOPL/map/loadShipTracking.htm',
            reader: {
                type: 'json',
                root: 'records',
                idProperty: 'id'
            },
            actionMethods: {
                read: 'POST',
                update: 'POST',
                create: 'POST'
            }
        }),
        sorters: [{
                property: 'idship',
                direction: 'ASC'
            }],
        fields: [
            {name: 'idship'},
            {name: 'shipname'},
            {name: 'date'},
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
            {name: 'cutter_z'},
            {name: 'pt_on'},
            {name: 'pressure_cutter'}
        ]
    });

    var rkRegexValidation = /^RK[a-zA-Z0-9]{5}\_[0-9]{1}\_[0-9]{8}$/; // Using Regular Expression for validating input name. The '^' has the meaning of the beginning of input. '\' means for escape special character
    Ext.apply(Ext.form.VTypes, {
        rkRegex: function (v) {
            return rkRegexValidation.test(v);
        },
        rkRegexText: 'Invalid work area name. The convention must be have the following format:\n\
                          RKTMH(shipId)_wkId_YYYYMMdd\n\
                          Ex: RKTMH17_1_20160312',
        rkRegexMask: /[RKa-zA-Z0-9_]/
    });

}
