<?php
$ROOT=dirname(dirname(dirname(dirname(dirname(__FILE__)))));
$date = date("Y-m-d H:i:s"); 
define("LOCAL","local");


try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $date." Could not connect to the database.\n";
    exit;
}

try {
    include("$ROOT/receiver.php");
    $query = $db->query("SELECT dev FROM usb WHERE device='SDS011'");
    $result= $query->fetchAll();
    foreach($result as $r) {
		$dev0=$r['dev'];
    }
    if($dev0=='none'){
		echo $date." No RS485 USB Device.\n";
		exit;
	}
    $dev=str_replace("/dev/","",$dev0);
	echo $date." SDS011 ".$dev0." \n";
    	$cmd="$ROOT/modules/sensors/USB/SDS011/nova_sensor.py $dev0";
		$res=shell_exec($cmd);
		$res = preg_split ('/\s+/', $res);
		foreach ($res as $l) {
			$line[]=trim($l);
		}
	
		$local_type='dust';
		$local_rom="usb_".$dev."pm25_".$local_type;
		$local_val=$line[0];
		$local_device='usb';
		$local_usb=$dev0;
		echo $date." PM25 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
		
		$local_type='dust';
		$local_rom="usb_".$dev."pm10_".$local_type;
		$local_val=$line[1];
		$local_device='usb';
		$local_usb=$dev0;
		echo $date." PM10 ".$local_val." ".$local_type.".\n";
		db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);




} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}
?>
