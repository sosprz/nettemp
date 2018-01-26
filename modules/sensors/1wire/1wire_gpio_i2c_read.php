<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
 
define("LOCAL","local");
$date = date("Y-m-d H:i:s"); 

include(dirname(dirname(dirname(dirname(__FILE__))))."/receiver.php");
$path="/sys/bus/w1/devices/";
if(!file_exists($path)) {
	echo $date." 1wire - OFF.\n";
	exit;
}
$files = array_diff(scandir($path), array('..', '.',));
if(!empty($files)){
	foreach($files as $rom) {
	     if (file_exists("/sys/bus/w1/devices/".$rom."/w1_slave")) {
		 $cmd="cat /sys/bus/w1/devices/".$rom."/w1_slave | grep t= | cut -f2 -d= | awk '{print $1/1000}'";
		 $output = shell_exec($cmd);
		 $output = trim($output);
		 $output = number_format($output, 1, '.', '');
		 $local_val = $output;
		 $local_type = 'temp';
		 $local_rom = $rom;
		 $local_device='1wire';
		 echo $date." ".$rom." ".$local_val."\n";
		 db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
	     }
	}
}



?>
