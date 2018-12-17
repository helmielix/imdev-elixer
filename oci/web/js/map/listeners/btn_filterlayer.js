
function setListeners_btn_filterlayer() {

	function setGridContour(records) {
        records.each(function (record, index) {
            var feature = new ol.Feature({
                name: "contourGrid"
            });
            var es_x = record.data['properties.es_x'];
            var x = (es_x*2.5) + 500000;
            var es_y = record.data['properties.es_y'];
            var y = -(es_y*2.5) + 9840000;
            var tlr = record.data['properties.tlr'];
        
			var r = 0;
            var g = 0;
            var b = 0; 
            
            if (tlr <= 38) {
				r = 255;
                g = 255 - Math.floor(255*(tlr/38));
            } else {
                g = 0;
				r = 255 - Math.floor(255*((tlr-38)/7));
            }
                
            var style = new ol.style.Style({
                fill: new ol.style.Fill({
                    color: 'rgba('+r+', '+g+', '+b+', 0.8)'
                })
            });
                
            // Static 2d Vector Ship
            var polygonArray = [];
            polygonArray.push([x - 1.25, y - 1.25]);
            polygonArray.push([x - 1.25, y + 1.25]);
            polygonArray.push([x + 1.25, y + 1.25]);
            polygonArray.push([x + 1.25, y - 1.25]);
            var polygon = new ol.geom.Polygon([[
                    ol.proj.transform([polygonArray[0][0], polygonArray[0][1]], 'EPSG:32748', 'EPSG:3857'),
                    ol.proj.transform([polygonArray[1][0], polygonArray[1][1]], 'EPSG:32748', 'EPSG:3857'),
                    ol.proj.transform([polygonArray[2][0], polygonArray[2][1]], 'EPSG:32748', 'EPSG:3857'),
                    ol.proj.transform([polygonArray[3][0], polygonArray[3][1]], 'EPSG:32748', 'EPSG:3857'),
                ]]);
            feature.setGeometry(polygon);
            feature.setStyle(style);
            vectorOutputMining.getSource().addFeature(feature);
        
        });
    }

	function setFilterLayer(min, max) {
		var cqlFilter = 'tlr between ' + min + ' and ' + max;
		contourGridStore.getProxy().extraParams.cql_filter = cqlFilter;

		contourGridStore.load();

	    contourGridStore.on('load', function (records) {
		    vectorOutputMining.getSource().clear();
			contourGridStoreLoaded = 1;
		    setGridContour(records);
		});
	}

	var maxTlr;
	var minTlr;
	var maxValueTitikGali = '/geoserver/wfs?service=wfs&' +
            'version=1.1.0&request=GetFeature&typeName=siopl:layer_hasil_gali&' +            
            'propertyName=tlr&format_options=callback:loadFeatures&' +
            'outputFormat=application/json&exceptions=application/json&srsName=EPSG:32748&maxFeatures=1&sortBy=tlr+D';

    var minValueTitikGali = '/geoserver/wfs?service=wfs&' +
            'version=1.1.0&request=GetFeature&typeName=siopl:layer_hasil_gali&' +            
            'propertyName=tlr&format_options=callback:loadFeatures&' +
            'outputFormat=application/json&exceptions=application/json&srsName=EPSG:32748&maxFeatures=1&sortBy=tlr+A';

    var sliderHGBar = new Ext.slider.MultiSlider({
    	id: 'sliderHGBar',
        width: 319,
        minValue: 0,
        maxValue: 100,
        useTips: true,
        values: [0, 30],
        listeners: {
            dragend: function (slider, e, opt) {
                var index = slider.getValue();
                if (index !== 'undefined') {
                	setFilterLayer(index[0], index[1]);
                }
            }
        }
    });

    var sliderHasilGali = new Ext.Window({
        title: 'Filter Layer Hasil Gali',
        layout: 'border',
        id: 'sliderHasilGali',
        y: 81,
        x: 144,
        width: 336,
        height: 55,
        closeAction: 'hide',
        renderTo: 'mapPanel',
        items: new Ext.Container({
            region: 'center',
            items: sliderHGBar
        })
    });

    Ext.getCmp("btn_filterlayer").addListener("click", function () {
	    Ext.Ajax.request({
	        url: maxValueTitikGali,
	        method: 'GET',
	        success: function (record, response) {
	            jsonString = record.responseText;
	            var json = JSON.parse(jsonString);
	            maxTlr = json.features[0].properties.tlr;
    			Ext.getCmp('sliderHGBar').maxValue = maxTlr;
	        }
	    });

	    Ext.Ajax.request({
	        url: minValueTitikGali,
	        method: 'GET',
	        success: function (record, response) {
	            jsonString = record.responseText;
	            var json = JSON.parse(jsonString);
	            minTlr = json.features[0].properties.tlr;
    			Ext.getCmp('sliderHGBar').minValue = minTlr;
	        }
	    });
	    sliderHasilGali.show();

    });

}