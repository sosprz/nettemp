<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
define("LOCAL","local"); 
$date = date("Y-m-d H:i:s"); 

if(file_exists("/opt/vc/bin/vcgencmd")) {
	$cmd = "/opt/vc/bin/vcgencmd measure_temp|cut -c 6-9";
	$output = shell_exec($cmd);
	$output = trim($output);
	if(is_numeric($output)) {
		include("$ROOT/receiver.php");
		$local_val = $output;
		$local_type = 'temp';
		$local_rom = "Raspberry_Pi";
		echo $date." ".$local_rom." ".$local_val."\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
	}
}
?>
