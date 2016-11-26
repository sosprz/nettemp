<?php
$ROOT=dirname(dirname(dirname(dirname(__FILE__))));
define("LOCAL","local"); 

try {
    $db = new PDO("sqlite:$ROOT/dbf/nettemp.db");
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "Could not connect to the database.";
    exit;
}
try {
    $query = $db->query("SELECT rom FROM sensors WHERE rom='Banana_Pi'");
    $result= $query->fetchAll();
    if ((count($result)) >= "1") 
    {
	$output = shell_exec("cat /sys/devices/platform/sunxi-i2c.0/i2c-0/0-0034/temp1_input| awk '{ getline;  printf '%1.2f\n', $1/1000}'");
	//$local_val = substr($output, 5, -3);
	$local_val = $output;
	$local_type = 'temp';
        $local_rom = 'Raspberry_Pi';
	include("$ROOT/receiver.php");
    }
} catch (Exception $e) {
    echo "Error.";
    exit;
}
//var_dump($rows->fetchAll());
?>