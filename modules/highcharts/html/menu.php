<div id="container" style="height: 400 ; min-width: 310px"></div>
<script type="text/javascript">

function getUrlVars() {
        var vars = {};
	    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
	    vars[key] = value;
    });
    return vars;
    }
    var type = getUrlVars()["type"];

if (type=='temp') { var xval = " °C"}
if (type=='humid') { var xval = " %"}
if (type=='press') { var xval = " hPa"}
if (type=='gonoff') { var xval = " H/L"}
if (type=='host') { var xval = " ms"}
if (type=='system') { var xval = " %"}
if (type=='lux') { var xval = " lux"}
if (type=='water') { var xval = " m3"}
if (type=='gas') { var xval = " m3"}
if (type=='elec') { var xval = " kWh"}


$(function () {
    var seriesOptions = [],
        seriesCounter = 0,
<?php
parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $url);
$type=$url[type];
$type=$type . "_";

$php_array = '';
$ar=array();
$g=scandir('tmp/highcharts/');
foreach($g as $x)
{
    if(is_dir($x))$ar[$x]=scandir($x);
    else
	if (strpos($x,$type) !== false) {
		$rest1=str_replace(".json", "", "$x");
		$rest=str_replace("$type", "", "$rest1");
		$php_array[]=$rest;
	}
}
$js_array = json_encode($php_array);
echo "names = ". $js_array . ";\n";
?>
	

        // create the chart when all data is loaded
        createChart = function () {

            $('#container').highcharts('StockChart', {

		chart: {
	        spacingBottom: 0
    		},

		legend: {
		enabled: true,
    	        verticalAlign: 'bottom',
		align: 'center',
		y: 0,
        	labelFormatter: function() {
                var lastVal = this.yData[this.yData.length - 1];
                    return '<span style="color:' + this.color + '">' + this.name + ': </span> <b>' + lastVal + xval +'</b> </n>';
        	    }
		},

		rangeSelector: {
		inputEnabled: $('#container').width() > 480,
		selected: 0,
		buttons: [{
		type: 'hour',
		count: 1,
		text: '1H'
		},
		{
		type: 'day',
		count: 1,
		text: '1D'
		}, {
		type: 'day',
		count: 7,
		text: '7D'
		}, {
		type: 'month',
		count: 1,
		text: '1M'
		}, {
		type: 'ytd',
		text: 'YTD'
		}, {
		type: 'year',
		count: 1,
		text: '1Y'
		}, {
		type: 'all',
		text: 'All'
		}]
		},

                yAxis: {
                },

		plotOptions: {
    		series: {
		type: 'spline',
                
    		}
		},

                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y} '+ xval +'</b><br/>',
                    valueDecimals: 2
                },

                series: seriesOptions
            });
        };

    $.each(names, function (i, name) {

        $.getJSON('tmp/highcharts/' + type + '_' + name + '.json',    function (data) {
        
            seriesOptions[i] = {
                name: name,
                data: data
            };

            // As we're loading the data asynchronously, we don't know what order it will arrive. So
            // we keep a counter and create the chart when all the data is loaded.
            seriesCounter += 1;

            if (seriesCounter === names.length) {
                createChart();
            }
        });
    });
});
</script>

