<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
define("LOCAL","local"); 

$local_rom = "Banana_Pi";
$cmd = "cat /sys/devices/platform/sunxi-i2c.0/i2c-0/0-0034/temp1_input| awk '{ getline;  printf '%1.2f\n', $1/1000}'";
$local_type = 'temp';

$date = date("Y-m-d H:i:s"); 
$msg = $date." ".$local_rom;

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $mgs."Could not connect to the database.\n";
    exit;
}

try {
    $query = $db->query("SELECT rom FROM sensors WHERE rom='$local_rom'");
    $result= $query->fetchAll();
    if ((count($result)) >= "1") 
    {
	$output = shell_exec($cmd);
	$output = trim($output);
	$local_val = $output;
	echo $msg." ".$local_val."\n";
	include("$ROOT/receiver.php");
	db($local_rom,$local_val,$local_type,$device,$current);
    }
    
} catch (Exception $e) {
    echo $msg." Error.\n";
    exit;
}
?>
