<span class="belka">&nbsp kWh charts<span class="okno"> 

<script type="text/javascript" src="modules/kwh/html/js/jquery.min.js"></script>
<script src="modules/kwh/html/js/highstock.js"></script>
<script src="modules/kwh/html/js/exporting.js"></script>



<div id="container" style="height: 400px"></div>
<br />
<div id="container2" style="height: 400px"></div>
<br />
<div id="container3" style="height: 400px"></div>

<script type="text/javascript">

$(function() {

    $.getJSON('tmp/kwh/gpio_kwh_min.json', function(data) {

    // create the chart
    $('#container').highcharts('StockChart', {
        chart: {
            alignTicks: false,
                backgroundColor: {
                linearGradient: [0, 0, 500, 500],
                stops: [
                    [0, 'rgb(255, 255, 255)'],
                    [1, 'rgb(237, 235, 234)']
                ]
            },
        },

        rangeSelector: {
	inputEnabled: $('#container').width() > 480,
            selected: 0,
       buttons: [{
	type: 'day',
	count: 1,
	text: '1d'
               }, {
	type: 'day',
	count: 7,
	text: '7d'
               }, {
	type: 'month',
	count: 1,
	text: '1m'
               }, {
	type: 'ytd',
	text: 'YTD'
               }, {
	type: 'year',
	count: 1,
	text: '1y'
               }, {
	type: 'all',
	text: 'All'
              }]
        },

        title: {
            text: 'kWh hour'
        },

        yAxis: {
        min: 0
        },


        tooltip: {
            valueDecimals: 2,
            valueSuffix: ' kWh'
        },

        series: [{
            type: 'column',
            name: 'kWh',
            data: data,
            dataGrouping: {
	    enabled: true,
	    forced: true,
	    units: [[
	    'minute', // unit name
	    [60] // allowed multiples
	    ], [
	    'month',
	    [1, 2, 3, 4, 6]
	    ]]
            }
        }]
    });
    });
});



</script>

<script type="text/javascript">

$(function() {

    $.getJSON('tmp/kwh/gpio_kwh_min.json', function(data) {

    // create the chart
    $('#container2').highcharts('StockChart', {
        chart: {
            alignTicks: false,

	backgroundColor: {
                linearGradient: [0, 0, 500, 500],
                stops: [
                    [0, 'rgb(255, 255, 255)'],
                    [1, 'rgb(237, 235, 234)']
                ]
            },

        },

        rangeSelector: {
	inputEnabled: $('#container2').width() > 480,
            selected: 1,
          buttons: [{
        type: 'day',
        count: 1,
        text: '1d'
               }, {
        type: 'day',
        count: 7,
        text: '7d'
               }, {
        type: 'month',
        count: 1,
        text: '1m'
               }, {
        type: 'ytd',
        text: 'YTD'
               }, {
        type: 'year',
        count: 1,
        text: '1y'
               }, {
        type: 'all',
        text: 'All'
        
              }]

        },

        title: {
            text: 'kWh day'
        },

        yAxis: {
        min: 0
        },


        tooltip: {
            valueDecimals: 2,
            valueSuffix: ' kWh'
        },

        series: [{
            type: 'column',
            name: 'kWh',
            data: data,
            dataGrouping: {
	    enabled: true,
	    forced: true,
	    units: [[
	    'day', // unit name
	    [1,2] // allowed multiples
	    ], [
	    'month',
	    [1, 2, 3, 4, 6]
	    ]]
            }
        }]
    });
    });
});



</script>

<script type="text/javascript">

$(function() {

    $.getJSON('tmp/kwh/gpio_kwh_min.json', function(data) {

    // create the chart
    $('#container3').highcharts('StockChart', {
        chart: {
            alignTicks: false,

        backgroundColor: {
                linearGradient: [0, 0, 500, 500],
                stops: [
                    [0, 'rgb(255, 255, 255)'],
                    [1, 'rgb(237, 235, 234)']
                ]
            },

        },

        rangeSelector: {
	inputEnabled: $('#container3').width() > 480,
            selected: 0,
        buttons: [{

        type: 'hour',
        count: 1,
        text: '1h'
               }, {
        type: 'day',
        count: 1,
        text: '1d'
               }, {
        type: 'day',
        count: 7,
        text: '7d'
              }, {
        type: 'month',
        count: 1,
        text: '1m'
               }, {
        type: 'ytd',
        text: 'YTD'
               }, {
        type: 'year',
        count: 1,
        text: '1y'
               }, {
        type: 'all',
        text: 'All'

             }]
        },

        title: {
            text: 'kWh minute'
        },
        
        tooltip: {
            valueDecimals: 3,
            valueSuffix: ' kWh'
        },

        yAxis: {
        min: 0
	},
        

        series: [{
            type: 'spline',
            name: 'kWh',
            data: data,
            dataGrouping: {
	    enabled: true,
	    forced: true,
	    units: [[
	    'minute', // unit name
	    [1] // allowed multiples
	    ], [
	    'month',
	    [1, 2, 3, 4, 6]
	    ]]
            }
        }]
    });
    });
});



</script>




</span></span>
