<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
define("LOCAL","local"); 

$rom = "Banana_Pi";
$cmd = "cat /sys/devices/platform/sunxi-i2c.0/i2c-0/0-0034/temp1_input| awk '{ getline;  printf '%1.2f\n', $1/1000}'";
$local_type = 'temp';

$date = date("Y-m-d H:i:s"); 
$msg = $date." ".$rom;

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo $mgs."Could not connect to the database.\n";
    exit;
}

try {
    $query = $db->query("SELECT rom FROM sensors WHERE rom='$rom'");
    $result= $query->fetchAll();
    if ((count($result)) >= "1") 
    {
	$output = shell_exec($cmd);
	$output = trim($output);
	$local_val = $output;
        $local_rom = $rom;
	echo $msg." ".$local_val."\n";
	include("$ROOT/receiver.php");
    }
    
} catch (Exception $e) {
    echo $msg."Error.\n";
    exit;
}
?>
