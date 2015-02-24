<script type="text/JavaScript">
function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",timeoutPeriod);
    }
</script>
<body onload="JavaScript:timedRefresh(60000);">

<span class="belka">&nbsp Select view<span class="okno">

<table><tr>
<td><a href="index.php?id=view&type=temp" ><button>Temperature</button></a></td>
<?php 
if (glob('db/*humid*.sql')) {?>
<td><a href="index.php?id=view&type=humid" ><button>Humidity</button></a></td>
<?php }
if (glob('db/*pressure*.sql')) {?>
<td><a href="index.php?id=view&type=pressure" ><button>Pressure</button></a></td>
<?php }
if (glob('db/*altitude*.sql')) {?>
<td><a href="index.php?id=view&type=altitude" ><button>Altitude view</button></a></td>
<?php }
if (glob('db/*snmp*.sql')) {?>
<td><a href="index.php?id=view&type=snmp" ><button>SNMP</button></a></td>
<?php }
if (glob('tmp/kwh/*.json')) {?>
<td><a href="index.php?id=view&type=kwh" ><button>kWh</button></a></td>
<?php }
if (glob('db/*lux*.sql')) {?>
<td><a href="index.php?id=view&type=lux" ><button>LUX</button></a></td>
<?php } 
if (glob('tmp/highcharts/*gpio*.json')) {?>
<td><a href="index.php?id=view&type=gpio" ><button>GPIO</button></a></td>
<?php } ?> 
<td><a href="index.php?id=view&type=hosts" ><button>Hosts</button></a></td>
<td><a href="index.php?id=view&type=system" ><button>System stats</button></a></td>
</tr>
</table>
</span>
</span>



<?php 
$art = isset($_GET['type']) ? $_GET['type'] : '';
?>
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




