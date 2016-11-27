<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
define("LOCAL","local"); 

$local_rom = "Raspberry_Pi";
$cmd = "/opt/vc/bin/vcgencmd measure_temp|cut -c 6-9";
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
    }
    
} catch (Exception $e) {
    echo $msg." Error.\n";
    exit;
}
?>
