<?php $db = new PDO('sqlite:dbf/nettemp.db');
	$sth = $db->prepare("select * from settings ");
	$sth->execute();
	$result = $sth->fetchAll();
	foreach ($result as $a) {
	$kwh=$a["kwh"];
	$gpio=$a["gpio"];
	}
	?>

<span class="belka">&nbsp Select action<span class="okno">

<table><tr>
<td><a href="index.php?id=devices&type=sensors" ><button>Sensors</button></a></td>
<!--<td><a href="index.php?id=devices&type=scan" ><button>Add sensors</button></a></td>-->
<?php if ( $gpio == 'on' ) { ?>
<td><a href="index.php?id=devices&type=gpio" ><button>GPIO</button></a></td>
	<?php } ?>
<td><a href="index.php?id=devices&type=snmp" ><button>SNMP</button></a></td>
<td><a href="index.php?id=devices&type=ups" ><button>UPS</button></a></td>
<td><a href="index.php?id=devices&type=hosts" ><button>Host monitoring</button></a></td>
</tr>
</table>
</span>
</span>


<?php 
$art=isset($_GET['type']) ? $_GET['type'] : '';
?>
<?php  
switch ($art)
{ 
default: case '$art': include('modules/sensors/html/sensors.php'); break;
case 'scan': include('modules/sensors/html/sensors_device.php'); break;
case 'gpio': include('modules/gpio/html/gpio.php'); break;
case 'snmp': include('modules/sensors/snmp/html/snmp.php'); break;
case 'sensors': include('modules/sensors/html/sensors.php'); break;
case 'ups': include('modules/ups/html/ups.php'); break;
case 'hosts': include('modules/hosts/html/hosts.php'); break;

}
?>

