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
            alignTicks: false
        },

        rangeSelector: {
	inputEnabled: $('#container').width() > 480,
            selected: 1
        },

        title: {
            text: 'kWh'
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
            alignTicks: false
        },

        rangeSelector: {
	inputEnabled: $('#container2').width() > 480,
            selected: 1
        },

        title: {
            text: 'kWh day'
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
            alignTicks: false
        },

        rangeSelector: {
	inputEnabled: $('#container3').width() > 480,
            selected: 1
        },

        title: {
            text: 'kWh minute'
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