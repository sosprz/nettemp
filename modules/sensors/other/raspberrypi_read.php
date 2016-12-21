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
		$local_device = 'rpi';
		echo $date." ".$local_rom." ".$local_val."\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
	}
}


if(file_exists("/sys/devices/platform/sunxi-i2c.0/i2c-0/0-0034/temp1_input")) {
	$cmd = "cat /sys/devices/platform/sunxi-i2c.0/i2c-0/0-0034/temp1_input";
	$output = shell_exec($cmd);
    $output = trim($output)/1000;
    if(is_numeric($output)) {
		include("$ROOT/receiver.php");
		$output = number_format($output, 2, '.', '');
		$local_rom = "Banana_Pi";
		$local_val = $output;
		$local_type = 'temp';
		$local_device = 'banana';
		echo $date." ".$local_rom." ".$local_val."\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
	}
}



?>
