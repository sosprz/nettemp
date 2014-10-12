<script type="text/JavaScript">
function timedRefresh(timeoutPeriod) {
    setTimeout("location.reload(true);",timeoutPeriod);
    }
</script>
<body onload="JavaScript:timedRefresh(60000);">

<span class="belka">&nbsp Select view<span class="okno">

<table><tr>
<td><a href="index.php?id=view&type=temp" ><button>Temp view</button></a></td>
<?php 
if (glob('/var/www/nettemp/db/*humi*.rrd')) {?>
<td><a href="index.php?id=view&type=humi" ><button>Humi view</button></a></td>
<?php }
if (glob('/var/www/nettemp/db/*pressure*.rrd')) {?>
<td><a href="index.php?id=view&type=pressure" ><button>Pressure view</button></a></td>
<?php }
if (glob('/var/www/nettemp/db/*altitude*.rrd')) {?>
<td><a href="index.php?id=view&type=altitude" ><button>Altitude view</button></a></td>
<?php }
if (glob('/var/www/nettemp/db/*snmp*.rrd')) {?>
<td><a href="index.php?id=view&type=snmp" ><button>Snmp view</button></a></td>
<?php }
if (glob('/var/www/nettemp/db/*kwh*')) {?>
<td><a href="index.php?id=view&type=kwh" ><button>kWh view</button></a></td>
<?php }
if (glob('/var/www/nettemp/db/*lux*.rrd')) {?>
<td><a href="index.php?id=view&type=lux" ><button>LUX view</button></a></td>
<?php } ?>
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
default: case '$art': include('modules/view/html/temp_view.php'); break;
case 'temp': include('modules/view/html/temp_view.php'); break;
case 'humi': include('modules/view/html/humi_view.php'); break;
case 'snmp': include('modules/view/html/snmp_view.php'); break;
case 'altitude': include('modules/view/html/altitude_view.php'); break;
case 'pressure': include('modules/view/html/pressure_view.php'); break;
case 'kwh': include('modules/kwh/html/kwh_charts.php'); break;
case 'lux': include('modules/view/html/lux_view.php'); break;
}
?>




