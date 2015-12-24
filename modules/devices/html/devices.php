<?php if(!isset($_SESSION['user'])){ header("Location: denied"); } ?>

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
<a href="index.php?id=devices&type=scan" ><button class="btn   <?php if (!file_exists('tmp/scan')) { echo "btn-danger"; } else { echo $art == 'scan' ? 'btn-info' : 'btn-default'; } ?> ">Scan</button></a>
<a href="index.php?id=devices&type=sensors" ><button class="btn  <?php echo $art == 'sensors' ? 'btn-info' : 'btn-default'; ?>">Devices</button></a>
<?php if ( $gpio == 'on' ) { ?>
<a href="index.php?id=devices&type=gpio" ><button class="btn <?php echo $art == 'gpio' ? 'btn-info' : 'btn-default'; ?>">GPIO</button></a>
	<?php } ?>
<a href="index.php?id=devices&type=snmp" ><button class="btn <?php echo $art == 'snmp' ? 'btn-info' : 'btn-default'; ?>">SNMP</button></a>
<a href="index.php?id=devices&type=ups" ><button class="btn <?php echo $art == 'ups' ? 'btn-info' : 'btn-default'; ?>">UPS</button></a>
<a href="index.php?id=devices&type=hosts" ><button class="btn <?php echo $art == 'hosts' ? 'btn-info' : 'btn-default'; ?>">Host monitoring</button></a>
<a href="index.php?id=devices&type=ipcam" ><button class="btn <?php echo $art == 'ipcam' ? 'btn-info' : 'btn-default'; ?>">IP Cam</button></a>
<a href="index.php?id=devices&type=usb" ><button class="btn <?php echo $art == 'usb' ? 'btn-info' : 'btn-default'; ?>">USB/Serial</button></a>
</[>


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
case 'ipcam' : include('modules/ipcam/ipcam.php'); break;
case 'usb' : include('modules/devices/html/usb.php'); break;
}
?>

