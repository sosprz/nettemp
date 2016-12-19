<?php
$ROOT=dirname(dirname(dirname(dirname(dirname(__FILE__)))));
 
define("LOCAL","local");
$date = date("Y-m-d H:i:s"); 


try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

try {
	include("$ROOT/receiver.php");
    $query = $db->query("select mode from gpio WHERE gpio='23' or gpio='24' and mode='dist'");
    $result= $query->fetchAll();
    $count = count($result);
		if ( $count == '2'){
			$cmd=("$ROOT/modules/sensors/GPIO/HCS04/hcs04.py");
			$out=shell_exec($cmd);
			$local_val=trim($out);

			$local_rom='gpio_2324_dist';
			$local_type='dist';
			$local_device='gpio';
		    $local_gpio='23-24';
			echo $date." Rom: ".$local_rom." Value:".$local_val."\n";
			db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);

		} else {
			echo $date." No distance configured on GPIO 23 && 24.\n";
		}
} catch (Exception $e) {
echo $date." Error.\n";
echo $e;
exit;
}
?>
