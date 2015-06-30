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
if (glob('db/*humid*.sql')) {?>
<a href="index.php?id=view&type=humid" ><button class="btn btn-default">Humidity</button></a>
<?php }
if (glob('db/*press*.sql')) {?>
<a href="index.php?id=view&type=pressure" ><button class="btn btn-default">Pressure</button></a>
<?php }
if (glob('db/*altitude*.sql')) {?>
<a href="index.php?id=view&type=altitude" ><button class="btn btn-default">Altitude view</button></a>
<?php }
if (glob('db/*snmp*.sql')) {?>
<a href="index.php?id=view&type=snmp" ><button class="btn btn-default">SNMP</button></a>
<?php }
if (glob('tmp/kwh/*.json')) {?>
<a href="index.php?id=view&type=kwh" ><button class="btn btn-default">kWh</button></a>
<?php }
if (glob('db/*lux*.sql')) {?>
<a href="index.php?id=view&type=lux" ><button class="btn btn-default">LUX</button></a>
<?php } 
if (glob('db/*gonoff*.sql')) {?>
<a href="index.php?id=view&type=gpio" ><button class="btn btn-default">GPIO</button></a>
<?php } 
if (glob('db/*host*.sql')) {?>
<a href="index.php?id=view&type=hosts" ><button class="btn btn-default">Hosts</button></a>
<?php } ?> 
<a href="index.php?id=view&type=system" ><button class="btn btn-default">System stats</button></a>
</p>


<?php  
switch ($art)
{ 
default: case '$art': include('modules/highcharts/html/temp_menu.php'); break;
case 'temp': include('modules/highcharts/html/temp_menu.php'); break;
case 'humid': include('modules/highcharts/html/humid_menu.php'); break;
case 'snmp': include('modules/highcharts/html/snmp_menu.php'); break;
case 'pressure': include('modules/highcharts/html/pressure_menu.php'); break;
case 'kwh': include('modules/kwh/html/kwh_charts.php'); break;
case 'lux': include('modules/highcharts/html/lux_menu.php'); break;
case 'gpio': include('modules/highcharts/html/gpio_menu.php'); break;
case 'hosts': include('modules/highcharts/html/hosts_menu.php'); break;
case 'system': include('modules/highcharts/html/system_menu.php'); break;
}
?>




