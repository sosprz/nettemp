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
            height: 500px;
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
    
    if (typeof group === 'undefined') {
		var group = "";
	 }
	 if (typeof mode === 'undefined') {
		var mode = "";
	 }
	 if (typeof single === 'undefined') {
		var single = "";
	 }

			 if (type=='temp' && temp_scale=='F') {n_units = " °F"}
			 else if (type=='temp' && temp_scale=='C') {n_units = " °C" }
		    if (type=='humid') {n_units = " %"};
		    if (type=='press') {n_units = " hPa"};
		    if (type=='gpio') {n_units = " H/L"};
		    if (type=='host') {n_units = " ms"};
		    if (type=='system') {n_units = " %"};
		    if (type=='lux') {n_units = " lux"};
		    if (type=='water') {n_units = " m3"};
		    if (type=='gas') {n_units = " m3"};
	    	 if (type=='elec') {n_units = " kWh"};
		    if (type=='elec' && mode=='2') {n_units = " W"};
		    if (type=='hosts') {n_units = " ms"};
		    if (type=='volt') {n_units = " V"};
		    if (type=='amps') {n_units = " A"};
		    if (type=='watt') {n_units = " W"};
		    if (type=='dist') {n_units = " cm"};
		    if (type=='group') {n_units = " "};
            	    

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
      return d3.time.format('%m/%d %X')(new Date(d))
    });
    
    chart.x2Axis
    .tickFormat(function(d) {
      return d3.time.format('%m/%d ')(new Date(d))
    });

    d3.select('#chart1 svg')
        .datum(data)
        .call(chart);

    nv.utils.windowResize(chart.update);
        
          chart.xAxis.tickFormat(function(d) {
            return d3.time.format('%m/%d/%y')(new Date(d))
        });
        
       chart.interactiveLayer.tooltip.contentGenerator(function (d) {
         var html = "<h5><b>"+d3.time.format('%m/%d %X')(new Date(d.value))+"</b></h5>";

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