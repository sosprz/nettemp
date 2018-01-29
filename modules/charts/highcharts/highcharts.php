<?php 
$theme=$nts_charts_theme;
?>
<script type="text/javascript" src="html/highcharts/highstock.js"></script>
<script type="text/javascript" src="html/highcharts/exporting.js"></script>
<?php if ($theme == 'black') { ?>
<script type="text/javascript" src="html/highcharts/dark-unica.js"></script>
<?php 
    }
if ($theme == 'sand') { ?>
<script type="text/javascript" src="html/highcharts/sand-signika.js"></script>
<?php 
    }
if ($theme == 'grid') { ?>
<script type="text/javascript" src="html/highcharts/grid-light.js"></script>
<?php 
    }
?>

<script type="text/javascript" src="html/highcharts/no-data-to-display.js"></script>

<div id="container" style="height: 700px; min-width: 310px"></div>
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
    if(!type) {
		var type = "temp";    
    }
    if(!max) {
		var max = "<?php echo $nts_charts_max?>";    
    }
    
    
<?php

parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $url);
if(!empty($url['type'])) {
	$type=$url['type'];
} else {
	$type="temp";
}
if(!empty($url['single'])) {
	$single=$url['single'];
}
if(!empty($url['group'])) {
	$group=$url['group'];
}




if ($type == 'system') {
    $array[]='cpu';
    $array[]='memory';
    foreach($array as $row) {
			$types[$row]='system';
    }
}

elseif ($single) {
$dirb = "sqlite:dbf/nettemp.db";
$db = new PDO($dirb) or die("cannot open database");
$query = "select name,type FROM sensors WHERE type='$type' AND name='$single'";
foreach ($db->query($query) as $row) {
    $array[]=$row[0];
    $types[$row[0]]=$row[1];
    }
}
elseif ($group) {
$dirb = "sqlite:dbf/nettemp.db";
$db = new PDO($dirb) or die("cannot open database");
$query = "select name,type FROM sensors WHERE ch_group='$group' AND charts='on'";
foreach ($db->query($query) as $row) {
    $array[]=$row[0];
    $types[$row[0]]=$row[1];
    }
}
else {
$dirb = "sqlite:dbf/nettemp.db";
$db = new PDO($dirb) or die("cannot open database");
$query = "select name,type FROM sensors WHERE type='$type' AND charts='on'";
foreach ($db->query($query) as $row) {
    $array[]=$row[0];
    $types[$row[0]]=$row[1];
    }
}

$js_array = json_encode($array);
echo "names = ". $js_array .";\n";
$types = json_encode($types);
echo "types = ". $types .";\n";

$query = $db->query("SELECT * FROM types");
$result_t = $query->fetchAll();
foreach($result_t as $ty){
       	if($ty['type']==$type) {
       		if(($nts_temp_scale != 'C')&&($ty['type']=='temp')){
       			echo "n_units = '". $ty['unit2'] ."';\n"; 
        		} else {
					echo "n_units = '". $ty['unit'] ."';\n"; 
       		}
        	}  
		}

?>


var hc = function () {
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
		    			 return '<span style="color:' + this.color + '">' + this.name + ': </span> <b>' + lastVal + n_units +'</b> </n>';
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
    	
	//OLD UNITS
	//
	//END


    $.getJSON('common/hc_data.php?type='+type+'&name='+name+'&max='+max+'&mode='+mode,  function (data) {

	if (max=="15min") { var xhour = "1min" }
	if (max=="hour") { var xhour = "hour" }
	if (max=="day") { var xhour = "hour" }
	if (max=="week") { var xhour = "day" }
	if (max=="month") { var xhour = "week" }
	if (max=="months") { var xhour = "month" }
	if (max=="year") { var xhour = "month" }
	if (max=="all") { var xhour = "year" }

	if (type=="gas"|| type=="water"|| type=="elec" && mode != "2" ) {
	    
            seriesOptions[i] = {
                name: name,
                data: data,
        	type: 'spline',
        	dataGrouping: {
    		enabled: false,
    		forced: false,
		units: [[xhour,[1]]]
		},
		tooltip: {
		    valueSuffix: n_units, 
                    valueDecimals: 3
                }
	    };
		
	} else if (type=="speed" || type=="gust" || type=="rainfall" && mode != "2" ){
		
		seriesOptions[i] = {
                name: name,
                data: data,
        	type: 'spline',
        	dataGrouping: {
    		enabled: true,
    		forced: true,
		
		},
		tooltip: {
		    valueSuffix: n_units, 
                    valueDecimals: 2
                }
	    };
	
	} else if (type=='gpio' || type=='host' || type=='relay' || type=="elec" ){
		seriesOptions[i] = {
                name: name,
                data: data,
		step: true,
		tooltip: {
		    valueSuffix: n_units, 
                    valueDecimals: 2
                }
	    };
	
	} else {
		seriesOptions[i] = {
                name: name,
                data: data,
		type: 'spline',
		tooltip: { 
		    valueSuffix: n_units, 
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
}


hc();
setInterval(function() {
	hc();
}, 60000);
</script>

