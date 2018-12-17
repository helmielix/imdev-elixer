initChart = function () {
	cityGa = $('#cityga').val();
	$.ajax({
		url: '/os/web/dashboard-os/get-dash-chart-os-personel?cityGa='+cityGa,
		method: 'GET',
		dataType: 'json',
		contentType: "application/json",
		success: function(result) {
			console.log(result);
			if (osga == true) {
				chartGa = Highcharts.chart('chartPanel1', {
					chart: {
						type: 'column',
						height: 380,
					},
					title: {
						text: 'OS GA'
					},
					tooltip: {
						formatter: function () {
							return '<b>' + this.x + '</b><br/>' +
								// this.series.name + ': ' + this.y
								this.point.tip;
						}
					},
					plotOptions: {
						column: {
							grouping: false,
							shadow: false,
							borderWidth: 0,
							dataLabels: {
								enabled: true
							}
						}
					},
					xAxis: {
						categories: result['month'],
						// categories: [1,2,3,4,5,6,7,8,9,10,11,12],
						// labels: {
							// items: [{
								// html:'January',
							// },{
								// html:'February',
							// },{
								// html:'March',
							// },{
								// html:'April',
							// },{
								// html:'May',
							// },{
								// html:'June',
							// },{
								// html:'July',
							// },{
								// html:'August',
							// },{
								// html:'September',
							// },{
								// html:'October',
							// },{
								// html:'November',
							// },{
								// html:'December',
							// },],
							// style: {
								// color: '#000',
								// font: '14px Nunito',
								// top: '100px'
							// },
						// },

					},
					yAxis: {
						allowDecimals: false,
						min: 0,
						title: {
							text: 'Total'
						}
					},

					series: [{
						name: 'Total',
						data: result['sum_stdk'],
						// stdk: result['source'],
					}]
				});
			}
		//========================================================================================
			if (personil == true) {
				chartOsPersonil = Highcharts.chart('chartPanel2', {
					chart: {
						type: 'column'
					},
					title: {
						text: 'Outsource Personil'
					},
					xAxis: {
						categories: result['cityPersonel']
					},
					yAxis: {
						min: 0,
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
					tooltip: {
						headerFormat: '<b>{point.x}</b><br/>',
						pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
					},
					plotOptions: {
						column: {
							grouping: false,
							shadow: false,
							borderWidth: 0
						}
					},
					series: [{
						name: 'Male IKO',
						data: result['male_iko'],
						color: 'rgba(248,161,63,1)',
						pointPadding: 0.35,
						pointPlacement: -0.2
					},
					{
						name: 'Female IKO',
						data: result['female_iko'],
						color: 'rgba(186,60,61,.9)',
						pointPadding: 0.43,
						pointPlacement: -0.2
					},{
						name: 'Male OSP',
						data: result['male_osp'],
						color: 'rgba(51,249,112,1)',
						pointPadding: 0.35,
						pointPlacement: 0.2
					},
					{
						name: 'Female OSP',
						data: result['female_osp'],
						color: 'rgba(0,166,90,1)',
						pointPadding: 0.43,
						pointPlacement: 0.2
					},]
				});
			}
	//=====================================================================================
			if (osvendor == true) {
				chartOsVendor = Highcharts.chart('chartPanel3', {
					chart: {
						type: 'column'
					},
					title: {
						text: 'Outsource Vendor'
					},
					xAxis: {
						categories: result['project_type']
					},
					yAxis: {
						min: 0,
						stackLabels: {
							enabled: true,
							style: {
								fontWeight: 'bold',
								color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
							}
						},
						title: 'Total',
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
					tooltip: {
						headerFormat: '<b>{point.x}</b><br/>',
						pointFormat: '{series.name}: {point.y}'
					},
					plotOptions: {
						column: {
							grouping: false,
							shadow: false,
							borderWidth: 0
						}
					},
					series: [{
						name: 'Total',
						data: result['total'],
						color: '#39dda8',
					}]
				});
			}
		}
	})

}
$(window).ready(initChart);
$(window).resize(initChart);

function cityGaChange() {
	if (personil == true) {
		chartOsPersonil.destroy();
	}
    chartGa.destroy();
	initChart();
	// $(window).ready(initChart);
	// $(window).resize(initChart);
}
