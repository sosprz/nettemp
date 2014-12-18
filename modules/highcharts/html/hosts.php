<script type="text/javascript" src="modules/kwh/html/js/jquery.min.js"></script>
<script src="modules/kwh/html/js/highstock.js"></script>
<script src="modules/kwh/html/js/exporting.js"></script>



<div id="container" style="height: 400px"></div>

<script type="text/javascript">

$(function() {


    function getUrlVars() {
        var vars = {};
	    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
	    vars[key] = value;
    });
    return vars;
    }
    var host = getUrlVars()["host"];
	if(!host){
	//var gpio = "21";
    }

    $.getJSON('tmp/highcharts/host_'+host+'.json', function(data) {

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
	        text: host
	    },

	    series: [{
		step: false,
	        name: 'on',
	        data: data,
	        dataGrouping: {
		    units: [[
			'week', // unit name
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
