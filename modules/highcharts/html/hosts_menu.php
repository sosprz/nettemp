<span class="belka">&nbsp Highcharts<span class="okno">

<script type="text/javascript" src="modules/kwh/html/js/jquery.min.js"></script>
<script src="modules/kwh/html/js/highstock.js"></script>
<script src="modules/kwh/html/js/exporting.js"></script>
<script type="text/javascript" src="modules/highcharts/js/dark-unica.js"></script>

<div id="container" style="height: 400px; min-width: 310px"></div>

<script type="text/javascript">



$(function () {
    var seriesOptions = [],
        seriesCounter = 0,
<?php
$ar=array();
$g=scandir('tmp/highcharts/');
foreach($g as $x)
{
    if(is_dir($x))$ar[$x]=scandir($x);
    else
	if (strpos($x,'host') !== false) {
		$rest1=str_replace(".json", "", "$x");
		$rest=str_replace("host_", "", "$rest1");
		$php_array[]=$rest;
		
	}
}
//print_r($php_array);

//print_r($php_array);
//$php_array = array('rpi','wppl');
$js_array = json_encode($php_array);
echo "names = ". $js_array . ";\n";
?>
	

        //names = ['rpi', 'wppl'],
        // create the chart when all data is loaded
        createChart = function () {

            $('#container').highcharts('StockChart', {

                rangeSelector: {
                    selected: 4
                },

                yAxis: {
                    labels: {
                        formatter: function () {
                            return (this.value > 0 ? ' + ' : '') + this.value + '%';
                        }
                    },
                    plotLines: [{
                        value: 0,
                        width: 2,
                        color: 'silver'
                    }]
                },

                plotOptions: {
                    series: {
                        compare: 'percent'
                    }
                },

                tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ms<br/>',
                    valueDecimals: 2
                },

                series: seriesOptions
            });
        };

    $.each(names, function (i, name) {

        $.getJSON('tmp/highcharts/host_' + name + '.json',    function (data) {
        
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

</span>
</span>
