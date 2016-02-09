<div id="container" style="height: 400 ; min-width: 310px"></div>
<script type="text/javascript">
var start = +new Date();
function getUrlVars() {
        var vars = {};
	    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
	    vars[key] = value;
    });
    return vars;
    }
    var type = getUrlVars()["type"];
    var max = getUrlVars()["max"];
    var single = getUrlVars()["single"];

if (type=='temp') { var xval = " °C"}
if (type=='humid') { var xval = " %"}
if (type=='press') { var xval = " hPa"}
if (type=='gpio') { var xval = " H/L"}
if (type=='host') { var xval = " ms"}
if (type=='system') { var xval = " %"}
if (type=='lux') { var xval = " lux"}
if (type=='water') { var xval = " m3"}
if (type=='gas') { var xval = " m3"}
if (type=='elec') { var xval = " kWh"}
if (type=='hosts') { var xval = " ms"}
if (type=='volt') { var xval = " V"}
if (type=='amps') { var xval = " A"}
if (type=='watt') { var xval = " W"}
if (type=='dist') { var xval = " cm"}

$(function () {
    var seriesOptions = [],
        seriesCounter = 0,

<?php
parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $url);
$type=$url['type'];
$single=$url['single'];

if ($type == 'system') {
    $array[]=cpu;
    $array[]=memory;
    $array[]=memory_cached;
}

elseif ($type == 'hosts') {
    $dirb = "sqlite:dbf/hosts.db";
    $dbh = new PDO($dirb) or die("cannot open database");
    $query = "SELECT name FROM hosts";
    foreach ($dbh->query($query) as $row) {
	$array[]=$row[0];
    }
}
elseif ($type == 'gpio') {
$dirb = "sqlite:dbf/nettemp.db";
$dbh = new PDO($dirb) or die("cannot open database");
$query = "select name FROM gpio WHERE mode!='humid'";
foreach ($dbh->query($query) as $row) {
    $array[]=$row[0];
    }
}
elseif ($single) {
$dirb = "sqlite:dbf/nettemp.db";
$dbh = new PDO($dirb) or die("cannot open database");
$query = "select name FROM sensors WHERE type='$type' AND charts='on' AND name='$single'";
foreach ($dbh->query($query) as $row) {
    $array[]=$row[0];
    }
}
else {
$dirb = "sqlite:dbf/nettemp.db";
$dbh = new PDO($dirb) or die("cannot open database");
$query = "select name FROM sensors WHERE type='$type' AND charts='on'";
foreach ($dbh->query($query) as $row) {
    $array[]=$row[0];
    }
}



$js_array = json_encode($array);
echo "names = ". $js_array . ";\n";
?>
	

        // create the chart when all data is loaded
        createChart = function () {
            $('#container').highcharts('StockChart', {

		chart: {
	        spacingBottom: 0,
		zoomType: 'x',

		events: {
                    load: function () {
                        if (!window.isComparing) {
                            this.setTitle(null, {
                                text: 'Built chart in ' + (new Date() - start) + 'ms'
                            });
                        }
                    }
                },

		},

		rangeSelector : {
                enabled: false
		},
        	navigator: {
            	    enabled: true
        	},
		
		title: {
    		    text: 'by '+max
    		},

        	subtitle: {
            	    text: 'nettemp jest spoko ale nie ma wykresów'
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

	    
		yAxis: {
        	title: {
            	    text: '('+xval+')'
        	}
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

        $.getJSON('common/hc_data.php?type='+type+'&name='+name+'&max='+max,  function (data) {

	if (max=="hour") { var xhour = "hour" }
	if (max=="day") { var xhour = "hour" }
	if (max=="week") { var xhour = "day" }
	if (max=="month") { var xhour = "week" }
	if (max=="months") { var xhour = "month" }
	if (max=="year") { var xhour = "month" }
	if (max=="all") { var xhour = "year" }

	if (type=="gas"|| type=="water"|| type=="elec") { 
	    
            seriesOptions[i] = {
                name: name,
                data: data,
        	type: 'column',
        	dataGrouping: {
    		enabled: true,
    		forced: true,
		units: [[xhour,[1]]]
		},
		tooltip: {
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y} '+ xval +'</b><br/>',
                    valueDecimals: 3
                }

	    };
	    
	} else if (type=='gpio' || type=='hosts'){
		seriesOptions[i] = {
                name: name,
                data: data,
		step: true
		};
	
	} else {
		seriesOptions[i] = {
                name: name,
                data: data,
		type: 'spline'
    		};
        }
	    

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

