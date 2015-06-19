<?php $db = new PDO('sqlite:dbf/nettemp.db');
	$sth = $db->prepare("select * from settings ");
	$sth->execute();
	$result = $sth->fetchAll();
	foreach ($result as $a) {
	$kwh=$a["kwh"];
	$gpio=$a["gpio"];
	}
	?>
<p>
<a href="index.php?id=devices&type=scan" ><button class="btn   <?php if (!file_exists('tmp/scan')) { echo "btn-danger"; } else { echo "btn-default"; } ?> ">Device scan</button></a>
<a href="index.php?id=devices&type=sensors" ><button class="btn btn-default">Sensors</button></a>
<?php if ( $gpio == 'on' ) { ?>
<a href="index.php?id=devices&type=gpio" ><button class="btn btn-default">GPIO</button></a>
	<?php } ?>
<a href="index.php?id=devices&type=snmp" ><button class="btn btn-default">SNMP</button></a>
<a href="index.php?id=devices&type=ups" ><button class="btn btn-default">UPS</button></a>
<a href="index.php?id=devices&type=hosts" ><button class="btn btn-default">Host monitoring</button></a>
</[>

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

