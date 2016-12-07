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
	$files = array_diff(scandir($path), array('..', '.',));
	if(!empty($files)){
		$device='';
		$current='';
		$local_type='temp';
		foreach($files as $fi) {
			if(preg_match('/^\d/', $fi)){
				$local_val=file_get_contents("$path/$fi/temperature");
				$local_rom=strtolower(str_replace(".","-",$fi));
				echo $date." OWFS - File: ".$fi.", Value: ".$local_val."\n";
				db($local_rom,$local_val,$local_type,$device,$current);
			}
		}
	} else {
		echo $date." OWFS - No files.\n";
	}
	
	} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}


?>

