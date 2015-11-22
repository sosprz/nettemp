<script type="text/javascript" src="html/highcharts/highstock.js"></script>
<script type="text/javascript" src="html/highcharts/exporting.js"></script>
<script type="text/javascript" src="html/highcharts/dark-unica.js"></script>

<script type="text/JavaScript">
function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",timeoutPeriod);
    }
</script>
<!-- <body onload="JavaScript:timedRefresh(60000);"> -->

<?php 
$art = isset($_GET['type']) ? $_GET['type'] : '';
?>
<p>
<a href="index.php?id=view&type=temp" ><button class="btn btn-default">Temperature</button></a>
<?php 
if (glob('tmp/highcharts/humid*')) {?>
<a href="index.php?id=view&type=humid" ><button class="btn btn-default">Humidity</button></a>
<?php }
if (glob('tmp/highcharts/press*')) {?>
<a href="index.php?id=view&type=press" ><button class="btn btn-default">Pressure</button></a>
<?php }
if (glob('tmp/highcharts/altitude*')) {?>
<a href="index.php?id=view&type=altitude" ><button class="btn btn-default">Altitude view</button></a>
<?php }
if (glob('tmp/kwh/*.json')) {?>
<a href="index.php?id=view&type=kwh" ><button class="btn btn-default">kWh</button></a>
<?php }
if (glob('tmp/highcharts/elec*')) {?>
<a href="index.php?id=view&type=elec" ><button class="btn btn-default">Electricity</button></a>
<?php } 
if (glob('tmp/highcharts/water*')) {?>
<a href="index.php?id=view&type=water" ><button class="btn btn-default">Water</button></a>
<?php } 
if (glob('tmp/highcharts/gas*')) {?>
<a href="index.php?id=view&type=gas" ><button class="btn btn-default">Gas</button></a>
<?php } 
if (glob('tmp/highcharts/lux*')) {?>
<a href="index.php?id=view&type=lux" ><button class="btn btn-default">LUX</button></a>
<?php } 
if (glob('tmp/highcharts/gonoff*')) {?>
<a href="index.php?id=view&type=gonoff" ><button class="btn btn-default">GPIO</button></a>
<?php } 
if (glob('tmp/highcharts/host*')) {?>
<a href="index.php?id=view&type=host" ><button class="btn btn-default">Hosts</button></a>
<?php }
if (glob('tmp/highcharts/system*')) {?>
<a href="index.php?id=view&type=system" ><button class="btn btn-default">System stats</button></a>
<?php }
?>
</p>


<?php  
switch ($art)
{ 
default: case '$art': include('modules/highcharts/html/menu.php'); break;
case 'kwh': include('modules/kwh/html/kwh_charts.php'); break;
}
?>




