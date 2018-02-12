<?php if(!isset($_SESSION['user'])){ header("Location: denied"); } ?>
<?php $art = (!isset($art) || $art == '') ? 'devices' : $art; ?>
<p>
<a href="index.php?id=device&type=scan" ><button class="btn btn-xs btn-default <?php if (!file_exists('tmp/scan')) { echo "btn-danger"; } else { echo $art == 'scan' ? 'active ' : ''; } ?> ">Scan</button></a>
<a href="index.php?id=device&type=devices" ><button class="btn btn-xs btn-default <?php echo $art == 'devices' ? 'active' : ''; ?>">Devices</button></a>
<?php if ( $nts_gpio == 'on' ) { ?>
<a href="index.php?id=device&type=gpio" ><button class="btn btn-xs btn-default <?php echo $art == 'gpio' ? 'active' : ''; ?>">GPIO</button></a>
	<?php } ?>
<a href="index.php?id=device&type=snmp" ><button class="btn btn-xs btn-default <?php echo $art == 'snmp' ? 'active' : ''; ?>">SNMP</button></a>
<a href="index.php?id=device&type=hosts" ><button class="btn btn-xs btn-default <?php echo $art == 'hosts' ? 'active' : ''; ?>">Host monitoring</button></a>
<a href="index.php?id=device&type=ipcam" ><button class="btn btn-xs btn-default <?php echo $art == 'ipcam' ? 'active' : ''; ?>">IP Cam</button></a>
<a href="index.php?id=device&type=usb" ><button class="btn btn-xs btn-default <?php echo $art == 'usb' ? 'active' : ''; ?>">USB/Serial</button></a>
<a href="index.php?id=device&type=lcd" ><button class="btn btn-xs btn-default <?php echo $art == 'lcd' ? 'active' : ''; ?>">LCD</button></a>
<a href="index.php?id=device&type=i2c" ><button class="btn btn-xs btn-default <?php echo $art == 'i2c' ? 'active' : ''; ?>">I2C</button></a>
<a href="index.php?id=device&type=rs485" ><button class="btn btn-xs btn-default <?php echo $art == 'rs485' ? 'active' : ''; ?>">RS485</button></a>
<a href="index.php?id=device&type=ups" ><button class="btn btn-xs btn-default <?php echo $art == 'ups' ? 'active' : ''; ?>">UPS</button></a>
<a href="index.php?id=device&type=upsnt" ><button class="btn btn-xs btn-default <?php echo $art == 'upsnt' ? 'active' : ''; ?>">UPS NT</button></a>
<a href="index.php?id=device&type=counters" ><button class="btn btn-xs btn-default <?php echo $art == 'counters' ? 'active' : ''; ?>">Counters</button></a>
<a href="index.php?id=device&type=thing" ><button class="btn btn-xs btn-default <?php echo $art == 'thing' ? 'active' : ''; ?>">Thing Speak</button></a>
</p>

<?php
switch ($art)
{
default: case '$art': include('modules/sensors/html/sensors.php'); break;
case 'scan': include('modules/devices/html/scan.php'); break;
case 'gpio': include('modules/gpio/html/gpio.php'); break;
case 'snmp': include('modules/sensors/snmp/html/snmp.php'); break;
case 'device': include('modules/sensors/html/sensors.php'); break;
case 'ups': include('modules/ups/html/ups.php'); break;
case 'hosts': include('modules/hosts/html/hosts.php'); break;
case 'ipcam' : include('modules/ipcam/ipcam.php'); break;
case 'usb' : include('modules/devices/html/usb.php'); break;
case 'i2c' : include('modules/devices/html/i2c.php'); break;
case 'lcd' : include('modules/devices/html/lcdswitcher.php'); break;
case 'rs485' : include('modules/devices/html/rs485.php'); break;
case 'upsnt' : include('modules/devices/html/upsnt.php'); break;
case 'counters' : include('modules/devices/html/counters.php'); break;
case 'thing' : include('modules/thingspeak/html/thing.php'); break;

}
?>
