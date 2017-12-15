<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
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
	$path="/mnt/1wire/";
	if(!file_exists($path)) {
		echo $date." OWFS - OFF.\n";
		exit;
	}

	$files = array_diff(scandir($path), array('..', '.',));
	if(!empty($files)){
		$local_device='owfs';
		$current='';
		$local_type='temp';
		foreach($files as $fi) {
			if(preg_match('/^\d/', $fi)){
				$local_name=substr(rand(), 0, 4);
				if(!file_exists("$path/$fi/temperature")) {
					continue;
				}
				$local_val=file_get_contents("$path/$fi/temperature");
				$local_rom=strtolower(str_replace(".","-",$fi));
				$local_device='owfs';
				echo $date." OWFS - File: ".$fi.", Value: ".$local_val."\n";
				db($local_rom,$local_val,$local_type,$local_device,$local_current,$local_ip,$local_gpio,$local_i2c,$local_usb,$local_name);
			}
		}
	} else {
		echo $date." OWFS - No files.\n";
	}
	
	} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}?>
