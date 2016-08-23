<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="html/nvd3/build/nv.d3.css" rel="stylesheet" type="text/css">
    <script src="html/nvd3/d3.min.js" charset="utf-8"></script>
    <script src="html/nvd3/build/nv.d3.js"></script>
    <script src="html/nvd3/src/tooltip.js"></script>
 

    <style>
        text {
            font: 12px sans-serif;
        }
        svg {
            display: block;
        }
       #chart1, svg {
            margin: 0px;
            padding: 0px;
	    <?php if($id == 'screen') { ?>
        	height: 300px;
	    <?php } else { ?>
		height: 500px;
	    <?php } ?>
            width: 100%;
        }
    </style>
</head>
<body>

<div id="chart1" class='with-3d-shadow with-transitions'>
    <svg></svg>
</div>

<script type="text/javascript"> 	 

<?php
$dirb = "sqlite:dbf/nettemp.db";
$dbh = new PDO($dirb) or die("cannot open database");
$query = "SELECT temp_scale FROM settings WHERE id='1'";
foreach ($dbh->query($query) as $row) {
	$temp_scale=$row['temp_scale'];
}
echo "temp_scale = '". $temp_scale ."';\n";
?>

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
		var max = "day";    
    }
    
    if (typeof group === 'undefined') {
		var group = "";
	 }
	 if (typeof mode === 'undefined') {
		var mode = "";
	 }
	 if (typeof single === 'undefined') {
		var single = "";
	 }
	 
<?php
parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $url);
if(!empty($url['type'])) {
	$type=$url['type'];
} else {
	$type="temp";
}
$query = $db->query("SELECT * FROM types");
$result_t = $query->fetchAll();
foreach($result_t as $ty){
       	if($ty['type']==$type) {
       		if(($temp_scale != 'C')&&($ty['type']=='temp')){
       			echo "var n_units = '". $ty['unit2'] ."';\n"; 
        		} else {
					echo "var n_units = '". $ty['unit'] ."';\n"; 
       		}
        	}  
		}
?>
            	    

d3.json('common/nvd3_data.php?type='+type+'&name='+name+'&max='+max+'&mode='+mode+'&group='+group+'&single='+single, function(data) {
  nv.addGraph(function() {
  	var chart = nv.models.lineWithFocusChart()
        .margin({top: 30, right: 20, bottom: 50, left: 60})
        .useInteractiveGuideline(true)
       
        
    chart.yAxis
   	  .axisLabel(n_units)
        .tickFormat(d3.format(',.2f'));
   
    chart.xAxis
    .axisLabel("Time")
    .tickFormat(function(d) {
      return d3.time.format.utc('%m/%d %X')(new Date(d))
    });
    
    chart.x2Axis
    .tickFormat(function(d) {
      return d3.time.format.utc('%m/%d')(new Date(d))
    });

    d3.select('#chart1 svg')
        .datum(data)
        .call(chart);

    nv.utils.windowResize(chart.update);
        
          chart.xAxis.tickFormat.utc(function(d) {
            return d3.time.format('%m/%d/%y')(new Date(d))
        });
        
       chart.interactiveLayer.tooltip.contentGenerator(function (d) {
         var html = "<h5><b>"+d3.time.format.utc('%m/%d %X')(new Date(d.value))+"</b></h5>";

          d.series.forEach(function(elem){
            html += "<h5 style='color:"+elem.color+"'>"+elem.key+" : <b>"+elem.value+' '+n_units+"</b></h5>";
          })
          //html += "</ul>"
          return html;
        })
    
   
    return chart;
  });
});

</script>
</body>
</html>