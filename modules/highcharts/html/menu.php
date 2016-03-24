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
    var group = getUrlVars()["group"];
    var mode = getUrlVars()["mode"];
    
<?php
$dirb = "sqlite:dbf/nettemp.db";
$dbh = new PDO($dirb) or die("cannot open database");
$query = "SELECT temp_scale FROM settings WHERE id='1'";
foreach ($dbh->query($query) as $row) {
	$temp_scale=$row['temp_scale'];
}
echo "temp_scale = '". $temp_scale ."';\n";

parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $url);
$type=$url['type'];
$single=$url['single'];
$group=$url['group'];


if ($type == 'system') {
    $array[]=cpu;
    $array[]=memory;
    $array[]=memory_cached;
    foreach($array as $row) {
	$types[$row]='system';
    }
}

elseif ($type == 'hosts' && empty($single)) {
    $dirb = "sqlite:dbf/nettemp.db";
    $dbh = new PDO($dirb) or die("cannot open database");
    $query = "SELECT name FROM hosts";
    foreach ($dbh->query($query) as $row) {
	$array[]=$row[0];
	$types[$row[0]]='hosts';
    }
}
elseif ($type == 'hosts' && $single) {
    $dirb = "sqlite:dbf/nettemp.db";
    $dbh = new PDO($dirb) or die("cannot open database");
    $query = "SELECT name FROM hosts WHERE name='$single'";
    foreach ($dbh->query($query) as $row) {
	$array[]=$row[0];
	$types[$row[0]]='hosts';
    }
}

elseif ($type == 'gpio' && empty($single)) {
$dirb = "sqlite:dbf/nettemp.db";
$dbh = new PDO($dirb) or die("cannot open database");
$query = "select name FROM gpio WHERE mode!='humid'";
foreach ($dbh->query($query) as $row) {
    $array[]=$row[0];
    $types[$row[0]]="gpio";
    }
}
elseif ($type == 'gpio' && $single) {
$dirb = "sqlite:dbf/nettemp.db";
$dbh = new PDO($dirb) or die("cannot open database");
$query = "select name FROM gpio WHERE mode!='humid' AND name='$single'";
foreach ($dbh->query($query) as $row) {
    $array[]=$row[0];
    $types[$row[0]]="gpio";
    }
}
elseif ($single) {
$dirb = "sqlite:dbf/nettemp.db";
$dbh = new PDO($dirb) or die("cannot open database");
$query = "select name,type FROM sensors WHERE type='$type' AND name='$single'";
foreach ($dbh->query($query) as $row) {
    $array[]=$row[0];
    $types[$row[0]]=$row[1];
    }
}
elseif ($group) {
$dirb = "sqlite:dbf/nettemp.db";
$dbh = new PDO($dirb) or die("cannot open database");
$query = "select name,type FROM sensors WHERE ch_group='$group' AND charts='on'";
foreach ($dbh->query($query) as $row) {
    $array[]=$row[0];
    $types[$row[0]]=$row[1];
    }
}
else {
$dirb = "sqlite:dbf/nettemp.db";
$dbh = new PDO($dirb) or die("cannot open database");
$query = "select name,type FROM sensors WHERE type='$type' AND charts='on'";
foreach ($dbh->query($query) as $row) {
    $array[]=$row[0];
    $types[$row[0]]=$row[1];
    }
}

$js_array = json_encode($array);
echo "names = ". $js_array .";\n";
$types = json_encode($types);
echo "types = ". $types .";\n";
?>


$(function () {
    var seriesOptions = [],
        seriesCounter = 0,


	

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
    		    text: max
    		},

		legend: {
		enabled: true,
    	        verticalAlign: 'bottom',
		align: 'center',
		y: 0,
        	labelFormatter: function() {
          var lastVal = this.yData[this.yData.length - 1];
           if (types[this.name]=='temp' && temp_scale=='F') {var legend = " °F"}
			 else if (types[this.name]=='temp' && temp_scale=='') {var legend = " °C" }
		    if (types[this.name]=='humid') { var legend = " %"};
		    if (types[this.name]=='press') { var legend = " hPa"};
		    if (types[this.name]=='gpio') { var legend = " H/L"};
		    if (types[this.name]=='host') { var legend = " ms"};
		    if (types[this.name]=='system') { var legend = " %"};
		    if (types[this.name]=='lux') { var legend = " lux"};
		    if (types[this.name]=='water') { var legend = " m3"};
		    if (types[this.name]=='gas') { var legend = " m3"};
	    	 if (types[this.name]=='elec') { var legend = " kWh"};
		    if (types[this.name]=='elec' && mode=='2') { var legend = " W"};
		    if (types[this.name]=='hosts') { var legend = " ms"};
		    if (types[this.name]=='volt') { var legend = " V"};
		    if (types[this.name]=='amps') { var legend = " A"};
		    if (types[this.name]=='watt') { var legend = " W"};
		    if (types[this.name]=='dist') { var legend = " cm"};
            	    
            	    
		    			 return '<span style="color:' + this.color + '">' + this.name + ': </span> <b>' + lastVal + legend +'</b> </n>';
        	    }
		},

		//yAxis: {
        	//title: {
            	//    text: '('+xval+')'
        	//}
    		//},

		plotOptions: {
    		series: {
		type: 'spline',
                
    		}
		},

                series: seriesOptions

	    
            });
	
        };

    $.each(names, function (i, name) {
    	
    	
	 if (types[name]=='temp' && temp_scale=='F') {var tooltip = " °F"}
	 else if (types[name]=='temp' && temp_scale=='') {var tooltip = " °C" }
    if (types[name]=='humid') { var tooltip = " %"}
    if (types[name]=='press') { var tooltip = " hPa"}
    if (types[name]=='gpio') { var tooltip = " H/L"}
    if (types[name]=='host') { var tooltip = " ms"}
    if (types[name]=='system') { var tooltip = " %"}
    if (types[name]=='lux') { var tooltip = " lux"}
    if (types[name]=='water') { var tooltip = " m3"}
    if (types[name]=='gas') { var tooltip = " m3"}
    if (types[name]=='elec') { var tooltip = " kWh"}
    if (types[name]=='elec' && mode=='2') { var tooltip = " W"}
    if (types[name]=='hosts') { var tooltip = " ms"}
    if (types[name]=='volt') { var tooltip = " V"}
    if (types[name]=='amps') { var tooltip = " A"}
    if (types[name]=='watt') { var tooltip = " W"}
    if (types[name]=='dist') { var tooltip = " cm"}

        $.getJSON('common/hc_data.php?type='+type+'&name='+name+'&max='+max+'&mode='+mode,  function (data) {

	if (max=="hour") { var xhour = "hour" }
	if (max=="day") { var xhour = "hour" }
	if (max=="week") { var xhour = "day" }
	if (max=="month") { var xhour = "week" }
	if (max=="months") { var xhour = "month" }
	if (max=="year") { var xhour = "month" }
	if (max=="all") { var xhour = "year" }

	if (type=="gas"|| type=="water"|| type=="elec" && mode != 2) {
	    
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
		    valueSuffix: tooltip, 
                    valueDecimals: 3
                }
	    };
	    
	} else if (type=='gpio' || type=='hosts'){
		seriesOptions[i] = {
                name: name,
                data: data,
		step: true,
		tooltip: {
		    valueSuffix: tooltip, 
                    valueDecimals: 2
                }
	    };
	
	} else {
		seriesOptions[i] = {
                name: name,
                data: data,
		type: 'spline',
		tooltip: { 
		    valueSuffix: tooltip, 
		    valueDecimals: 2
		},
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

