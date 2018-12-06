initChart = function () {
	city = $('#regionlist').val();
	console.log(city);
	$.ajax({
		url: '/ca/web/dashboard-ca/get-dash-ca-hp-by-city?city='+city,
		method: 'GET',
		dataType: 'json',
		contentType: "application/json",
		success: function(result) {
			console.log(result);
			chart = Highcharts.chart('chartPanel1', {
				chart: {
					type: 'column',
					height: 375
				},
				title: {
					text: 'Homepass'
				},
				
				
				 tooltip: {
					headerFormat: '<b>{point.x}</b><br/>',
					pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
				},
				xAxis: {
					categories: result['yearmonth'],
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Total'
					},
					stackLabels: {
						enabled: true,
						style: {
							fontWeight: 'bold',
							color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
						}
					}
				},
				legend: {
					align: 'right',
					x: -30,
					verticalAlign: 'top',
					y: 25,
					floating: true,
					backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
					borderColor: '#CCC',
					borderWidth: 1,
					shadow: false
				},
				plotOptions: {
					column: {
						stacking: 'normal',
						dataLabels: {
							enabled: true,
							color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
						}
					}
				},
				
				series: [{
					name: 'HP Submit',
					data:  result['hp_submit'],
				}, {
					name: 'HP On Process',
					data:  result['hp_on_process'],
				}, {
					name: 'HP Aktif',
					data:  result['hp_aktif'],
				}, {
					name: 'HP Rejected',
					data:  result['hp_rejected'],
				}]
			});
		//========================================================================================
			
		}
	})
	
}
$(window).ready(initChart);
$(window).resize(initChart);

function regionListChange() {
    chart.destroy();
	initChart();
}