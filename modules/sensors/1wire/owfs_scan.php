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
				$local_rom=strtolower(str_replace(".","-",$fi));
				$db->exec("INSERT OR IGNORE INTO newdev (list) VALUES ('$local_rom')");
			}
		}
		echo "OWFS: ".count($files)." sensors found\n";
	} 
	
	} catch (Exception $e) {
    echo $date." Error.\n";
    echo $e;
    exit;
}


?>

